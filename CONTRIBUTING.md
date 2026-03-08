# Contributing

Contributions to go-signs are welcome! If you're interested in helping improve this project, please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Ensure tests and linting pass (`make test`)
5. Submit a pull request

## Development Environment

This project includes a Nix flake for consistent development environments. If you have Nix with flakes enabled:

```sh
# First make sure you have Nix with flakes enabled
# Add "experimental-features = nix-command flakes" to your Nix configuration

# Enter the development shell
direnv allow   # If you have direnv installed
# OR
nix develop    # To manually enter the shell
```

The Nix development shell provides all necessary tools:

- Go toolchain
- Air (for hot reloading)
- Node.js and npm
- TypeScript
- ESLint
- GNU Make
- Go tools and linters
- Prettier

## Development Workflow

The recommended development workflow is:

```sh
# Start the Go server with hot reloading
air # before running for the first time, run a make test or make build

# In another terminal
make test  # or make build to bypass tests (not recommended)
```

Air will detect the changes to the compiled frontend and reload everything automatically. The React frontend sends API requests to the Go backend during development, making it easy to work on both parts of the system simultaneously.

## Code Style Guidelines

### Go Code

- Follow the [Go Code Review Comments](https://github.com/golang/go/wiki/CodeReviewComments)
- Run `staticcheck` on your code
- Ensure `go fmt` and `go vet` pass

### React Code

- Follow ESLint rules configured in the project
- Format code with Prettier using these settings:

```json
{
	"experimentalTernaries": true,
	"htmlWhitespaceSensitivity": "strict",
	"jsxSingleQuote": true,
	"singleAttributePerLine": true,
	"singleQuote": true,
	"useTabs": true
}
```

- Use functional components with hooks
- Follow the established component structure

## Development Tasks

- `make test` - Run all tests with race detection
- `make build` - Build the executable (runs frontend build first)
- `make build-react` - Build just the React frontend
- `make build-go` - Build just the Go backend
- `make deps` - Verify and tidy dependencies
- `make clean` - Clean build artifacts
- `make mrproper` - Deep clean (build artifacts and data)
- `make check-go-vulns` - Run go vulnerability checks using govulncheck
- `make bump-go-vulns` - Update go patch-level dependencies

## Building and Running

```sh
# Build the complete application (frontend + backend)
make build

# Run the server
./out/go-signs

# Command-line options
./out/go-signs -port 8080 -json https://example.com/schedule.json -refresh 10
```

## Available Endpoints

| Endpoint             | Description                                   |
| -------------------- | --------------------------------------------- |
| `/`                  | Main web interface showing the schedule       |
| `/schedule`          | JSON API endpoint for complete schedule data  |
| `/sponsors/platinum` | JSON list of platinum sponsor image filenames |
| `/sponsors/gold`     | JSON list of gold sponsor image filenames     |
| `/sponsors/all`      | JSON list of all sponsor image filenames      |
| `/sponsors/images/*` | Serves embedded sponsor image assets          |
