# Docker parameters
DOCKERCMD ?= docker
COMPOSECMD ?= $(DOCKERCMD)-compose
# TODO: dockerhub for scale eventually
DOCKERREPO = sarcasticadmin
IMAGENAME ?= scale-signs
TARGETPLATFORM ?= "linux/amd64"
DOCKERBUILD = $(DOCKERCMD) buildx build

DOCKERVERSION ?= $(shell git rev-parse --short HEAD)

docker-build:
	$(DOCKERBUILD) --platform $(TARGETPLATFORM) -t "$(DOCKERREPO)/$(IMAGENAME):$(DOCKERVERSION)" .

docker-push: docker-build
	$(DOCKERCMD) push "$(DOCKERREPO)/$(IMAGENAME):$(DOCKERVERSION)"

build: test
	$(COMPOSECMD) build

run: test
	$(COMPOSECMD) up -d

test:
	bash scripts/check_images.sh
