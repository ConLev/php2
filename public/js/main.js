//Функция AJAX авторизации
function login() {
    //Получаем input'ы логина и пароля
    const $login_input = $('[name="login"]');
    const $password_input = $('[name="password"]');

    //Получаем значение login и password
    const login = $login_input.val();
    const password = $password_input.val();

    //Инициализируем поле для сообщений
    const $message_field = $('.login_message');

    //Вызываем функцию jQuery AJAX с методом POST
    //Передаем туда url где будет обрабатываться API
    //и data которое будет помещена в $_POST
    //success - вызывается при успешном ответе от сервера
    $.post({
        url: '/api.php',
        data: {
            apiMethod: 'login',
            postData: {
                login: login,
                password: password
            }
        },
        //data - приходят те данные, которые прислал сервер
        success: function (data) {
            if (data.data) {
                window.location.replace('/userAccount.php');
            }
            if (data.error) {
                $message_field.text(data['error_text']);
                $login_input.val('');
                $password_input.val('');
            }
        },
    });
}