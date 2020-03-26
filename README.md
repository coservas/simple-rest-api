## Simple REST API

#### Установка
```
git clone git@github.com:coservas/simple-rest-api.git && cd simple-rest-api
make install
```

#### Методы:

```
/v1/generate-start-dataset
    POST: Генерация стартового набора товаров

/v1/products
    GET: Список товаров

/v1/orders
    GET: Список заказов
    POST: Создание заказа
        {"products": ["1", "2", "3"]}

/v1/orders/{id}/pay
    POST: Оплата заказа
        {"total": "1000"}
```
