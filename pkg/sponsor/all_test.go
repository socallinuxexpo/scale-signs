package sponsor

import (
	"encoding/json"
	"io/fs"
	"net/http"
	"net/http/httptest"
	"path"
	"strings"
	"testing"
)

func TestHandleAllSponsors(t *testing.T) {
	// Create a new manager
	manager, err := NewManager()
	if err != nil {
		t.Fatalf("❌ Failed to create sponsor manager: %v", err)
	}

	// Create a request to pass to our handler
	req, err := http.NewRequest("GET", "/sponsors/all", nil)
	if err != nil {
		t.Fatalf("❌ Failed to create request: %v", err)
	}

	// Create a ResponseRecorder to record the response
	rr := httptest.NewRecorder()
	handler := http.HandlerFunc(manager.HandleAllSponsors)

	// Call the handler directly with the request and response recorder
	handler.ServeHTTP(rr, req)

	// Check the status code
	if status := rr.Code; status != http.StatusOK {
		t.Errorf("❌ Handler returned wrong status code: got %v want %v", status, http.StatusOK)
	}

	// Check response content type
	expectedContentType := "application/json"
	if contentType := rr.Header().Get("Content-Type"); contentType != expectedContentType {
		t.Errorf("❌ Handler returned wrong content type: got %v want %v", contentType, expectedContentType)
	}

	// Decode the response to validate JSON format
	var sponsorFiles []string
	if err := json.NewDecoder(rr.Body).Decode(&sponsorFiles); err != nil {
		t.Errorf("❌ Failed to decode JSON response: %v", err)
	}

	// Count the actual number of image files in the embedded filesystem
	actualImageCount := 0
	err = fs.WalkDir(manager.images, ".", func(filePath string, d fs.DirEntry, err error) error {
		if err != nil {
			return err
		}

		// Skip directories
		if d.IsDir() {
			return nil
		}

		// Count only image files
		ext := strings.ToLower(path.Ext(filePath))
		if ext == ".jpg" || ext == ".jpeg" || ext == ".png" || ext == ".gif" {
			actualImageCount++
		}

		return nil
	})
	if err != nil {
		t.Fatalf("❌ Failed to walk embedded filesystem: %v", err)
	}

	// Verify the count matches
	if len(sponsorFiles) != actualImageCount {
		t.Errorf("❌ Handler returned wrong number of files: got %d, expected %d",
			len(sponsorFiles), actualImageCount)
	} else {
		t.Logf("✅ Successfully retrieved all %d sponsor files", len(sponsorFiles))
	}
}
