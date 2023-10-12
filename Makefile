PROJECT = obada/reference-design
COMMIT_BRANCH ?= develop
BASE_IMAGE = $(PROJECT):base
PROJECT_IMAGE = $(PROJECT):$(COMMIT_BRANCH)
PROJECT_RELEASE_IMAGE = $(PROJECT):master
PROJECT_TAG_IMAGE = $(PROJECT):$(COMMIT_TAG)

SHELL := /bin/sh
.DEFAULT_GOAL := help
ORGS = \
	thebrokersite tradeloop ascdi \
	wdpi usody thinkdynamic \
	quantumlifecycle

build: build/develop build/ui

build/develop:
	docker build -t $(PROJECT_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=dev

build/ui:
	@for ORG in $(ORGS); do \
		echo "Building a docker container for organization: \"$$ORG\""; \
		ansible-playbook docker/ui/playbook.yml \
			--extra-vars "org=$$ORG" \
			--extra-vars "@docker/ui/vars/$$ORG.yml"; \
	done

deps/php:
	docker run \
		--rm \
		 -it \
		 -v $$(pwd)/src:/app \
		 -w /app \
		 composer:2.2.12 \
		sh -c "composer install --ignore-platform-req=ext-bcmath"

deps/php/update:
	docker run \
		--rm \
		 -it \
		 -v $$(pwd)/src:/app \
		 -w /app \
		 composer:2.2.12 \
		sh -c "composer update obada-foundation/client-api-library-php --ignore-platform-req=ext-bcmath"

php/dump-autoload:
	docker run \
		--rm \
		 -it \
		 -v $$(pwd)/src:/app \
		 -w /app \
		 composer:2.2.12 \
		sh -c "composer dump-autoload --ignore-platform-req=ext-bcmath"

deps/node:
	docker run \
		--rm \
		-it \
		-v $$(pwd)/src:/app \
		-w /app \
		node:14 \
		sh -c "npm install && npm run dev"

node/watch:
	docker run \
		--rm \
		-it \
		-v $$(pwd)/src:/app \
		-w /app \
		node:14 \
		sh -c "npm run watch"

deps: deps/php deps/node

run-local:
	docker-compose -f docker-compose.yml up -d --force-recreate

phpstan:
	docker run \
		--rm \
		-t \
		$(PROJECT_IMAGE) \
		sh -c "./vendor/bin/phpstan analyse --memory-limit=2G"

rector/local:
	docker exec \
		-it \
		reference-design \
		sh -c "vendor/bin/rector process --dry-run"

rector/local/fix:
	docker exec \
		-it reference-design \
		sh -c "vendor/bin/rector process"

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

bbpb: build-branch publish-branch-image

build-branch:
	docker build -t $(PROJECT_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=dev

publish-branch-image:
	docker push $(PROJECT_IMAGE)

build-base:
	docker build -t $(BASE_IMAGE) -f docker/base/Dockerfile .

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

