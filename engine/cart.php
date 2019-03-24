<?php

namespace App;

use App\Classes\DB;
use App\Classes\TemplateEngine;

/**
 * Функция получения всех товаров в корзине
 * @param $sql
 * @return array
 */
function getCart($sql)
{
    return getAssocResult($sql);
}

/**
 * Функция генерации блока корзины
 * @param $user_id
 * @return string
 */
function showCart($user_id)
{
    //для безопасности приводим id к числу
    $user_id = (int)$user_id;

    //инициализируем результирующую строку
    $result = '';

    //получаем все товары в корзине

    //Когда нам лень каждый раз писать длинное название таблицы, мы можем заменить его на псевдоним. Например,
    //SELECT * FROM `products` as 'p' WHERE `p`.`id` = 13
    //Так мы даем понять mysql, что мы будем обращаться к p но будем иметь ввиду products
    //Тоже самое работает и при JOIN
    //(INNER jOIN можно заменить на просто JOIN)
    //Например,
    //select * from products
    // inner join category on products.category_id = category.id
    //    where discount <= 5;
    //можно заменить на:
    //select * from products p
    // inner join category c on p.category_id = c.id
    //    where discount <= 5;
    //
    //обратите внимание тут на кавычки, алиас может быть или без кавычек, или в текстовых кавычках (' ')

    //`cart` as op лучше изменить на `cart` as c или оставить cart как есть без алиаса,
    //ну и следовательно дальше в запросе op тоже заменить на c.

    $sql = "SELECT * FROM `cart` as op JOIN `products` as p ON `p`.`id` = `op`.`product_id`
where `user_id` = $user_id;";
    $products = getCart($sql);

    //для каждого товара
    foreach ($products as $product) {
        $result .= render(TPL_DIR . 'cartItems.tpl', $product);
    }
    return $result;
}

/**
 * Функция получает один товар из корзины по его id
 * @param int $product_id
 * @param $user_id
 * @return array|null
 */
function showCartItem($product_id, $user_id)
{
    //для безопасности приводим id к числу
    $product_id = (int)$product_id;
    $user_id = (int)$user_id;

    $sql = "SELECT * FROM `cart` WHERE `product_id` = $product_id and `cart`.`user_id` = $user_id";

    return show($sql);
}

/**
 * Функция обновления количества и суммарной стоимости товара в корзине
 * @param $user_id
 * @param int $id
 * @param $quantity
 * @param $price
 * @param $discount
 * @return bool|mysqli_result
 */
