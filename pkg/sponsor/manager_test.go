package sponsor

import (
	"image"
	_ "image/gif"  // Register GIF format
	_ "image/jpeg" // Register JPEG format
	_ "image/png"  // Register PNG format
	"io/fs"
	"path"
	"testing"
)

func TestSponsorImagesAre220x220(t *testing.T) {
	// Create a new manager to access the embedded files
	manager, err := NewManager()
	if err != nil {
		t.Fatalf("Failed to create manager: %v", err)
	}

	// Walk through all files in the images directory
	err = fs.WalkDir(manager.images, ".", func(filePath string, d fs.DirEntry, err error) error {
		if err != nil {
			return err
		}

		// Skip directories
		if d.IsDir() {
			return nil
		}

		// Check file extension to make sure it's an image
		ext := path.Ext(filePath)
		switch ext {
		case ".jpg", ".jpeg", ".png", ".gif":
			// Open the file
			file, err := manager.images.Open(filePath)
			if err != nil {
				t.Errorf("❌ Failed to open image %s: %v", filePath, err)
				return nil
			}
			defer file.Close()

			// Check image dimensions
			img, format, err := image.Decode(file)
			if err != nil {
				t.Errorf("❌ Failed to decode image %s: %v", filePath, err)
				return nil
			}

			bounds := img.Bounds()
			width := bounds.Max.X - bounds.Min.X
			height := bounds.Max.Y - bounds.Min.Y

			if width != 220 || height != 220 {
				t.Errorf("❌ Image %s has incorrect dimensions: got %dx%d, want 300x300 (format: %s)",
					filePath, width, height, format)
			} else {
				t.Logf("✅ Image %s has correct dimensions: 220x220 (format: %s)", filePath, format)
			}
		}

		return nil
	})

	if err != nil {
		t.Fatalf("❌ Error walking through images directory: %v", err)
	}
}

// TestNoImageFiles tests that the images directory is not empty
func TestNoImageFiles(t *testing.T) {
	// Create a new manager to access the embedded files
	manager, err := NewManager()
	if err != nil {
		t.Fatalf("Failed to create manager: %v", err)
	}

	// Count the number of image files
	fileCount := 0
	err = fs.WalkDir(manager.images, ".", func(filePath string, d fs.DirEntry, err error) error {
		if err != nil {
			return err
		}

		// Skip directories
		if d.IsDir() {
			return nil
		}

		// Count files with image extensions
		ext := path.Ext(filePath)
		if ext == ".jpg" || ext == ".jpeg" || ext == ".png" || ext == ".gif" {
			fileCount++
		}

		return nil
	})

	if err != nil {
		t.Fatalf("Error walking through images directory: %v", err)
	}

	if fileCount == 0 {
		t.Error("No image files found in the images directory")
	}
}
