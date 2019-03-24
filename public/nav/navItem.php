<?php

function getNav()
{
    return $navItems = [
        [
            'title' => 'Личный кабинет',
            'url' => '/userAccount.php',
        ],
        [
            'title' => 'Галлерея',
            'url' => '/homework_3',
        ],
        [
            'title' => 'Новости',
            'url' => '#',
        ],
        [
            'title' => 'Отзывы',
            'url' => '#',
        ],
        [
            'title' => 'Товары',
            'url' => '/products/readProducts.php?page=0',
        ],
        [
            'title' => 'Корзина',
            'url' => '#',
        ],
        [
            'title' => 'Контакты',
            'url' => '/contacts.php',
        ],
    ];
}