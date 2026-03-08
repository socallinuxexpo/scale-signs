package schedule

import (
	"crypto/sha256"
	"encoding/hex"
	"encoding/json"
	"log"
	"net/http"
	"sync"
	"time"
)

// Schedule contains all presentations and events
type Schedule struct {
	Presentations   []Presentation `json:"Presentations"`
	LastUpdateTime  string         `json:"lastUpdateTime"`  // When we last successfully updated the data
	LastRefreshTime string         `json:"lastRefreshTime"` // When we last checked for updates
	ContentHash     string         `json:"contentHash"`     // SHA-256 hash of the raw Drupal content
	SessionCount    int            `json:"sessionCount"`    // Number of presentations
	mutex           *sync.RWMutex  `json:"-"`               // Don't include in JSON
	jsonURL         string         `json:"-"`               // Don't include in JSON
}

// Event is basic scheduling primitive
type Event struct {
	Name        string    `json:"Name"`
	Description string    `json:"Description"`
	Location    string    `json:"Location"`
	StartTime   time.Time `json:"StartTime"`
	EndTime     time.Time `json:"EndTime"`
}

// Presentation is an extension of event with speakers and a topic
type Presentation struct {
	Event
	Speakers string `json:"Speakers"`
	Topic    string `json:"Topic"`
}

// NewSchedule produces a new Schedule
func NewSchedule(jsonUrl string) *Schedule {
	sch := Schedule{
		jsonURL:     jsonUrl,
		ContentHash: "",
	}
	sch.mutex = &sync.RWMutex{}
	return &sch
}

// calculateContentHash generates a SHA-256 hash of content
func calculateContentHash(content []byte) string {
	hash := sha256.Sum256(content)
	return hex.EncodeToString(hash[:])
}

// formatTime returns time in ISO 8601 format with timezone
func formatTime(t time.Time) string {
	if t.IsZero() {
		return ""
	}
	return t.Format(time.RFC3339)
}

func (s *Schedule) updateSchedule(ps []Presentation) {
	s.mutex.Lock()
	defer s.mutex.Unlock()

	s.Presentations = ps
	s.SessionCount = len(ps)
	s.LastUpdateTime = formatTime(time.Now())

	log.Printf("Schedule updated with %d sessions, hash: %s", s.SessionCount, s.ContentHash)
}

// UpdateFromJSON fetches and processes the schedule JSON
func (s *Schedule) UpdateFromJSON() {
	log.Printf("Updating Schedule from %v", s.jsonURL)

	// Always update the refresh time
	s.mutex.Lock()
	s.LastRefreshTime = formatTime(time.Now())
	s.mutex.Unlock()

	body, err := fetch(s.jsonURL)
	if err != nil {
		log.Printf("Error fetching schedule: %v", err)
		return
	}

	// Calculate hash of the raw JSON content
	newContentHash := calculateContentHash(body)

	// Check if content has changed by comparing hashes
	s.mutex.RLock()
	currentHash := s.ContentHash
	s.mutex.RUnlock()

	if currentHash == newContentHash && currentHash != "" {
		log.Printf("No change to JSON schedule (hash: %s)", newContentHash)
		return
	}

	ps, err := DrupalToPresentations(body)
	if err != nil {
		log.Printf("Unmarshal error: %v", err)
		return
	}

	// Only update the content hash and schedule if we have presentations
	if len(ps) == 0 {
		log.Printf("Parsed JSON resulted in 0 presentations, keeping existing schedule")
		return
	}

	// Update the content hash
	s.mutex.Lock()
	s.ContentHash = newContentHash
	s.mutex.Unlock()

	s.updateSchedule(ps)
}

// HandleScheduleAll serves the complete schedule as JSON
func (s *Schedule) HandleScheduleAll(w http.ResponseWriter, req *http.Request) {
	enc := json.NewEncoder(w)
	enc.SetEscapeHTML(false)
	w.Header().Set("Content-Type", "application/json")

	s.mutex.RLock()
	err := enc.Encode(s)
	if err != nil {
		log.Println("HandleScheduleAll cannot encode schedule")
	}
	s.mutex.RUnlock()
}
