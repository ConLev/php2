-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 01 2019 г., 20:06
-- Версия сервера: 10.1.37-MariaDB
-- Версия PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `geek_brains_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` tinyint(4) NOT NULL DEFAULT '1',
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `quantity`, `subtotal`) VALUES
(2, 2, 2, '52.00'),
(1, 1, 1, '41.60');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `url`, `views`, `title`, `size`) VALUES
(1, 'img/1.jpg', 2, 'image_1', 0),
(2, 'img/2.jpg', 1, 'image_2', 0),
(3, 'img/3.jpg', 0, 'image_3', 0),
(4, 'img/4.jpg', 0, 'image_4', 0),
(5, 'img/5.jpg', 0, 'image_5', 0),
(6, 'img/6.jpg', 0, 'image_6', 0),
(7, 'img/7.jpg', 0, 'image_7', 0),
(8, 'img/8.jpg', 0, 'image_8', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `date_create`, `image`) VALUES
(1, 'Заголовок', 'Контент', '2019-03-03 11:04:43', NULL),
(2, 'Я создал магазин', 'В нашем магазине много полезных продуктов. Приходи и покупай', '2019-03-03 11:04:32', NULL),
(3, 'Теперь у нас есть картинки', 'Почти все новости теперь будут сопровождаться картинками', '2019-03-03 11:04:11', '/img/1.jpg'),
(4, 'Заголовок', 'Контент новой статьи', '2019-03-03 11:05:09', NULL),
(5, 'Hello', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque dolor explicabo ipsum nam quibusdam repellat reprehenderit repudiandae sint ut voluptate? A aut consequuntur dolore excepturi modi odit quia rem vero.', '2019-03-03 11:05:20', NULL),
(6, 'Hello', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque dolor explicabo ipsum nam quibusdam repellat reprehenderit repudiandae sint ut voluptate? A aut consequuntur dolore excepturi modi odit quia rem vero.', '2019-03-03 11:05:30', NULL),
(7, 'Hello', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque dolor explicabo ipsum nam quibusdam repellat reprehenderit repudiandae sint ut voluptate? A aut consequuntur dolore excepturi modi odit quia rem vero.', '2019-03-03 11:05:42', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 - Заказ оформлен, 2 - Заказ собирается, 3 - Заказ готов, 4 - Заказ завершен, 5 - Заказ отменен'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 - активен, 2 - неактивен, 3 - удален, 4 - подтвержден'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(11,2) NOT NULL,
  `discount` float NOT NULL DEFAULT '1',
  `image` varchar(255) NOT NULL DEFAULT 'img/no-image.jpeg',
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateChange` timestamp NULL DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `categoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `discount`, `image`, `dateCreate`, `dateChange`, `isActive`, `categoryId`) VALUES
(1, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.8, 'img/product_1.jpg', '2019-04-01 10:57:50', NULL, 0, 0),
(2, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_2.jpg', '2019-04-01 11:00:25', NULL, 0, 0),
(3, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.8, 'img/product_3.jpg', '2019-04-01 10:50:46', NULL, 0, 0),
(4, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.7, 'img/product_4.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(5, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_5.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(6, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.5, 'img/product_6.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(7, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_7.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(8, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_8.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(9, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.8, 'img/product_1.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(10, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_2.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(11, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_3.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(12, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.7, 'img/product_4.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(13, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_5.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(14, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 0.5, 'img/product_6.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(15, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_7.jpg', '2019-03-26 11:28:19', NULL, 1, 0),
(16, 'Mango People T-shirt', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации &quot;Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст..&quot; Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам &quot;lorem ipsum&quot; сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).', '52.00', 1, 'img/product_8.jpg', '2019-03-26 11:28:19', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `author`, `comment`, `date`, `approved`) VALUES
(1, 'Анастасия', 'Vivamus a faucibus eros. Quisque non sem orci. Donec aliquam mauris eu dui interdum, a vulputate nisl sagittis. Curabitur purus metus, rhoncus non velit ac, tincidunt sodales nulla. Vestibulum quam est, gravida sit amet nulla ut, varius accumsan elit. Nulla facilisi. Etiam ac lacus placerat, venenatis lectus vitae, hendrerit diam.', '2019-03-03 05:39:48', 1),
(2, 'Пётр', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at felis nibh. Maecenas a venenatis arcu. Suspendisse dignissim pretium fermentum.', '2019-03-03 05:40:13', 0),
(3, 'Vasiliy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at dui eu mi luctus ultricies eget ut turpis. Duis molestie elit et neque imperdiet, ac convallis enim accumsan. Donec eu egestas sapien. Sed at nulla elit. Sed ac arcu at.', '2019-03-03 05:40:44', 1),
(4, 'Ivan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris at felis nibh. Maecenas a venenatis arcu. Suspendisse dignissim pretium fermentum.', '2019-03-03 05:41:19', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - обычный юзер, 1 - админ	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `admin`) VALUES
(1, 'admin', 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 1),
(2, 'user', 'user', '5f4dcc3b5aa765d61d8327deb882cf99', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD KEY `product_id` (`product_id`) USING BTREE,
  ADD KEY `fk_user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isActive` (`isActive`),
  ADD KEY `parentId` (`parentId`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isActive` (`isActive`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`parentId`) REFERENCES `products` (`categoryId`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
