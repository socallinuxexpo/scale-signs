# go-signs

`go-signs` is a modern Go-based service designed to power the digital signage system for the Southern California Linux Expo (SCaLE). It is specifically built to run as a single binary on Raspberry Pi devices distributed throughout the venue. Each Pi serves as a standalone digital sign displaying conference schedules, speaker information, and event logistics.

This project is the successor to [scale-signs](https://github.com/socallinuxexpo/scale-signs), which has served SCaLE well for many years.

## Demo

A [DEMO](https://demo.go-signs.org) of this application is available online. It leverages the [SCaLE Simulator](./docs/SIMULATOR.md) and supports [time override](#time-override) URL parameters for any scale between 13x and 22x in addition to a simulated "current" SCaLE that is always active.

> Please note that `go-signs` is currently meant to be displayed at 1080p only. Responsive design to support 720p -> 4k is planned for a later release.

## Features

- **Real-time Schedule Updates**: Pulls schedule data from the SCaLE Drupal CMS via JSON endpoint
- **Responsive React Frontend**: Clean, auto-scrolling display of schedule information
- **Sponsor Showcase**: Sponsors are prominently displayed near the conference schedule
- **Embedded Assets**: Single binary includes all web assets and sponsor images
- **Clock Override**: Support for time simulation via URL parameters for testing
- **Automatic Refresh**: Self-updating schedule and continuous display rotation
- **Modern Technology Stack**: Go, React, Typescript, TailwindCSS, and Nix

> Future features and milestones are located in the [Roadmap](./docs/ROADMAP.md) doc.

## Usage

```sh
Usage of go-signs:
  -port string
        Port to listen on (1-65535) (default "2017")
  -refresh int
        Schedule refresh interval in minutes (minimum 1) (default 5)
  -json string
        URL to Drupal endpoint (must be http or https) (default "http://www.socallinuxexpo.org/scale/23x/signs")
```

### Time Override

During development, you will often need to test how the schedule display behaves at different times. Instead of waiting for specific times or changing your system clock, use the time override feature:

1. Open your development instance in a browser
2. Add URL parameters to simulate a specific time:
   ```
   https://demo.go-signs.org/?year=2025&month=3&day=6&hour=13&minute=53
   ```
3. The application will use this simulated time instead of the actual system time

This feature is extremely useful for testing various schedule states like "in progress," "starting soon," and day transitions. Also be sure to take time zone differences into account. SCaLE talks tend to take place at GMT-8 or GMT-7 depending on the date.

- `year`
- `month`
- `day`
- `hour`
- `minute`

## Contributing

see [CONTRIBUTING](./CONTRIBUTING.md) and [AI POLICY](./docs/AI_POLICY.md)

## Releases

see [RELEASES](./docs/RELEASES.md)

## Project Structure

```
go-signs/
├─ cmd/go-signs/               # go main binaries
│  ├─ go-signs                 # go-signs entry point
│  └─ scale-simulator          # scale-simulator entry point
├─ nix/                        # Nix devShells and Packages
├─ pkg/                        # Backend packages
│  ├─ display/                 # Handles embedding React frontend
│  ├─ schedule/                # Schedule data handling
|  ├─ simulator/               # scale-simulator specific server
│  ├─ server/                  # HTTP server and routes
│  └─ sponsor/                 # Sponsor management and image serving
├─ react-display/              # React frontend application
│  ├─ src/
│  │  ├─ components/           # React UI components
│  │  │  ├─ Clock/             # Time display component
│  │  │  ├─ Header/            # Header component with logo, clock and WiFi info
│  │  │  ├─ ScheduleCarousel/  # Schedule display component
│  │  │  ├─ Spinner/           # Loading indicator component
│  │  │  └─ SponsorBanner/     # Sponsor image rotation display
│  │  ├─ contexts/             # React contexts for state management
│  │  │  ├─ TimeContext/       # Date/time management with URL override
│  │  │  ├─ ScheduleContext/   # Schedule data management
│  │  │  └─ SponsorContext/    # Sponsor image loading and rotation
│  │  └─ assets/               # Static assets (logo, images)
└─ .github/workflows/          # GitHub Actions CI configuration
```

## License

This project is licensed under the MIT License. See the [LICENSE.md](LICENSE.md) file for details.
