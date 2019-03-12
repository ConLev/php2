<?php

/**
 * Функция получения всех товаров в корзине
 * @return array
 */
function getCart()
{
    $sql = "SELECT * FROM `cart`";

    return getAssocResult($sql);
}

/**
 * Функция генерации блока корзины
 * @return string
 */
function showCart()
{
    //инициализируем результирующую строку
    $result = '';
    //получаем все товары в корзине
    $products = getCart();

    //для каждого товара
    foreach ($products as $product) {
        $result .= render(TEMPLATES_DIR . 'cartItems.tpl', $product);
    }
    return $result;
}

/**
 * Функция получает один товар из корзины по его id
 * @param int $id
 * @return array|null
 */
function showCartItem($id)
{
    //для безопасности приводим id к числу
    $id = (int)$id;

    $sql = "SELECT * FROM `cart` WHERE `id` = $id";

    return show($sql);
}

/**
 * Функция обновления количества и суммарной стоимости товара в корзине
 * @param int $id
 * @param $quantity
 * @param $price
 * @return bool|mysqli_result
 */
function updateCartItem($id, $quantity, $price)
{
    //для безопасности приводим id к числу
    $id = (int)$id;

    //Создаем подключение к БД
    $db = createConnection();

    $subtotal = $price * $quantity;

    $sql = "UPDATE `cart` SET `quantity` = '$quantity', `subtotal` = '$subtotal' WHERE `cart`.`id` = $id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция добавления товара в корзину
 * @param $id
 * @param $name
 * @param $price
 * @param $image
 * @param $quantity
 * @return bool
 */
function addToCart($id, $name, $price, $image, $quantity)
{
    //Создаем подключение к БД
    $db = createConnection();
    //Избавляемся от всех инъекций
    $id = escapeString($db, $id);
    $name = escapeString($db, $name);
    $price = escapeString($db, $price);
    $quantity = escapeString($db, $quantity);
    $image = escapeString($db, $image);

    //Генерируем SQL запрос на добавляение в БД
    $sql = "INSERT INTO `cart` (`id`, `name`, `price`, `image`, `quantity`, `subtotal`) 
VALUES ('$id', '$name', '$price', '$image', '$quantity', '$price') ON DUPLICATE KEY 
UPDATE `quantity` = `quantity` + 1, `subtotal` = `price` * `quantity`";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция удаления товара из корзины
 * @param $id
 * @return bool
 */
function removeFromCart($id)
{
    //Создаем подключение к БД
    $db = createConnection();
    //Избавляемся от всех инъекций
    $id = escapeString($db, $id);

    //Генерируем SQL запрос на удаление товара из БД
    $sql = "DELETE FROM `cart` WHERE `cart`.`id` = $id";

    //Выполняем запрос
    return execQuery($sql, $db);
}

/**
 * Функция очистки корзины
 * @return bool
 */
function clearCart()
{
    //Создаем подключение к БД
    $db = createConnection();

    //Генерируем SQL запрос на очистку корзины
    $sql = "TRUNCATE TABLE `cart`";

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
    $orders = getAssocResult($sql);

    $result = '';
    foreach ($orders as $order) {
        $order_id = $order['id'];

        //получаем товары, которые есть в заказе
        $products = getAssocResult("
			SELECT * FROM `orders_products` as op
			JOIN `products` as p ON `p`.`id` = `op`.`product_id`
			WHERE `op`.`order_id` = $order_id
		");

        $content = '';
        $orderSum = 0;
        $status = $order['status'];
        //генерируем элементы таблицы товаров в заказе
        foreach ($products as $product) {
            $count = $product['amount'];
            $price = $product['price'];
            $productSum = $count * $price;
            $content .= render(TEMPLATES_DIR . 'orderTableRow.tpl', [
                'name' => $product['name'],
                'id' => $product['id'],
                'count' => $count,
                'price' => $price,
                'sum' => $productSum
            ]);
            $orderSum += $productSum;
        }

        $statuses = [
            0 => 'Заказ оформлен',
            1 => 'Заказ собирается',
            2 => 'Заказ готов',
            3 => 'Заказ завершен',
            4 => 'Заказ отменен',
        ];

        //генерируем полную таблицу заказа
        $result .= render(TEMPLATES_DIR . 'orderTable.tpl', [
            'id' => $order_id,
            'content' => $content,
            'sum' => $orderSum,
            'status' => $statuses[$order['status']],
            'update_status' => ($_SESSION['login']['admin'])
                ? "<label class='user_order_status_label'><input class='user_order_status_input' type='number' 
min='0' max='4' value='$status' data-order_id='$order_id' name='status'/></label>"
                : $statuses[$order['status']],
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