package sponsor

import (
	"encoding/json"
	"io/fs"
	"net/http"
	"path"
	"strings"
)

// HandleAllSponsors returns a list of all sponsor image files
func (m *Manager) HandleAllSponsors(w http.ResponseWriter, r *http.Request) {
	var sponsorFiles []string

	// Walk the file system to find all image files
	err := fs.WalkDir(m.images, ".", func(filePath string, d fs.DirEntry, err error) error {
		if err != nil {
			return err
		}

		// Skip directories
		if d.IsDir() {
			return nil
		}

		// Check file extension to make sure it's an image
		ext := strings.ToLower(path.Ext(filePath))
		if ext == ".jpg" || ext == ".jpeg" || ext == ".png" || ext == ".gif" {
			sponsorFiles = append(sponsorFiles, filePath)
		}

		return nil
	})

	if err != nil {
		http.Error(w, "Error reading sponsor files: "+err.Error(), http.StatusInternalServerError)
		return
	}

	// Set content type and return JSON
	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(sponsorFiles)
}
