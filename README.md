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


### запустить composer чтобы установить зависимости

```
docker exec -it restapi-app composer install
```

### настройка базы данных

```
docker exec -it restapi-app php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20231026112202' 
```

Создаст таблицы соответствующие модели

