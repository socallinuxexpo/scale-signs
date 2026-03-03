package sponsor

import (
	"encoding/json"
	"net/http"
)

func (m *Manager) HandleGold(w http.ResponseWriter, r *http.Request) {
	goldSponsors := []string{
		"canonical.png",
		"cleanstart.png",
		"codercom.png",
		"google.png",
		"grafana.png",
		"meta.png",
		"percona.png",
		"planetscale.png",
		"redhat.png",
		"valkey.png",
		"velodb.png",
		"victoriametrics.png",
	}

	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(goldSponsors)
}
