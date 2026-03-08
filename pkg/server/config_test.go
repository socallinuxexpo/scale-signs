package server

import (
	"strings"
	"testing"
	"time"
)

func TestNewConfig(t *testing.T) {
	// Define test cases
	tests := []struct {
		name            string
		port            string
		jsonEndpoint    string
		refreshInterval int
		wantErr         bool
		errContains     string
	}{
		// Valid cases
		{
			name:            "Valid configuration",
			port:            "8080",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         false,
		},
		{
			name:            "Valid configuration with minimum values",
			port:            "1",
			jsonEndpoint:    "http://localhost/schedule.json",
			refreshInterval: 1,
			wantErr:         false,
		},
		{
			name:            "Valid configuration with maximum port",
			port:            "65535",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 10,
			wantErr:         false,
		},

		// Invalid port cases
		{
			name:            "Invalid port - not a number",
			port:            "abc",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "port must be a number",
		},
		{
			name:            "Invalid port - zero",
			port:            "0",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "port must be between 1 and 65535",
		},
		{
			name:            "Invalid port - negative",
			port:            "-80",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "port must be between 1 and 65535",
		},
		{
			name:            "Invalid port - too large",
			port:            "65536",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "port must be between 1 and 65535",
		},

		// Invalid URL cases
		{
			name:            "Invalid JSON URL - empty",
			port:            "8080",
			jsonEndpoint:    "",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "invalid URL format",
		},
		{
			name:            "Invalid JSON URL - no scheme",
			port:            "8080",
			jsonEndpoint:    "example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "invalid URL format",
		},
		{
			name:            "Invalid JSON URL - wrong scheme",
			port:            "8080",
			jsonEndpoint:    "ftp://example.com/schedule.json",
			refreshInterval: 5,
			wantErr:         true,
			errContains:     "URL scheme must be http or https",
		},

		// Invalid refresh interval cases
		{
			name:            "Invalid refresh interval - zero",
			port:            "8080",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: 0,
			wantErr:         true,
			errContains:     "refresh interval must be at least 1 minute",
		},
		{
			name:            "Invalid refresh interval - negative",
			port:            "8080",
			jsonEndpoint:    "https://example.com/schedule.json",
			refreshInterval: -5,
			wantErr:         true,
			errContains:     "refresh interval must be at least 1 minute",
		},
	}

	// Run tests
	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			config, err := NewConfig(tt.port, tt.jsonEndpoint, tt.refreshInterval)

			// Check if error was expected
			if tt.wantErr {
				if err == nil {
					t.Errorf("❌ NewConfig() expected error for case %s, but got nil", tt.name)
					return
				}

				// Check if error contains expected text
				if tt.errContains != "" && !strings.Contains(err.Error(), tt.errContains) {
					t.Errorf("❌ NewConfig() error = %v, want error containing %s", err, tt.errContains)
				}
				return
			}

			// If no error was expected, but got one
			if err != nil {
				t.Errorf("❌ NewConfig() unexpected error for case %s: %v", tt.name, err)
				return
			}

			// Verify the config was created correctly
			expectedAddr := ":" + tt.port
			if config.Address != expectedAddr {
				t.Errorf("❌ Address = %v, want %v", config.Address, expectedAddr)
			} else {
				t.Logf("✅ Address correctly set to %v", config.Address)
			}

			if config.ScheduleJSONurl != tt.jsonEndpoint {
				t.Errorf("❌ ScheduleJSONurl = %v, want %v", config.ScheduleJSONurl, tt.jsonEndpoint)
			} else {
				t.Logf("✅ ScheduleJSONurl correctly set to %v", config.ScheduleJSONurl)
			}

			expectedDuration := time.Duration(tt.refreshInterval) * time.Minute
			if config.RefreshInterval != expectedDuration {
				t.Errorf("❌ RefreshInterval = %v, want %v", config.RefreshInterval, expectedDuration)
			} else {
				t.Logf("✅ RefreshInterval correctly set to %v", config.RefreshInterval)
			}

			t.Logf("✅ Configuration validated successfully for case: %s", tt.name)
		})
	}
}

// Test individual validation functions directly for more specific cases
func TestValidatePort(t *testing.T) {
	tests := []struct {
		port    string
		wantErr bool
	}{
		{"8080", false},
		{"1", false},
		{"65535", false},
		{"0", true},
		{"-1", true},
		{"65536", true},
		{"abc", true},
		{"8080a", true},
	}

	for _, tt := range tests {
		t.Run("port_"+tt.port, func(t *testing.T) {
			err := validatePort(tt.port)
			if (err != nil) != tt.wantErr {
				t.Errorf("❌ validatePort(%s) error = %v, wantErr %v", tt.port, err, tt.wantErr)
			} else {
				t.Logf("✅ validatePort(%s) returned expected result: %v", tt.port, err)
			}
		})
	}
}

func TestValidateURL(t *testing.T) {
	tests := []struct {
		url     string
		wantErr bool
	}{
		{"http://example.com", false},
		{"https://example.com/path", false},
		{"http://localhost:8080", false},
		{"", true},
		{"example.com", true},
		{"ftp://example.com", true},
		{"http://", true},
		{"http:///path", true},
	}

	for _, tt := range tests {
		t.Run("url_"+strings.ReplaceAll(tt.url, "://", "_"), func(t *testing.T) {
			err := validateURL(tt.url)
			if (err != nil) != tt.wantErr {
				t.Errorf("❌ validateURL(%s) error = %v, wantErr %v", tt.url, err, tt.wantErr)
			} else {
				t.Logf("✅ validateURL(%s) returned expected result: %v", tt.url, err)
			}
		})
	}
}

func TestValidateRefreshInterval(t *testing.T) {
	tests := []struct {
		interval int
		wantErr  bool
	}{
		{1, false},
		{5, false},
		{60, false},
		{61, false}, // Should only log a warning, not error
		{0, true},
		{-1, true},
	}

	for _, tt := range tests {
		t.Run("interval_"+string(rune(tt.interval)), func(t *testing.T) {
			err := validateRefreshInterval(tt.interval)
			if (err != nil) != tt.wantErr {
				t.Errorf("❌ validateRefreshInterval(%d) error = %v, wantErr %v", tt.interval, err, tt.wantErr)
			} else {
				t.Logf("✅ validateRefreshInterval(%d) returned expected result: %v", tt.interval, err)
			}
		})
	}
}
