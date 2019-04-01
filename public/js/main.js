$(document).ready(() => {

    function request(path, data, cb) {
        $.post({
            url: path,
            data: data,
            success: function (data) {
                //Вариант с json
                if (data.error) {
                    message(data['error_text']);
                } else {
                    cb(data.data);
                }
            }
        })
    }

    function message(message) {
        $message_field.text(message);

        setTimeout(() => {
            $message_field.text('');
        }, 3000);
    }

    function login() {
        //Получаем input'ы логина и пароля
        const $login_input = $('[name="login"]');
        const $password_input = $('[name="password"]');

        //Получаем значение login и password
        const login = $login_input.val();
        const password = $password_input.val();

        request('/api/authentication/login/', {
            login: login,
            password: password
        }, function () {
            location.replace('/account/');
        });
    }

    $('.item-product').on('click', '.item-add_link_top', e => {
        e.preventDefault();
        console.log($(e.currentTarget).data('id'));
        console.log($(e.currentTarget).data('image'));
        console.log($(e.currentTarget).data('name'));
        console.log($(e.currentTarget).data('price'));
        console.log($(e.currentTarget).data('discount'));
        console.log($(e.currentTarget).data('quantity'));
        request('/api/products/add/', {
            id: $(e.currentTarget).data('id'),
            img: $(e.currentTarget).data('img'),
            name: $(e.currentTarget).data('name'),
            price: $(e.currentTarget).data('price'),
            discount: $(e.currentTarget).data('discount'),
            quantity: $(e.currentTarget).data('quantity'),
        }, function (data) {
            // location.reload();
            $message_field.text(data['data']);
        });

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

    $('.cart-product-quantity').on('click', '.cart-quantity-value', e => {
        request('/api/cart/update/', {
            id: $(e.currentTarget).data('id'),
            quantity: (e.currentTarget).value,
            price: $(e.currentTarget).data('price'),
            discount: $(e.currentTarget).data('discount'),
        }, function () {
            location.reload();
        });
    });

    $('.product-box-details').on('click', '.cart-product-remBtn', e => {
        e.preventDefault();
        request('/api/cart/remove/', {
            product_id: $(e.currentTarget).data('id'),
        }, function () {
            location.reload();
        });
    });

    const $cartButton = $('.shopping-cart-button');

    $cartButton.on('click', '.shopping-cart-button_clear', () => {

        request('/api/cart/clear/', {}, function () {
            location.reload();
        });
    });

    //Инициализируем поле для сообщений
    const $message_field = $('.message');

    //Login
    const $loginBtn = $('.user_account_submit');
    $loginBtn.on('click', login);
});