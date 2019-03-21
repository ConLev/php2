<?php

//Стартуем сессию
session_start();

//инициализация констант дерикторий
define('SITE_ROOT', __DIR__ . '/../');
define('CONFIG_DIR', SITE_ROOT . 'config/');
define('DATA_DIR', SITE_ROOT . 'data/');
define('ENGINE_DIR', SITE_ROOT . 'engine/');
define('WWW_DIR', SITE_ROOT . 'public/');
define('TPL_DIR', SITE_ROOT . 'templates/');
define('VENDOR_DIR', SITE_ROOT . 'vendor/');

//подключение файлов логики
require_once VENDOR_DIR . 'autoload.php';
require_once ENGINE_DIR . '/Traits/SingletonTrait.php';
require_once ENGINE_DIR . '/Classes/TemplateEngine.php';
require_once ENGINE_DIR . '/Classes/DB.php';

require_once WWW_DIR . '/nav/navItem.php';