# SCaLE Simulator

The SCaLE Simulator is a development, demonstration, and testing tool for the `go-signs` project. It allows developers to test the frontend without relying on the real SCaLE website JSON endpoint, providing a consistent development environment with mostly predictable data.

## Overview

The simulator creates a mock server that:

1. Loads historical schedule data from previous SCaLE conferences (13x - 22x) from local archive
1. Loads historical schedule data from previous SCaLE conferences (23x and beyond) from Drupal
1. Duplicates and transforms dates of a random previous expo to simulate an ongoing conference
1. Serves the entire schedule through a compatible API endpoint
1. Stores data in a local BoltDB database for persistence across restarts
1. Automatically starts a new date shifted conference when the existing one finishes

This approach enables developers to test the `go-signs` application's display and scheduling logic without needing to wait for specific times of day or manually adjusting their system clock. It also allows the viewing of any previous SCaLE when used in conjunction with `go-signs` time override feature.

## Getting Started

### Prerequisites

- Go 1.25
- BoltDB will be created automatically (no separate installation needed)

### Running the Simulator

```bash
# Run with default settings
./out/scale-simulator

# Specify custom database path and port
./out/scale-simulator -db ./data/my-custom-db.db -port 8080
```

## Command Line Arguments

| Argument | Default               | Description                             |
| -------- | --------------------- | --------------------------------------- |
| `-db`    | `./data/simulator.db` | Path to the BoltDB database file        |
| `-port`  | `2018`                | Port on which the simulator will listen |

## How It Works

### Simulation Process

1. **Historical Data Selection**: The simulator loads JSON data from previous SCaLE conferences
2. **Date Transformation**: A random previous year is selected, duplicated, and all dates in the schedule are shifted to use the current date's tomorrow as the conference start day.
3. **Persistence**: The simulator stores the modified schedule in a BoltDB database.
4. **API Compatibility**: The simulator exposes a similar Drupal JSON API endpoint as the actual `go-signs` application expects.

### Database Structure

The BoltDB database contains two main buckets:

- `jsonData`: Stores the original data from past conferences
- `simulation`: Stores the active simulation data, including the original and processed JSON

### Automatic Initialization

When first run, the simulator will:

1. Download historical SCaLE conference data
2. Select one conference schedule at random
3. Transform dates to create a 4-day conference starting from the current date
4. Store the processed data combined with all previous conferences for serving

## API Endpoints

| Endpoint      | Method | Description                                                                     |
| ------------- | ------ | ------------------------------------------------------------------------------- |
| `/`           | GET    | Status check endpoint returning status and current time                         |
| `/sign.json`  | GET    | Returns the simulation as JSON (main Drupal endpoint for the go-signs backend)  |
| `/archive/$x` | GET    | Returns any schedule from a specific scale, where `$x` is ex: `13x`, `23x`, etc |

## Use Cases

### Demo Site

The `go-signs` [DEMO](https://demo.go-signs.org) site leverages an always running instance of the Simulator's [JSON endpoint](https://simulator.go-signs.org/sign.json).

### Local Development

The simulator is ideal for local development when you want to:

- Test how the schedule display behaves at different times
- Work on frontend components without a live SCaLE conference
- Develop new features that depend on having an active schedule
