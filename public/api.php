<?php

namespace App;

//Обработка метода addToCart
if ($_POST['apiMethod'] === 'addToCart') {

    //у вас везде в апи есть обращение к $_SESSION['login'] но при этом нет проверки, что оно существует.

    //Получаем данные из postData
    $product_id = $_POST['postData']['product_id'] ?? '';

    $user_id = $_SESSION['login']['id'];
    $product = getProduct($product_id);
    $price = $product['price'];
    $discount = $product['discount'];
    $subtotal = $price * $discount;

//пытаемся добавить товар в корзину
    $cartItem = showCartItem($product_id, $user_id);
    (!isset($cartItem['quantity'])) ? addToCart($user_id, $product_id, $subtotal)
        : error("Вы уже добавили данный товар.");
    $cartItem = showCartItem($product_id, $user_id);
    (isset($cartItem['quantity'])) ? success("Товар с ID($product_id) добавлен в корзину.")
        : error('Что-то пошло не так');
}
//В вашем случае, если товар в корзину уже был добавлен, то сначала выведется "Вы уже добавляли данный товар в корзину.
// Потом снова выполнится запрос show и выведится "Товар добавлен".
//
//Мы предполагаем, что addToCart Должен возвращать true либо false если товар добавлен, либо произошла ошибка.
//Тогда нам не придется делать повторный запрос show.
//А он в свою очередь проверяет true/false в зависимости что ему ответила БД на insert

//Обработка метода createOrder
if ($_POST['apiMethod'] === 'createOrder') {

    //только тут проверка есть

    //если пользователь не авторизован, перенаправляем его на форму аутентификации
    if (empty($_SESSION['login'])) {
        header('Location: /');
    }

    $user_id = (int)$_SESSION['login']['id'];

    $sql = "SELECT * FROM `cart` WHERE `user_id` = $user_id";
    $cart = getCart($sql);

//если корзина пуста выводим ошибку
    if (empty($cart)) {
        error("Корзина пуста");
        exit();
    }

//генерируем запрос и получаем id вставленной строки
    $sql = "INSERT INTO `orders` (`user_id`) VALUES ('$user_id')";
    $orderId = insert($sql);

//если строка не вставилась вызываем ошибку
    if (!$orderId) {
        error("Произошла ошибка");
        exit();
    }

//генерируем запрос в БД
    $values = [];
    foreach ($cart as $product) {
        $productId = $product['product_id'];
        $amount = $product['quantity'];
        $values[] = "($orderId, $productId, $amount)";
    }

    $values = implode(', ', $values);

    $sql = "INSERT INTO `orders_products` (`order_id`, `product_id`, `amount`) VALUES $values";

//выполняем запрос
    if (execQuery($sql)) {
        //очищаем корзину
        clearCart($user_id);
        success();
//        success("Заказ успешно создан");
    } else {
        error("Произошла ошибка");
    }
}

//Обработка метода updateStatus
if ($_POST['apiMethod'] === 'updateStatus') {

    //Получаем данные из postData
    $order_id = $_POST['postData']['order_id'] ?? '';
    $status = $_POST['postData']['status'] ?? '';

    //по хорошему нужно еще проверять, что пользователь авторизован и имеет достаточно прав на эта действие

    (updateStatus($order_id, $status)) ? success() : error("api: 219");
}

//Обработка метода removeOrder
if ($_POST['apiMethod'] === 'removeOrder') {

    //Получаем данные из postData
    $order_id = $_POST['postData']['order_id'] ?? '';

    //и тут тоже проверить, что пользователь имеет право

    (removeOrder($order_id)) ? success() : error("api: 216");
}