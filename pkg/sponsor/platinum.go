package sponsor

import (
	"encoding/json"
	"net/http"
)

func (m *Manager) HandlePlatinum(w http.ResponseWriter, r *http.Request) {
	platinumSponsors := []string{
		"aws.png",
		"coderabbit.png",
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(platinumSponsors)
}
