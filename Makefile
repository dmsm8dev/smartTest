start:
	docker compose up -d
build:
	docker compose up -d --build

stop:
	docker compose down

fpm:
	docker exec -it api_app bash

db:
	docker exec -it db_nisarga bash

c1:
	docker exec -it client sh
redis:
	docker exec -it redis_nisarga redis-cli	#KEYS *, GET ключ, FLUSHALL
