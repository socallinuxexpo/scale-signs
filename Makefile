build: test
	docker-compose build

run: build
	docker-compose up -d

test:
	bash scripts/check_images.sh
