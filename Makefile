.PHONY: ssh
ssh:
	docker compose exec main ash


.PHONY: provision
provision:
	cd /app
	composer install

.PHONY: coverage-text
coverage-report/text:
	cat .coverage/text


.PHONY: coverage-html
coverage-report/html:
	open .coverage/html/dashboard.html


.PHONY: lint
lint:
	composer --working-dir=/app run lint


.PHONY: test
test:
	composer --working-dir=/app run test
