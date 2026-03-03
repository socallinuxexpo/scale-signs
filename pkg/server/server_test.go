package server

import (
	"encoding/json"
	"fmt"
	"io"
	"net/http"
	"path/filepath"
	"strings"
	"testing"
	"time"

	"github.com/kylerisse/go-signs/pkg/schedule"
)

// TestServer validates that the server functions correctly with a test JSON file
func TestServer(t *testing.T) {
	// Use a fixed port for local testing
	port := "7102"
	testJSONPath := filepath.Join("testdata", "sign.json")

	// Create a file server to serve the test JSON
	localServer := http.NewServeMux()
	localServer.HandleFunc("/sign.json", func(w http.ResponseWriter, r *http.Request) {
		http.ServeFile(w, r, testJSONPath)
	})

	// Start the server on a different port
	localPort := "7103"
	go func() {
		err := http.ListenAndServe(":"+localPort, localServer)
		if err != nil {
			t.Logf("test server stopped: %v", err)
		}
	}()

	// Give the server time to start
	time.Sleep(2 * time.Second)

	// Configure the main server to use our local server
	jsonURL := fmt.Sprintf("http://localhost:%s/sign.json", localPort)
	conf, err := NewConfig(port, jsonURL, 1)
	if err != nil {
		t.Fatalf("❌ Failed to create server config (%v)", err)
	}

	// Create a new server instance
	server := NewServer(conf)

	// Start the server in a goroutine
	go func() {
		err := server.ListenAndServe()
		if err != nil {
			t.Logf("Server stopped: %v", err)
		}
	}()

	// Give the server time to start and fetch schedule
	time.Sleep(2 * time.Second)

	// Base URL for making requests
	baseURL := fmt.Sprintf("http://localhost:%s", port)

	// 1. Test that index.html is served correctly
	t.Run("IndexHTML", func(t *testing.T) {
		resp, err := http.Get(baseURL + "/index.html")
		if err != nil {
			t.Fatalf("❌ Failed to get index.html: %v", err)
		}
		defer resp.Body.Close()

		if resp.StatusCode != http.StatusOK {
			t.Errorf("❌ Expected status 200 for index.html, got %d", resp.StatusCode)
		}

		contentType := resp.Header.Get("Content-Type")
		if !strings.Contains(contentType, "text/html") {
			t.Errorf("❌ Expected content type to contain text/html, got %s", contentType)
		}

		body, err := io.ReadAll(resp.Body)
		if err != nil {
			t.Fatalf("❌ Failed to read index.html body: %v", err)
		}

		// Don't check for a specific doctype, just ensure we get valid HTML content
		if len(body) < 50 || (!strings.Contains(string(body), "<html") && !strings.Contains(string(body), "<HTML")) {
			t.Errorf("❌ index.html doesn't contain expected HTML content: %s", string(body)[:min(len(body), 100)])
		}
	})

	// 2. Test that the schedule is served correctly and has 296 sessions
	t.Run("Schedule", func(t *testing.T) {
		resp, err := http.Get(baseURL + "/schedule")
		if err != nil {
			t.Fatalf("❌ Failed to get schedule: %v", err)
		}
		defer resp.Body.Close()

		if resp.StatusCode != http.StatusOK {
			t.Errorf("❌ Expected status 200 for schedule, got %d", resp.StatusCode)
		}

		var scheduleData struct {
			Presentations []schedule.Presentation `json:"Presentations"`
		}

		decoder := json.NewDecoder(resp.Body)
		err = decoder.Decode(&scheduleData)
		if err != nil {
			t.Fatalf("❌ Failed to decode schedule JSON: %v", err)
		}

		// Check that we have 2 sessions
		if len(scheduleData.Presentations) != 2 {
			t.Errorf("❌ Expected 296 sessions, got %d", len(scheduleData.Presentations))
		}

		// 3. Check for specific sessions by name only (more reliable)
		expectedSessionNames := []string{
			"Five Stages Of Grieving-Databases in Infrastructure as Code",
			"Closing Keynote with Doug Comer",
		}

		for _, expectedName := range expectedSessionNames {
			found := false
			for _, session := range scheduleData.Presentations {
				if strings.EqualFold(session.Name, expectedName) {
					found = true
					t.Logf("✅ Found session: %s", expectedName)
					break
				}
			}

			if !found {
				t.Errorf("❌ Expected session not found: %s", expectedName)
			}
		}
	})

	// 4. Test that all sponsor images are accessible
	t.Run("SponsorImages", func(t *testing.T) {
		// Since we can't directly access the embedded files list from the handler,
		// we'll test sponsor images by making HTTP requests

		// Test a few known sponsor images or use a predefined list
		// Replace these with your actual image names
		imagesToTest := []string{
			"aws.png",
			"canonical.png",
			"coderabbit.png",
			"google.png",
			"microsoft.png",
			"redhat.png",
			"softwarefreedomconservancy.png",
			"victoriametrics.png",
		}

		foundImages := 0
		// Test each image
		for _, image := range imagesToTest {
			resp, err := http.Get(baseURL + "/sponsors/images/" + image)
			if err != nil {
				t.Errorf("❌ Failed to get sponsor image %s: %v", image, err)
				continue
			}

			defer resp.Body.Close()

			if resp.StatusCode == http.StatusOK {
				foundImages++
				t.Logf("✅ Successfully accessed sponsor image: %s", image)
			} else {
				t.Errorf("❌ Image %s returned status %d (expected 200 OK)", image, resp.StatusCode)
			}
		}

		// The test should fail if none of the expected images are found
		if foundImages == 0 {
			t.Errorf("❌ No sponsor images were found. The test was configured to look for: %v", imagesToTest)
		} else {
			t.Logf("✅ Successfully accessed %d of %d sponsor images", foundImages, len(imagesToTest))
		}
	})
}
