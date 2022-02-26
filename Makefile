up:
	docker-compose -f ./laradock/docker-compose.yml up -d nginx mysql phpmyadmin mailhog
stop:
	docker-compose -f ./laradock/docker-compose.yml stop
workspace:
	docker-compose -f ./laradock/docker-compose.yml exec --user=laradock workspace bash
mysql:
	docker-compose -f ./laradock/docker-compose.yml exec mysql bash
