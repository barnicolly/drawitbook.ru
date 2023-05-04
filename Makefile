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
webpack_npm_i:
	docker-compose run webpack npm i
go: up ps fpm

down:
	docker-compose down
