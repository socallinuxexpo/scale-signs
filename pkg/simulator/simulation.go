package simulator

import (
	"encoding/json"
	"fmt"
	"log"
	"math/rand"
	"time"

	"github.com/kylerisse/go-signs/pkg/schedule"
	bolt "go.etcd.io/bbolt"
)

// checkOrCreateSimulationBucket creates the simulation bucket and initializes it if needed
func checkOrCreateSimulationBucket(db *bolt.DB) error {
	return db.Update(func(tx *bolt.Tx) error {
		// Create simulation bucket if it doesn't exist
		bucket, err := tx.CreateBucketIfNotExists([]byte("simulation"))
		if err != nil {
			return fmt.Errorf("create simulation bucket: %w", err)
		}

		today := time.Now()
		resetNeeded := false

		// Check if endDate key exists
		endDateBytes := bucket.Get([]byte("endDate"))
		if endDateBytes == nil {
			// If endDate doesn't exist, we need to reset
			resetNeeded = true
			log.Println("No endDate found, will initialize simulation bucket")
		} else {
			// Check if today is past the endDate
			endDateStr := string(endDateBytes)
			endDate, err := time.Parse("2006-01-02", endDateStr)
			if err != nil {
				log.Printf("Invalid endDate format: %s, will reset", endDateStr)
				resetNeeded = true
			} else if today.After(endDate) {
				log.Printf("Current date %s is past endDate %s, will reset simulation",
					today.Format("2006-01-02"), endDateStr)
				resetNeeded = true
			} else {
				log.Printf("Simulation bucket has valid endDate: %s", endDateStr)
			}
		}

		// If not resetting due to date, check if there are any running or upcoming presentations
		if !resetNeeded {
			mockJSONBytes := bucket.Get([]byte("mockJSON"))
			if mockJSONBytes == nil {
				resetNeeded = true
				log.Println("No mockJSON found in simulation bucket, will reset")
			} else {
				// Parse and check if there are any running or upcoming events
				presentations, err := schedule.DrupalToPresentations(mockJSONBytes)
				if err != nil {
					log.Printf("Error parsing presentations: %v", err)
					resetNeeded = true
				} else {
					hasEvents := hasRunningOrUpcomingEvents(presentations, today)
					if !hasEvents {
						resetNeeded = true
						log.Println("No running or upcoming events in simulation, will reset")
					} else {
						log.Println("Simulation has running or upcoming events, no reset needed")
					}
				}
			}
		}

		// Reset the bucket if needed
		if resetNeeded {
			// First, delete all existing keys
			c := bucket.Cursor()
			for k, _ := c.First(); k != nil; k, _ = c.Next() {
				if err := bucket.Delete(k); err != nil {
					return fmt.Errorf("failed to delete key %s: %w", k, err)
				}
			}

			// Then create a new endDate key with date 4 days from now (5 days including today)
			endDateValue := today.AddDate(0, 0, 4).Format("2006-01-02")
			if err := bucket.Put([]byte("endDate"), []byte(endDateValue)); err != nil {
				return fmt.Errorf("failed to set endDate: %w", err)
			}

			log.Printf("Reset simulation bucket with new endDate: %s", endDateValue)

			// Create simulated conference data
			if err := createSimulatedConferenceData(tx, today); err != nil {
				return fmt.Errorf("failed to create simulated conference data: %w", err)
			}
		}

		return nil
	})
}

// hasRunningOrUpcomingEvents checks if there are any presentations that are either
// currently running or will start within the next 24 hours
func hasRunningOrUpcomingEvents(presentations []schedule.Presentation, now time.Time) bool {
	// Set a cutoff time of 24 hours from now
	cutoff := now.Add(24 * time.Hour)

	for _, p := range presentations {
		// Check if the presentation is currently running
		if now.After(p.StartTime) && now.Before(p.EndTime) {
			log.Printf("Found currently running presentation: %s", p.Name)
			return true
		}

		// Check if the presentation will start within the next 24 hours
		if p.StartTime.After(now) && p.StartTime.Before(cutoff) {
			log.Printf("Found upcoming presentation within 24h: %s at %s",
				p.Name, p.StartTime.Format("2006-01-02 15:04:05"))
			return true
		}
	}

	// No running or upcoming events found
	log.Println("No running or upcoming events found in the next 24 hours")
	return false
}

