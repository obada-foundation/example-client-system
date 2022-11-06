PROJECT = obada/reference-design
COMMIT_BRANCH ?= develop
PROJECT_IMAGE = $(PROJECT):$(COMMIT_BRANCH)
PROJECT_RELEASE_IMAGE = $(PROJECT):master
PROJECT_TAG_IMAGE = $(PROJECT):$(COMMIT_TAG)

SHELL := /bin/sh
.DEFAULT_GOAL := help

test:

deps/php:
	docker run \
		--rm \
		 -it \
		 -v $$(pwd)/src:/app \
		 -w /app \
		 composer:2.2.12 \
		sh -c "composer install --ignore-platform-req=ext-bcmath"

deps/node:
	docker run \
		--rm \
		-it \
		-v $$(pwd)/src:/app \
		-w /app \
		node:14 \
		sh -c "npm install && npm run dev"

deps: deps/php deps/node

run-local:
	docker-compose -f docker-compose.yml up -d --force-recreate

deploy/production:
	ansible-playbook deployment/playbook.yml --limit rd.obada.io

deploy/staging:
	@echo "$$ANSIBLE_STAGING_VARS" >> $$(pwd)/hosts
	@echo "$$STAGING_DEPLOY_KEY" >> $$(pwd)/id_rsa
	docker run \
		--rm \
		-t \
		-v $$(pwd)/deployment:/home/ansible/deployment \
		-v $$(pwd)/hosts:/etc/ansible/hosts \
		-v $$(pwd)/id_rsa:/home/ansible/.ssh/id_rsa \
		securityrobot/ansible ansible-playbook deployment/playbook.yml --limit dev.rd.obada.io

deploy/local:
	ansible-playbook deployment/playbook.yml --limit rd.obada.local --connection=local -i deployment/hosts

build-branch:
	docker build -t $(PROJECT_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=dev

publish-branch-image:
	docker push $(PROJECT_IMAGE)

build-release:
	docker build -t $(PROJECT_RELEASE_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=prod

build-tag:
	docker tag $(PROJECT_RELEASE_IMAGE) $(PROJECT_TAG_IMAGE)

client-helper/token/verify:
	docker exec \
		-it \
		reference-design \
		bash -c "curl -X POST -d '{\"id\":\"1234567\", \"email\":\"joe.doe@supermail.com\"}' -H 'content-type: application/json' -H 'authorization: bearer '$(TOKEN) http://client-helper:9090/api/v1/accounts"

client-helper/token/create:
	docker exec -it reference-design sh -c "php artisan jwt:create"

help:
	@echo "Help here"

