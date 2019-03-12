<?php

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
    $user = show($sql);

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

    //Получаем данные из postData
    $id = $_POST['postData']['id'] ?? '';
    $image = $_POST['postData']['img'] ?? '';
    $name = $_POST['postData']['name'] ?? '';
    $price = $_POST['postData']['price'] ?? '';
    $quantity = $_POST['postData']['quantity'] ?? '';

//пытаемся добавить товар в корзину
    $cartItem = showCartItem($id);
    addToCart($id, $name, $price, $image, $quantity);
    $amount = (!$cartItem['id']) ? $quantity : ++$cartItem['quantity'];
    $message = (!$cartItem['id']) ? "Товар с ID($id) добавлен в корзину" :
        "Количество товара с ID($id) в корзине $amount шт.";
    //устанавливаем новое куки
    setcookie("cart[$id]", $amount);
    success($message);
}

//Обработка метода updateCart
if ($_POST['apiMethod'] === 'updateCart') {

    //Получаем данные из postData
    $id = $_POST['postData']['id'] ?? '';
    $quantity = $_POST['postData']['quantity'] ?? '';
    $price = $_POST['postData']['price'] ?? '';

    updateCartItem($id, $quantity, $price);
    setcookie("cart[$id]", $quantity);
    success();
}

//Обработка метода removeFromCart
if ($_POST['apiMethod'] === 'removeFromCart') {

    //Получаем id товара из postData
    $id = $_POST['postData']['id'] ?? '';

    $showCartItem = showCartItem($id);

//если в корзине нет товара с полученным id
    if (!$showCartItem['id']) {
        error("Товар с ID($id) в корзине отсутствует");
    } else {
        removeFromCart((int)$id);
        success();
    }
}

//Обработка метода clearCart
if ($_POST['apiMethod'] === 'clearCart') {

    clearCart();
    success();
}

//Обработка метода createOrder
if ($_POST['apiMethod'] === 'createOrder') {

    //если пользователь не авторизован, перенаправляем его на форму аутентификации
    if (empty($_SESSION['login'])) {
        header('Location: /');
    }

    $user_id = (int)$_SESSION['login']['id'];

//если корзина пуста выводим ошибку
    if (empty($_COOKIE['cart'])) {
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
    foreach ($_COOKIE['cart'] as $productId => $amount) {
        $productId = (int)$productId;
        $amount = (int)$amount;
        $values[] = "($orderId, $productId, $amount)";
    }

    $values = implode(', ', $values);

    $sql = "INSERT INTO `orders_products` (`order_id`, `product_id`, `amount`) VALUES $values";

//выполняем запрос
    if (execQuery($sql)) {
        //очищаем корзину
        clearCart();
        //очищаем куки корзины
        foreach ($_COOKIE['cart'] as $productId => $amount) {
            setcookie("cart[$productId]", null, -1, '/');
        }
        success();
//        success("Заказ успешно создан");
    } else {
        error("Произошла ошибка");
    }
}

//Обработка метода updateStatus
if ($_POST['apiMethod'] === 'updateStatus') {

    //Получаем данные из postData
    $orderId = $_POST['postData']['order_id'] ?? '';
    $status = $_POST['postData']['status'] ?? '';

    updateStatus($orderId, $status);
    success();
}