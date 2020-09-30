PROJECT = obada/reference-design
COMMIT_BRANCH ?= develop
PROJECT_IMAGE = $(PROJECT):$(COMMIT_BRANCH)
PROJECT_RELEASE_IMAGE = $(PROJECT):master
PROJECT_TAG_IMAGE = $(PROJECT):$(COMMIT_TAG)

SHELL := /bin/bash
.DEFAULT_GOAL := help

run-local:
	docker-compose -f docker-compose.yml up -d --force-recreate

deploy-production:
	ansible-playbook deployment/playbook.yml --limit rd.obada.io

deploy-staging:
	@echo "$$ANSIBLE_STAGING_VARS" >> $$(pwd)/hosts
	@echo "$$STAGING_DEPLOY_KEY" >> $$(pwd)/id_rsa
	docker run \
		--rm \
		-t \
		-v $$(pwd)/deployment:/home/ansible/deployment \
		-v $$(pwd)/hosts:/etc/ansible/hosts \
		-v $$(pwd)/id_rsa:/home/ansible/.ssh/id_rsa \
		securityrobot/ansible ansible-playbook deployment/playbook.yml --limit dev.rd.obada.io

deploy-local:
	ansible-playbook deployment/playbook.yml --limit rd.obada.local --connection=local

build-branch:
	docker build -t $(PROJECT_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=dev

publish-branch-image:
	docker push $(PROJECT_IMAGE)

build-release:
	docker build -t $(PROJECT_RELEASE_IMAGE) -f docker/app/Dockerfile . --build-arg APP_ENV=prod

build-tag:
	docker tag $(PROJECT_RELEASE_IMAGE) $(PROJECT_TAG_IMAGE)

help:
	@echo "Help here"

