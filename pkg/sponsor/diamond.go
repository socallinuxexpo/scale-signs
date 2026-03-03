package sponsor

import (
	"encoding/json"
	"net/http"
)

func (m *Manager) HandleDiamond(w http.ResponseWriter, r *http.Request) {
	diamondSponsors := []string{
		"microsoft.png",
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(diamondSponsors)
}
