package server

import (
	"fmt"
	"log"
	"net/url"
	"strconv"
	"time"
)

// Config server configuration
type Config struct {
	Address         string
	ScheduleJSONurl string
	RefreshInterval time.Duration
}

// NewConfig creates a new Config with validation
func NewConfig(listenPort string, jsonEndpoint string, refreshInterval int) (Config, error) {
	// Validate port
	if err := validatePort(listenPort); err != nil {
		return Config{}, fmt.Errorf("invalid port: %w", err)
	}

	// Validate JSON endpoint URL
	if err := validateURL(jsonEndpoint); err != nil {
		return Config{}, fmt.Errorf("invalid port: %w", err)
	}

	// Validate refresh interval
	if err := validateRefreshInterval(refreshInterval); err != nil {
		return Config{}, fmt.Errorf("invalid refresh interval: %w", err)
	}

	return Config{
		Address:         fmt.Sprintf(":%v", listenPort),
		ScheduleJSONurl: jsonEndpoint,
		RefreshInterval: time.Duration(refreshInterval) * time.Minute,
	}, nil
}

// validatePort checks if the port is valid
func validatePort(port string) error {
	// Convert to integer
	portNum, err := strconv.Atoi(port)
	if err != nil {
		return fmt.Errorf("port must be a number: %v", err)
	}

	// Check port range
	if portNum < 1 || portNum > 65535 {
		return fmt.Errorf("port must be between 1 and 65535, got %d", portNum)
	}

	return nil
}

// validateURL checks if the URL is valid
func validateURL(urlStr string) error {
	_, err := url.ParseRequestURI(urlStr)
	if err != nil {
		return fmt.Errorf("invalid URL format: %v", err)
	}

	u, err := url.Parse(urlStr)
	if err != nil {
		return fmt.Errorf("unable to parse URL: %v", err)
	}

	if u.Scheme != "http" && u.Scheme != "https" {
		return fmt.Errorf("URL scheme must be http or https")
	}

	if u.Host == "" {
		return fmt.Errorf("URL must have a host")
	}

	return nil
}

// validateRefreshInterval checks if the refresh interval is valid
func validateRefreshInterval(interval int) error {
	if interval < 1 {
		return fmt.Errorf("refresh interval must be at least 1 minute, got %d", interval)
	}

	if interval > 60 {
		// This is just a warning, not an error
		log.Printf("Warning: Refresh interval is set to %d minutes, which is quite long", interval)
	}

	return nil
}
