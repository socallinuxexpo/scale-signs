# Docker parameters
DOCKERCMD = docker
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
	docker-compose build

run: build
	docker-compose up -d

test:
	bash scripts/check_images.sh
