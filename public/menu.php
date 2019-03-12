<?php

class Menu
{
    public static function view($arr, $ul_class, $li_class, $a_class)
    {
        echo "<ul class= '$ul_class' >";
        foreach ($arr as $list_item) {
            echo "<li class='$li_class'>";
            echo "<a class='$a_class' href='{$list_item['url']}'>{$list_item['title']}</a>";
            //if (isset($list_item['items']) && is_array($list_item['items'])) { // вариант преподавателя
            if (array_key_exists('items', $list_item) && is_array($list_item['items'])) {
                self:: view($list_item['items'], 'sub_menu', 'sub_menu_list', 'sub_menu_link');
            }
            echo '</li>';
        }
        echo "</ul>";
    }
}

$arr = [
    [
        'title' => 'Главная',
        'url' => '/',
    ],
    [
        'title' => 'Галлерея',
        'url' => '/gallery/gallery.php',
    ],
    [
        'title' => 'Новости',
        'url' => '/news.php',
        'items' => [
            [
                'title' => 'О котиках',
                'url' => '/articles/cats/cats.php',
                'items' => [
                    [
                        'title' => 'О домашних котиках',
                        'url' => '/articles/cats/home_cats/cats.php'
                    ],
                ],
            ],
            [
                'title' => 'О собачках',
                'url' => '/articles/dogs/dogs.php',
                'items' => [
                    [
                        'title' => 'О домашних собачках',
                        'url' => '/articles/dogs/home_dogs/dogs.php'
                    ],
                ],
            ],
        ],
    ],
    [
        'title' => 'Отзывы',
        'url' => '/reviews.php',
    ],
    [
        'title' => 'Товары',
        'url' => '/products/readProducts.php',
    ],
    [
        'title' => 'Контакты',
        'url' => '/contacts.php',
    ],
];

Menu::view($arr, 'top_menu', 'top_menu_list', 'top_menu_link');