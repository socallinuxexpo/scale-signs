package display

import (
	"embed"
	"io/fs"
	"log"
	"net/http"
)

// Embed all files in the display folder
//
//go:embed dist/*
var displayFS embed.FS

// Handler returns an HTTP handler for serving display assets
func Handler() http.Handler {
	// Create a sub filesystem rooted at "display"
	displayDir, err := fs.Sub(displayFS, "dist")
	if err != nil {
		log.Fatal(err)
	}

	return http.FileServer(http.FS(displayDir))
}

// GetFS returns the display filesystem for use with web frameworks
func GetFS() http.FileSystem {
	// Create a sub filesystem rooted at "display"
	displayDir, err := fs.Sub(displayFS, "dist")
	if err != nil {
		log.Fatal(err)
	}

	return http.FS(displayDir)
}
