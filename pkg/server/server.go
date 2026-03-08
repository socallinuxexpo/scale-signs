package server

import (
	"context"
	"log"
	"net/http"
	"os"
	"os/signal"
	"syscall"
	"time"

	"github.com/gin-gonic/gin"
	"github.com/kylerisse/go-signs/pkg/schedule"
)

// Server is the main webserver process
type Server struct {
	httpd       *http.Server
	stopRefresh chan struct{}
	refreshDone chan struct{}
}

// NewServer sets up the cron runs for schedule and sponsors returns the *Server
func NewServer(c Config) *Server {
	sch := schedule.NewSchedule(c.ScheduleJSONurl)

	// Channels for coordinating shutdown
	stopRefresh := make(chan struct{})
	refreshDone := make(chan struct{})

	// Start the schedule refresh goroutine
	go func() {
		sch.UpdateFromJSON()
		ticker := time.NewTicker(c.RefreshInterval)
		defer ticker.Stop()
		defer close(refreshDone)

		for {
			select {
			case <-ticker.C:
				sch.UpdateFromJSON()
			case <-stopRefresh:
				log.Println("Schedule refresh routine stopping...")
				return
			}
		}
	}()

	gin.SetMode(gin.ReleaseMode)
	router := gin.Default()
	setupRoutes(router, sch)

	srv := &http.Server{
		Handler:      router,
		Addr:         c.Address,
		WriteTimeout: 15 * time.Second,
		ReadTimeout:  15 * time.Second,
	}

	return &Server{
		httpd:       srv,
		stopRefresh: stopRefresh,
		refreshDone: refreshDone,
	}
}

// ListenAndServe starts the server and sets up graceful shutdown
func (s *Server) ListenAndServe() error {
	// Set up channel for shutdown signals
	quit := make(chan os.Signal, 1)
	signal.Notify(quit, syscall.SIGINT, syscall.SIGTERM)

	// Start HTTP server in a goroutine
	serverErrors := make(chan error, 1)
	go func() {
		log.Printf("Listening on %s", s.httpd.Addr)
		if err := s.httpd.ListenAndServe(); err != nil && err != http.ErrServerClosed {
			serverErrors <- err
		}
	}()

	// Wait for termination signal or server error
	select {
	case <-quit:
		log.Println("Shutdown signal received...")
	case err := <-serverErrors:
		log.Printf("Server error: %v", err)
		return err
	}

	// Begin graceful shutdown
	log.Println("Shutting down server...")

	// Create a deadline for shutdown
	ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
	defer cancel()

	// Signal refresh goroutine to stop and wait for it to finish
	close(s.stopRefresh)

	// Wait for refresh goroutine with timeout
	select {
	case <-s.refreshDone:
		log.Println("Refresh routine stopped successfully")
	case <-time.After(5 * time.Second):
		log.Println("Refresh routine stop timed out")
	}

	// Shut down HTTP server with timeout
	if err := s.httpd.Shutdown(ctx); err != nil {
		log.Printf("HTTP server shutdown error: %v", err)
		return err
	}

	log.Println("Server shutdown complete")
	return nil
}
