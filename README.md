## Установка

```
    git clone https://github.com/Farlom/via-mobi-test-case.git
    cd ./via-mobi-test-case 
```

``` 
    composer install
    cp .env.example.env
```

```php
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan serve
```

# Postman
[Ссылка на коллекцию](https://www.postman.com/research-meteorologist-45273918/workspace/public/collection/27303078-3ee9aac4-4474-4f18-aacf-4bf24f13faa9?action=share&creator=27303078)

## Описание маршрутов
### Аутентификация и авторизация
- (POST) /api/login/ - авторизация
- (GET) /api/logout - выход из аккаунта
### Получение данных
#### Таблица Products
- (GET) /api/products/ - получение полного списка продуктов (при добавлении query-параметров, происходит фильтрация, сортировка или поиск)
- (POST) /api/products/ - добавление нового продукта в базу
- (GET) /api/products/:id - получение продукта с указанным id
- (DELETE) /api/products/:id - удаление продукта с указанным id
- (PUT) /api/products/:id - обновление продукта с указанным id
#### Таблица Categories
- (GET) /api/categories/ - получение полного списка категорий
- (POST) /api/categories/ - добавление новой категории записи в базу
- (GET) /api/categories/:id - получение категории с указанным id
- (DELETE) /api/categories/:id - удаление категории с указанным id
- (PUT) /api/categories/:id - обновление категории с указанным id

#### Фильтрация, сортировка и поиск 
1. query-параметр `q` отвечает за поиск продукта по названию.
- `/api/prodcuts?q=Name` выведет список продуктов, имя которых содержит указанное выражение

2. query-параметр `price` отвечает за фильтрацию продукта по цене в указанном диапазоне.
- `/api/prodcuts?price=123` выведет список продуктов с ценой в диапазоне от `0` до `123`
- `/api/prodcuts?price=100-123` выведет список продуктов с ценой в диапазоне от `100` до `123`

3. query-параметр `category` отвечает за фильтрацию продукта по категории 
- `/api/prodcuts?category=1` выведет список продуктов, связанных с типом продукта `1`
- `/api/prodcuts?category=1,2,3` выведет список продуктов, связанных с типом продукта `1`,`2` или `3`

4. query-параметр `sort` отвечает за сортировку списка продуктов по цене
- `/api/prodcuts?sort=price_asc` отсортирует список по возрастанию цены
- `/api/prodcuts?sort=price_desc` отсортирует список по убыванию цены

5. Запрос вида `/api/products?sort=price_desc&price=99-100&category=1&q=123` будет включать в себя поиск по имени товара, фильтрацию по цене и категории, сортировку по цене
