create: up ps

up:
	docker-compose up -d
ps:
	docker-compose ps
rebuild:
	docker-compose down
	docker-compose build --no-cache
	make up
down:
	docker-compose down
# основная команда старта среды docker-compose
go: up ps fpm
# вход в php контейнер
fpm:
	docker-compose exec fpm sh
# установка зависимостей из package.json
webpack_npm_i:
	docker-compose run webpack npm i
# запуск среды webpack
webpack:
	docker-compose exec webpack sh
# установка в контейнере php драйвера chrome для laravel dusk
install chrome:
	docker-compose exec fpm php artisan dusk:chrome-driver 78

