package server

import (
	"log"
	"net/http"

	"github.com/gin-gonic/gin"
	"github.com/kylerisse/go-signs/pkg/display"
	"github.com/kylerisse/go-signs/pkg/schedule"
	"github.com/kylerisse/go-signs/pkg/sponsor"
)

// setupRoutes configures all routes for the application
func setupRoutes(r *gin.Engine, s *schedule.Schedule) {
	// Set up sponsor handling
	sponsorManager, err := sponsor.NewManager()
	if err != nil {
		log.Fatal(err)
	}

	// Configure all routes
	r.GET("/sponsors/diamond", gin.WrapF(sponsorManager.HandleDiamond))
	r.GET("/sponsors/platinum", gin.WrapF(sponsorManager.HandlePlatinum))
	r.GET("/sponsors/gold", gin.WrapF(sponsorManager.HandleGold))
	r.GET("/sponsors/all", gin.WrapF(sponsorManager.HandleAllSponsors))
	r.StaticFS("/sponsors/images", sponsorManager.GetFS())

	r.GET("/schedule", gin.WrapF(s.HandleScheduleAll))

	// Static files - this must come last as it's a catch-all
	// Use a NoRoute handler instead of StaticFS to avoid path conflicts
	r.NoRoute(func(c *gin.Context) {
		fileServer := http.FileServer(display.GetFS())
		fileServer.ServeHTTP(c.Writer, c.Request)
	})
}