// createSimulatedConferenceData randomly selects and modifies a conference schedule
func createSimulatedConferenceData(tx *bolt.Tx, today time.Time) error {
	// Get the jsonData bucket
	jsonBucket := tx.Bucket([]byte("jsonData"))
	if jsonBucket == nil {
		return fmt.Errorf("jsonData bucket not found")
	}

	// Get the simulation bucket
	simBucket := tx.Bucket([]byte("simulation"))
	if simBucket == nil {
		return fmt.Errorf("simulation bucket not found")
	}

	// Get all JSON keys
	var jsonKeys []string
	c := jsonBucket.Cursor()
	for k, _ := c.First(); k != nil; k, _ = c.Next() {
		jsonKeys = append(jsonKeys, string(k))
	}

	if len(jsonKeys) == 0 {
		return fmt.Errorf("no JSON data found")
	}

	// Randomly select ONE conference to be the primary one with date shifting
	selectedKey := jsonKeys[rand.Intn(len(jsonKeys))]
	log.Printf("Selected %s as primary conference with date shifting", selectedKey)

	// Get the JSON data for the selected conference
	jsonData := jsonBucket.Get([]byte(selectedKey))
	if jsonData == nil {
		return fmt.Errorf("no data found for key %s", selectedKey)
	}

	// Parse and modify the JSON data with date shifting
	modifiedJSON, err := modifyJSONDates(jsonData, today)
	if err != nil {
		return fmt.Errorf("failed to modify JSON dates: %w", err)
	}

	// AFTER modifying dates, now merge in all conferences

	// Parse the modified JSON back into nodes structure
	var baseNodes []schedule.DrupalNode
	if err := json.Unmarshal(modifiedJSON, &baseNodes); err != nil {
		return fmt.Errorf("error parsing modified JSON: %w", err)
	}

	// Create a merged nodes structure starting with our date-shifted conference
	mergedNodes := baseNodes

	// Now merge in all the other conferences with their original dates
	for _, key := range jsonKeys {
		// Get the JSON data for this conference
		jsonData := jsonBucket.Get([]byte(key))
		if jsonData == nil {
			log.Printf("Warning: no data found for key %s, skipping", key)
			continue
		}

		// Parse the JSON data into nodes structure (keeping original dates)
		var additionalNodes []schedule.DrupalNode
		if err := json.Unmarshal(jsonData, &additionalNodes); err != nil {
			log.Printf("Warning: error parsing JSON for %s: %v, skipping", key, err)
			continue
		}

		// Add these nodes to our merged structure
		log.Printf("Adding %d nodes from %s with original dates", len(additionalNodes), key)
		mergedNodes = append(mergedNodes, additionalNodes...)
	}

	log.Printf("Merged a total of %d nodes from all JSON data sources", len(mergedNodes))

	// Marshal the merged nodes back to JSON
	finalJSON, err := json.MarshalIndent(mergedNodes, "", "  ")
	if err != nil {
		return fmt.Errorf("error marshaling merged JSON: %w", err)
	}

	// Store the merged JSON in the simulation bucket
	if err := simBucket.Put([]byte("mockJSON"), finalJSON); err != nil {
		return fmt.Errorf("failed to store mockJSON: %w", err)
	}

	log.Printf("Created mockJSON from %s with date-shifted sessions plus original sessions from other conferences",
		selectedKey)

	return nil
}

// modifyJSONDates updates the Day and Time elements with simulated dates
func modifyJSONDates(jsonData []byte, today time.Time) ([]byte, error) {
	// Use the existing types from the schedule package
	var origNodes []schedule.DrupalNode
	if err := json.Unmarshal(jsonData, &origNodes); err != nil {
		return nil, fmt.Errorf("error parsing JSON: %w", err)
	}

	// Map days to new dates
	// Today = Wednesday, Tomorrow = Thursday, etc.
	dates := make(map[time.Weekday]time.Time)
	dates[time.Wednesday] = today
	dates[time.Thursday] = today.AddDate(0, 0, 1)
	dates[time.Friday] = today.AddDate(0, 0, 2)
	dates[time.Saturday] = today.AddDate(0, 0, 3)
	dates[time.Sunday] = today.AddDate(0, 0, 4)

	var newNodes []schedule.DrupalNode
	// For each node, update Date but keep existing time
	for _, node := range origNodes {
		origStart, err := time.Parse(time.RFC3339, node.StartTime)
		if err != nil {
			log.Printf("Invalid StartTime in %v", node)
			continue
		}
		origEnd, err := time.Parse(time.RFC3339, node.EndTime)
		if err != nil {
			log.Printf("Invalid EndTime in %v", node)
			continue
		}

		// Get the new DATE part for start and end based on their original weekdays
		newStartDate := dates[origStart.Weekday()]
		newEndDate := dates[origEnd.Weekday()]

		// Build new start time: new date + original time-of-day
		newStart := time.Date(
			newStartDate.Year(),
			newStartDate.Month(),
			newStartDate.Day(),
			origStart.Hour(),
			origStart.Minute(),
			origStart.Second(),
			origStart.Nanosecond(),
			newEndDate.Location(), // TZ info
		)

		// Same for end time
		newEnd := time.Date(
			newEndDate.Year(),
			newEndDate.Month(),
			newEndDate.Day(),
			origEnd.Hour(),
			origEnd.Minute(),
			origEnd.Second(),
			origEnd.Nanosecond(),
			newEndDate.Location(), // TZ info
		)

		// Format back to RFC3339 string
		newNodes = append(newNodes, schedule.DrupalNode{
			Name:        node.Name,
			Location:    node.Location,
			StartTime:   newStart.Format(time.RFC3339),
			EndTime:     newEnd.Format(time.RFC3339),
			Speakers:    node.Speakers,
			Topic:       node.Topic,
			Description: node.Description,
		})
	}

	// Marshal back to JSON
	bytesJSON, err := json.MarshalIndent(newNodes, "", "  ")
	if err != nil {
		return nil, fmt.Errorf("error generating modified JSON: %w", err)
	}

	return bytesJSON, nil
}
