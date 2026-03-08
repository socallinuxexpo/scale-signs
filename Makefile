# go-signs

test: build-react
	cd react-display && npm run lint
	CGO_ENABLED=1 staticcheck ./...
	go test -count=1 --race -v ./...

build-react:
	cd react-display && npm --no-fund install && npm run build

build-go:
	go build -o out/scale-simulator cmd/scale-simulator/main.go
	go build -o out/go-signs cmd/go-signs/main.go

build: clean build-react build-go

deps:
	go mod verify
	go mod tidy

clean:
	rm -rf pkg/display/dist/* || exit 0
	rm -rf out/* || exit 0

mrproper: clean
	rm -rf react-display/node_modules || exit 0
	rm -rfi data/* || exit 0

check-go-vulns:
	govulncheck -show verbose ./...

bump-go-vulns:
	go get -u=patch ./...
	go mod verify
	go mod tidy

ci-test:
	nix build -L --show-trace .#go-signs-ci-release
