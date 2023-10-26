# Установка docker

### скомпилировать docker image
```
docker build --build-arg user=user1 -t symfony-pgsql-php:8.2 .
```

### запустить docker compose для поднятия всей инфраструктуры
```
docker compose -f docker-compose.yml up
```

Будет создано 3 контейнера: restapi-app, restapi-nginx, restapi-postgres

restapi-app контейнер где будет работать приложение. Он содержит все необходимые инструменты для работы с репозиторием, symfony, composer.

# Установка Приложения

### запустить composer чтобы установить все зависимости приложения и саму symfony

```
docker exec -it restapi-app composer install
```

### настройка базы данных

в директории app необходимо создать копию файла .env и заменить строку подключения к базе данные на следующую

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

В базе появились данные: Продукты, Скидочные Купоны, Tax rates для стран

> Небольшое замечание по поводу хранения цены. Все ценники хранятся в минимальных юнитах, в данном случае центы. При работе с сервисами оплаты система учитывает что разные сервисы могут работать с разными юнитами 

# Работа с приложением

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
В ответ получим статутc и расчет суммы (в минимальных юнитах - центах)

```
{
    "ok": true,
    "sum": 1156
}
```
в случае ошибки получаем ответ со статусом 400 и телом ответа

```
{
    "errors": [
        {
            "property": "taxNumber",
            "value": "GR777456",
            "message": "Tax Number incorrect"
        }
    ]
}
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

# Тесты

```
docker exec -it restapi-app make tests
```
