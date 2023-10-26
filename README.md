# Установка docker

### скомпилировать docker image 
```
docker build --build-arg user=user1 -t symfony-pgsql-php:8.2 .
```

### запустить docker composer
```
docker compose -f docker-compose.yml up
```

Будет создано 3 контейнера: restapi-app, restapi-nginx, restapi-postgres

restapi-app контейнер где будет работать приложение. Он содержит все необходимые инструменты для работы с репозиторием, symfony, composer.
