<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{TITLE}}</title>
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
<nav class="nav">
    <ul class="top_menu">
        <li class="top_menu_list"><a class="top_menu_link" href="/userAccount.php">Личный кабинет</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/gallery/gallery.php">Галлерея</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/news.php">Новости</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/reviews.php">Отзывы</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/products/readProducts.php">Товары</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/cart/viewCart.php">Корзина</a></li>
        <li class="top_menu_list"><a class="top_menu_link" href="/contacts.php">Контакты</a></li>
        <li class="logout_list"><a class="logout_link" href="/logout.php">Выйти</a></li>
    </ul>
</nav>
<div class="container">
    <h1>{{H1}}</h1>
    <p class="success_message"></p>
    <div class="shopping-cart_wrapper">
        <div class="products-box-header">
            <span>Product Details</span>
            <span class="unite-price-header">unite Price</span>
            <span class="quantity-header">Quantity</span>
            <span class="shipping-header">shipping</span>
            <span class="subtotal-header">Subtotal</span>
            <span class="action-header">ACTION</span>
        </div>
        <div class="products-box">{{CONTENT}}</div>
        <div class="shopping-cart-button">
            <span><a href="#" class="shopping-cart-button_clear">CLEAR SHOPPING CART</a></span>
            <span>{{CREATE_ORDER}}</span>
            <span><a href="/products/readProducts.php"
                     class="shopping-cart-button_continue">CONTINUE SHOPPING</a></span>
        </div>
    </div>
</div>
<footer class="footer">Все права защищены {{YEAR}}</footer>
<script src="/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(() => {
        //Инициализируем поле для сообщений
        const $message_field = $('.success_message');
        $('.product-box-details').on('click', '.cart-product-remBtn', e => {
            e.preventDefault();
            $.post({
                url: '/api.php',
                data: {
                    apiMethod: 'removeFromCart',
                    postData: {
                        id: $(e.currentTarget).data('id'),
                    }
                },
                success: function (data) {
                    //data - приходят те данные, которые прислал сервер
                    if (data.data) {
                        location.reload();
                    }
                    if (data.error) {
                        $message_field.text(data['error_text']);
                    }
                }
            });
        });
        $('.cart-product-quantity').on('click', '.cart-quantity-value', e => {
            $.post({
                url: '/api.php',
                data: {
                    apiMethod: 'updateCart',
                    postData: {
                        id: $(e.currentTarget).data('id'),
                        quantity: (e.currentTarget).value,
                        price: $(e.currentTarget).data('price'),
                    }
                },
                success: function (data) {
                    if (data.data) {
                        location.reload();
                    }
                    if (data.error) {
                        $message_field.text(data['error_text']);
                    }
                }
            });
        });
        $('.shopping-cart-button').on('click', '.shopping-cart-button_clear', () => {
            $.post({
                url: '/api.php',
                data: {
                    apiMethod: 'clearCart',
                },
                success: function (data) {
                    if (data.data) {
                        location.reload();
                    }
                    if (data.error) {
                        $message_field.text(data['error_text']);
                    }
                }
            });
        });
        $('.shopping-cart-button').on('click', '.shopping-cart-button_button_createOrder', () => {
            $.post({
                url: '/api.php',
                data: {
                    apiMethod: 'createOrder',
                },
                success: function (data) {
                    if (data.data) {
                        location.reload();
                        // $message_field.text(data['data']);
                    }
                    if (data.error) {
                        $message_field.text(data['error_text']);
                    }
                }
            });
        });
    });
</script>
</body>
</html>