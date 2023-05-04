create: up ps

up:
	docker-compose up -d
ps:
	docker-compose ps
rebuild:
	docker-compose down
	docker-compose build --no-cache
	make up
fpm:
	docker-compose exec fpm sh
go: up ps fpm

down:
	docker-compose down
