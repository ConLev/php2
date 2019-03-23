//twig

{% extends index.html}

{% block nav %}
{% endblock %}

//sql

CREATE TABLE customers(
id INT NOT NULL AUTO_INCREMENT,
first_name VARCHAR(32),
second_name VARCHAR(50),
address VARCHAR(256),
phone VARCHAR(20),
book_title VARCHAR(256),
book_author_1 VARCHAR(64),
book_author_2 VARCHAR(64),
page_count INT(4),
date_order DATETIME,
PRIMARY KEY(id)
) CHARACTER SET utf8; INSERT INTO customers
VALUES(
1,
'Александр',
'Иванов',
'Ленинский проспект 68 - 34, Москва
119296',
'+7-920-123-45-67',
'Золотые сказки',
'Александр Сергеевич Пушкин',
'',
128,
'2013-04-18 14:56:00'
),(
NULL,
'Дмитрий',
'Петров',
'Хавская 3 - 128, Москва 115162',
'+7-495-123-45-67',
'ASP.NET MVC 4',
'Джесс Чедвик',
'Тодд Снайдер',
432,
'2013-02-11 09:18:00'
),(
NULL,
'Дмитрий',
'Петров',
'Хавская 3 - 128, Москва 115162',
'+7-495-123-45-67',
'LINQ. Язык интегрированных запросов',
'Адам Фримен',
'Джозеф С. Раттц',
656,
'2013-02-25 19:44:00'
),(
NULL,
'Александр',
'Иванов',
'Ленинский проспект 68 - 34, Москва 119296',
'+7-920-123-45-67',
'Сказки Старого Вильнюса',
'Макс Фрай',
'',
480,
'2013-05-02 14:12:00'
),(
NULL,
'Александр',
'Иванов',
'Ленинский проспект 68 - 34, Москва 119296',
'+7-920-123-45-67',
'Реверс',
'Сергей Лукьяненко',
'Александр Громов',
352,
'2013-03-12 08:25:00'
),(
NULL,
'Елена',
'Козлова',
'Тамбовская - 47, Санкт-Петербург 192007',
'+7-920-765-43-21',
'Золотые сказки',
'Александр Сергеевич Пушкин',
'',
128,
'2013-04-12 12:56:00'
),(
NULL,
'Елена',
'Козлова',
'Тамбовская - 47, Санкт-Петербург 192007',
'+7-920-765-43-21',
'ASP.NET MVC 4',
'Джесс Чедвик',
'Тодд Снайдер',
432,
'2013-04-14 10:11:00'
);

-- Создадим новую таблицу books
CREATE TABLE books(
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(500),
authors VARCHAR(1000),
page_count INT(4),
PRIMARY KEY(id)
) CHARACTER SET utf8;

-- Заполним таблицу books и столбец book_id таблицы customers
INSERT INTO books
VALUES(
1,
'Золотые сказки',
'Александр Сергеевич Пушкин',
128
),(
NULL,
'ASP.NET MVC 4',
'Джесс Чедвик, Тодд Снайдер',
432
),(
NULL,
'LINQ. Язык интегрированных запросов',
'Адам Фримен, Джозеф С. Раттц',
656
),(
NULL,
'Сказки Старого Вильнюса',
'Макс Фрай',
480
),(
NULL,
'Реверс',
'Сергей Лукьяненко, Александр Громов',
352
);

-- Видоизменим таблицу customers, удалив избыточные столбцы book_title, book_author_1, book_author_2, page_count
-- и добавим столбец book_id
ALTER TABLE
customers
DROP
book_title,
DROP
book_author_1,
DROP
book_author_2,
DROP
page_count,
ADD book_id INT(4);
UPDATE
customers
SET
book_id = 1
WHERE
id = 1;
UPDATE
customers
SET
book_id = 2
WHERE
id = 2;
UPDATE
customers
SET
book_id = 3
WHERE
id = 3;
UPDATE
customers
SET
book_id = 4
WHERE
id = 4;
UPDATE
customers
SET
book_id = 5
WHERE
id = 5;
UPDATE
customers
SET
book_id = 1
WHERE
id = 6;
UPDATE
customers
SET
book_id = 2
WHERE
id = 7;

-- Создадим новую таблицу orders (id – идентификатор заказа, user_id – идентификатор пользователя, который сделал заказ)
CREATE TABLE orders(
id INT NOT NULL AUTO_INCREMENT,
user_id INT,
book_id INT,
date_order DATETIME,
PRIMARY KEY(id)
) CHARACTER SET utf8;

