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

в app необходимо создать копию файла .env и заменить строку подключения к базе на

```
DATABASE_URL="postgresql://postgres:pass@restapi-postgres:5432/restapi?serverVersion=16&charset=utf8"
```

теперь можно запустить миграцию для создания самой базы

```
docker exec -it restapi-app php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20231026112202' 
```

Создаст таблицы соответствующие модели

### тестовые данные для базы

```
docker exec -it restapi-app php bin/console doctrine:fixtures:load
```

### Пример запроса расчета цены

```
curl --request POST \
  --url http://localhost/calculate-price \
  --header 'Content-Type: application/json' \
  --data '{
    "productId": 3,
    "taxNumber": "GR777456789",
    "couponCode": "promo6"
}'
```

### Пример запроса для выполнения покупки

```
curl --request POST \
  --url http://localhost/purchase \
  --header 'Content-Type: application/json' \
  --data '{
    "productId": 3,
    "taxNumber": "GR777456789",
    "couponCode": "promo6",
    "paymentProcessor": "paypal"
}'
```