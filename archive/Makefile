# Docker parameters
DOCKERCMD = docker
# TODO: dockerhub for scale eventually
DOCKERREPO = sarcasticadmin
IMAGENAME ?= scale-signs
DOCKERBUILD = $(DOCKERCMD) build

DOCKERVERSION ?= $(shell git rev-parse --short HEAD)

docker-build:
	$(DOCKERBUILD) -t "$(DOCKERREPO)/$(IMAGENAME):$(DOCKERVERSION)" .

docker-push: docker-build
	$(DOCKERCMD) push "$(DOCKERREPO)/$(IMAGENAME):$(DOCKERVERSION)"

build: test
	docker-compose build

run: build
	docker-compose up -d

test:
	bash scripts/check_images.sh
