package sponsor

import (
	"encoding/json"
	"io"
	"net/http"
	"net/http/httptest"
	"os"
	"path/filepath"
	"testing"
)

func TestSponsorEndpoints(t *testing.T) {
	// Create a new manager
	manager, err := NewManager()
	if err != nil {
		t.Fatalf("❌ Failed to create sponsor manager: %v", err)
	}

	// Create router for testing
	mux := http.NewServeMux()
	mux.HandleFunc("/sponsors/gold/", manager.HandleGold)
	mux.HandleFunc("/sponsors/platinum/", manager.HandlePlatinum)
	mux.HandleFunc("/sponsors/diamond/", manager.HandleDiamond)
	mux.Handle("/sponsors/images/", http.StripPrefix("/sponsors/images/", manager.ImageHandler()))

	// Create test server
	server := httptest.NewServer(mux)
	defer server.Close()

	// Create a temporary directory to save images for verification
	tempDir, err := os.MkdirTemp("", "sponsor-test")
	if err != nil {
		t.Fatalf("❌ Failed to create temp directory: %v", err)
	}
	defer os.RemoveAll(tempDir)

	// Test Gold sponsors endpoint
	t.Run("Gold Sponsors", func(t *testing.T) {
		testSponsorEndpoint(t, server.URL+"/sponsors/gold/", server.URL+"/sponsors/images/", tempDir)
	})

	// Test Platinum sponsors endpoint
	t.Run("Platinum Sponsors", func(t *testing.T) {
		testSponsorEndpoint(t, server.URL+"/sponsors/platinum/", server.URL+"/sponsors/images/", tempDir)
	})

	// Test Diamond sponsors endpoint
	t.Run("Diamond Sponsors", func(t *testing.T) {
		testSponsorEndpoint(t, server.URL+"/sponsors/diamond/", server.URL+"/sponsors/images/", tempDir)
	})
}

func testSponsorEndpoint(t *testing.T, endpointURL, imagesBaseURL, tempDir string) {
	// Make request to the sponsor endpoint
	resp, err := http.Get(endpointURL)
	if err != nil {
		t.Fatalf("❌ Failed to make request to %s: %v", endpointURL, err)
	}
	defer resp.Body.Close()

	// Check status code
	if resp.StatusCode != http.StatusOK {
		t.Errorf("❌ Expected status OK, got %v", resp.Status)
	}

	// Decode JSON response
	var sponsorFiles []string
	if err := json.NewDecoder(resp.Body).Decode(&sponsorFiles); err != nil {
		t.Fatalf("❌ Failed to decode JSON response: %v", err)
	}

	// Make sure we got some sponsors
	if len(sponsorFiles) == 0 {
		t.Errorf("❌ No sponsors returned from endpoint %s", endpointURL)
	}

	t.Logf("✅ Found %d sponsors from %s", len(sponsorFiles), endpointURL)

	// Create a map to track if each sponsor exists
	sponsorExists := make(map[string]bool)
	for _, file := range sponsorFiles {
		sponsorExists[file] = false
	}

	// Check if image files exist
	for _, filename := range sponsorFiles {
		imageURL := imagesBaseURL + filename

		// Try to fetch the image
		imgResp, err := http.Get(imageURL)
		if err != nil {
			t.Errorf("❌ Failed to request image %s: %v", imageURL, err)
			continue
		}
		defer imgResp.Body.Close()

		// Check status code
		if imgResp.StatusCode != http.StatusOK {
			t.Errorf("❌ Image %s returned status %s", imageURL, imgResp.Status)
			continue
		}

		// Save the image to a temp file to verify it exists
		tempFile := filepath.Join(tempDir, filename)
		out, err := os.Create(tempFile)
		if err != nil {
			t.Errorf("❌ Failed to create temp file for %s: %v", filename, err)
			continue
		}

		_, err = io.Copy(out, imgResp.Body)
		out.Close()
		if err != nil {
			t.Errorf("❌ Failed to save image %s: %v", filename, err)
			continue
		}

		// Mark this sponsor as found
		sponsorExists[filename] = true
		t.Logf("✅ Successfully verified image: %s", filename)
	}

	// Log which sponsors were not found
	for file, exists := range sponsorExists {
		if !exists {
			t.Errorf("❌ Sponsor %s was listed but image file not found", file)
		}
	}
}
