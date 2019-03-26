<?php

namespace App;

use App\Classes\DB;

/*
 * Файл работы API
 * Файл ожидает что в _POST придет apiMethod с задачей, которую нужно выполнить
 * и (при необходимости) postData с информацией, необходимой для этой задачи
 *
 */

/*
 * Комментарий по json
 * Если использовать header('Content-Type: application/json'),
 * то весь текст на странице попытается преобразоваться в json.
 * Следовательно нельзя будет увидеть ошибки, которые вам покажет php,
 * поэтому заголовок передаем в последнюю очередь
 *
 * Если до этого были ошибки на php заголовок задать не получится
 *
 */

require_once '../config/config.php';

//Функция вывода ошибки
function error($error_text)
{
    //Вариант с json
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'error_text' => $error_text,
        'data' => null
    ]);
    exit();
}

//Функция успешного ответа
function success($data = true)
{
    //Вариант с json
    header('Content-Type: application/json');
    echo json_encode([
        'error' => false,
        'error_text' => null,
        'data' => $data
    ]);
    exit();
}

//Если на api не передан apiMethod вызываем ошибку
if (empty($_POST['apiMethod'])) {
    error('Не передан apiMethod');
}

//Обработка метода login
if ($_POST['apiMethod'] === 'login') {

    //Получаем логин и пароль из postData
    $login = $_POST['postData']['login'] ?? '';
    $password = $_POST['postData']['password'] ?? '';

    //Если нет логина или пароля вызываем ошибку
    if (!$login || !$password) {
        error('Логин или пароль не переданы');
    }

    //приводим пароль к тому же виду, как он хранится в базе
    $password = md5($password);

    //генерируем запрос и пытаемся найти пользователя
    $sql = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";
    $user = $user = DB::getInstance()->fetchOne($sql);

    //Если пользователь найден, записываем информацию о пользователе в сессию,
    //что бы к ней можно было обратиться с любой страницы
    //Если пользователь не найден, возвращаем ошибку
    if ($user) {
        $_SESSION['login'] = $user;
        success();
    } else {
        error('Неверная пара логин-пароль');
    }
}

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

//Обработка метода updateCart
if ($_POST['apiMethod'] === 'updateCart') {

    $user_id = $_SESSION['login']['id'];

    //Получаем данные из postData
    $id = $_POST['postData']['id'] ?? '';
    $quantity = $_POST['postData']['quantity'] ?? '';

    $product = getProduct($id);
    $price = $product['price'];
    $discount = $product['discount'];
    updateCartItem($user_id, $id, $quantity, $price, $discount);
    success();
}

//Обработка метода removeFromCart
if ($_POST['apiMethod'] === 'removeFromCart') {

    //Получаем id товара из postData
    $product_id = $_POST['postData']['id'] ?? '';

    $user_id = $_SESSION['login']['id'];

    $showCartItem = showCartItem($product_id, $user_id);

//если в корзине нет товара с полученным id
    if (!$showCartItem['product_id']) {
        error("Товар с ID($id) в корзине отсутствует");
    } else {
        removeFromCart($product_id, $user_id);
        success();
    }
}

//Обработка метода clearCart
if ($_POST['apiMethod'] === 'clearCart') {

    $user_id = $_SESSION['login']['id'];
    clearCart($user_id);
    success();
}

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