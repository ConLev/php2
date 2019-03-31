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

    //Инициализируем поле для сообщений
    const $message_field = $('.message');

    //Login
    const $loginBtn = $('.user_account_submit');
    $loginBtn.on('click', login);
});