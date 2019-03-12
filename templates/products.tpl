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
    <article>
        <h3 class="heading-items">Featured Items</h3>
        <p class="tac">Shop for items based on what we featured in this week</p>
        <p class="message"></p>
        <div class="box-product">{{CONTENT}}</div>
    </article>
</div>
<footer class="footer">Все права защищены {{YEAR}}</footer>
<script src="/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(() => {
        //Инициализируем поле для сообщений
        const $message_field = $('.message');
        $('.item-product').on('click', '.item-add_link_top', e => {
            e.preventDefault();
            $.post({
                url: '/api.php',
                data: {
                    apiMethod: 'addToCart',
                    postData: {
                        id: $(e.currentTarget).data('id'),
                        img: $(e.currentTarget).data('img'),
                        name: $(e.currentTarget).data('name'),
                        price: $(e.currentTarget).data('price'),
                        quantity: $(e.currentTarget).data('quantity'),
                    }
                },
                success: function (data) {
                    //data - приходят те данные, которые прислал сервер
                    if (data.data) {
                        $message_field.text(data['data']);
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