-- Видоизменим таблицу customers и добавим данные orders. Обратите внимание,
-- что проводить нормализацию заполненной базы данных – трудоемкая задача,
-- поэтому ее нужно проводить на этапе проектирования базы данных
INSERT INTO orders(date_order, book_id)
SELECT
date_order,
book_id
FROM
customers;
UPDATE
orders
SET
user_id = 1
WHERE
id = 1;
UPDATE
orders
SET
user_id = 2
WHERE
id = 2;
UPDATE
orders
SET
user_id = 2
WHERE
id = 3;
UPDATE
orders
SET
user_id = 1
WHERE
id = 4;
UPDATE
orders
SET
user_id = 1
WHERE
id = 5;
UPDATE
orders
SET
user_id = 3
WHERE
id = 6;
UPDATE
orders
SET
user_id = 3
WHERE
id = 7;
ALTER TABLE
customers
DROP
date_order;
-- Удалить дублирующие данные пользователей из таблицы customers
ALTER IGNORE TABLE
customers ADD UNIQUE INDEX(phone);
ALTER TABLE
customers
DROP
book_id;

-- Создадим новую таблицу addresses
CREATE TABLE addresses(
user_id INT NOT NULL AUTO_INCREMENT,
city VARCHAR(30),
street VARCHAR(50),
post_code INT(6),
PRIMARY KEY(user_id)
) CHARACTER SET utf8;

-- Видоизменим таблицу customers и добавим данные в addresses
ALTER TABLE
customers
DROP
address;
INSERT INTO addresses(city, street, post_code)
VALUES(
'Москва',
'Ленинский проспект 68 - 34',
119296
),(
'Москва',
'Хавская 3 - 128',
115162
),(
'Санкт-Петербург',
'Тамбовская - 47',
192007
);
UPDATE
customers
SET
id = 3
WHERE
id = 6;

-- Связи «один к одному»
SELECT
*
FROM
customers
JOIN addresses ON(
customers.id = addresses.user_id
)
WHERE
customers.id = 1;

-- Связь «один ко многим»
SELECT
*
FROM
customers
JOIN orders ON
(customers.id = orders.user_id)
WHERE
customers.id = 1;

-- mysqldump -u пользователь -p пароль объекты_для_резервного_копирования

-- Команды, выполняющие резервное копирование базы данных с именем users
-- mysqldump -u root -p users > my_backup.sql

-- следующая команда создает резервную копию таблицы customers:
-- mysqldump -u root -p users customers > my_backup_customers.sql

-- резервная копия всего содержимого базы данных
-- mysqldump -u root -p --all-databases > my_backup.sql

-- Пустая копия базы данных (только структура) создается с помощью ключа --no-data.
-- Ключ --no-create- info позволяет выполнить противоположную операцию – создать только резервную копию данных.

-- Если резервная копия базы данных в файле my_backup.sql создавалась с ключом --all-databases,
-- то восстановить базу данных можно так:
-- mysql -u root -p < my_backup.sql

-- Индексы
-- UNIQUE customers(first_name)
-- CREATE UNIQUE INDEX authind ON customers (first_name);

-- Попробуем получить описание таблицы customers:
-- DESCRIBE customers;

-- Расширенная выборка данных
-- SELECT поля FROM левая_таблица
-- LEFT JOIN правая_таблица
-- ON левая_таблица.поле_связи = правая_таблица.поле_связи;

-- Функции для работы со строками
-- SELECT CONCAT ('Пользователь: ', first_name, ' ', second_name, ' , телефон: ', phone) FROM customers;
-- SELECT CONCAT_WS() FROM customers;

-- Функции для работы с датой и временем
-- SELECT WEEKDAY('1961-04-12');
-- DATE_ADD(дата, INTERVAL выражение тип)
-- DATE_SUB(дата, INTERVAL выражение тип)
-- Результат будет аналогичен предыдущему
-- SELECT NOW() - INTERVAL 12 day;

-- Транзакции
CREATE TABLE sample_innodb(
id INT(11) NOT NULL AUTO_INCREMENT,
NAME VARCHAR(150) DEFAULT NULL,
PRIMARY KEY(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8; INSERT INTO sample_innodb
VALUES(1, 'Александр'),(2, 'Дмитрий');
START TRANSACTION
;
DELETE
FROM
sample_innodb
WHERE
id = 1;
DELETE
FROM
sample_innodb
WHERE
id = 2;
ROLLBACK
;
-- Поскольку произошел откат транзакции, данные из таблицы не были удалены.
<?php