function updateCartItem($user_id, $id, $quantity, $price, $discount)
{
    //избавляемся от инъекций
    $user_id = (int)$user_id;
    $id = (int)$id;
    $quantity = (int)$quantity;
    $price = (float)$price;
    $discount = (float)$discount;

    //Создаем подключение к БД
    $db = createConnection();

    $subtotal = $price * $quantity * $discount;

    $sql = "UPDATE `cart` SET `quantity` = '$quantity', `subtotal` = '$subtotal' WHERE `cart`.`product_id` = $id 
and `cart`.`user_id` = $user_id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция добавления товара в корзину
 * @param $user_id
 * @param $product_id
 * @param $subtotal
 * @return bool
 */
function addToCart($user_id, $product_id, $subtotal)
{
    //избавляемся от инъекций
    $user_id = (int)$user_id;
    $product_id = (int)$product_id;
    $subtotal = (float)$subtotal;

    //Создаем подключение к БД
    $db = createConnection();

    //Генерируем SQL запрос на добавляение в БД
    $sql = "INSERT INTO `cart` (`user_id`, `product_id`, `subtotal`) VALUES ($user_id, $product_id, $subtotal)";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция удаления товара из корзины
 * @param $product_id
 * @param $user_id
 * @return bool
 */
function removeFromCart($product_id, $user_id)
{
    //Создаем подключение к БД
    $db = createConnection();
    //Избавляемся от всех инъекций
    $product_id = escapeString($db, $product_id);
    $user_id = escapeString($db, $user_id);
    //тк оба поля - числа проще от инъекций избавиться путем привидения к (int). Вы выше так делали

    //Генерируем SQL запрос на удаление товара из БД
    $sql = "DELETE FROM `cart` WHERE `cart`.`product_id` = $product_id and `cart`.`user_id` = $user_id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция очистки корзины
 * @param $user_id
 * @return bool
 */
function clearCart($user_id)
{
    //избавляемся от инъекций
    $user_id = (int)$user_id;

    //Создаем подключение к БД
    $db = createConnection();

    //Генерируем SQL запрос на очистку корзины
    $sql = "DELETE FROM `cart` WHERE `cart`.`user_id` = $user_id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Генерирует страницу заказов
 * @return string
 */
function generateOrdersPage()
{
    //получаем по id пользователя все его заказы
    $user_id = $_SESSION['login']['id'];
    $sql = ($_SESSION['login']['admin']) ? $sql = "SELECT * FROM `orders`" :
        $sql = "SELECT * FROM `orders` WHERE `user_id` = $user_id";
    $orders = DB::getInstance()->fetchAll($sql);

    $result = '';
    foreach ($orders as $order) {
        $order_id = $order['id'];

        //получаем товары, которые есть в заказе
        $sql = "
			SELECT * FROM `orders_products` as op
			JOIN `products` as p ON `p`.`id` = `op`.`product_id`
			WHERE `op`.`order_id` = $order_id
		";
        $products = DB::getInstance()->fetchAll($sql);
        //Знаю, что сам так показывал.
        // Но сейчас мы уже крутые чуваки, поэтому теперь будем стараться вытаскивать обращения к базе из циклов.
        // Если догадаетесь сами как сделать - хорошо, если нет - дождитесь когда я это объясню в PHP2
        // или спросите в личку.
        //
        //PS исправлять не нужно, просто подумайте на будущее.

        $content = '';
        $orderSum = 0;
        $status = $order['status'];
        //генерируем элементы таблицы товаров в заказе
        foreach ($products as $product) {
            $count = $product['amount'];
            $price = $product['price'] * $product['discount'];
            $productSum = $count * $price;
            $content .= render(TPL_DIR . 'orderTableRow.tpl', [
                'name' => $product['name'],
                'id' => $product['id'],
                'count' => $count,
                'price' => $price,
                'sum' => $productSum
            ]);
            $orderSum += $productSum;
        }

        $statuses = [
            1 => 'Заказ оформлен',
            2 => 'Заказ собирается',
            3 => 'Заказ готов',
            4 => 'Заказ завершен',
            5 => 'Заказ отменен',
        ];

        //Что бы убрать еще один запрос к БД (а точнее в данном случае цикл запросов)
        //можно было приджойнить то же самое когда получали список товаров в начале.

        //генерируем полную таблицу заказа
        $sql = "SELECT `name` FROM `orders` INNER JOIN `users` on `orders`.user_id = `users`.id
WHERE `orders`.id = $order_id;";
        $user = DB::getInstance()->fetchAll($sql);
        $user_name = $user['0']['name'];
        $result .= render(TPL_DIR . 'orderTable.tpl', [
            'id' => $order_id,
            'user_name' => $user_name,
            'content' => $content,
            'sum' => $orderSum,
            'status' => $statuses[$order['status']],
            'update_status' => ($_SESSION['login']['admin'])
                ? "<label class='user_order_status_label'><input class='user_order_status_input' type='number' 
min='1' max='5' value='$status' data-order_id='$order_id' name='status'/></label><button class='user_order_remove' 
data-order_id='$order_id'>Удалить</button>"
                : "<button class='user_order_cancel' data-order_id='$order_id'>Отменить</button>",
        ]);
    }
    return $result;
}

/**
 * Функция обновления статуса заказа
 * @param $order_id
 * @param $status
 * @return bool|mysqli_result
 */
function updateStatus($order_id, $status)
{
    //для безопасности приводим к числу
    $order_id = (int)$order_id;
    $status = (int)$status;

    //Создаем подключение к БД
    $db = createConnection();

    $sql = "UPDATE `orders` SET `status` = $status WHERE `orders`.`id` = $order_id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция удаления заказа
 * @param $order_id
 * @return bool|mysqli_result
 */
function removeOrder($order_id)
{
    //для безопасности приводим к числу
    $order_id = (int)$order_id;

    //Создаем подключение к БД
    $db = createConnection();

    $sql = "DELETE `orders`, `orders_products` FROM `orders` INNER JOIN `orders_products`
WHERE `orders`.id= $order_id and `orders_products`.`order_id`= $order_id;";

    //Выполняем запрос
    return execQuery($sql, $db);
}