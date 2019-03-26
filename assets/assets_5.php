<?php

/*
Apache:

AddDefaultCharset UTF-8
DirectoryIndex index.php index.html
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} -f [NC,OR]
RewriteCond %{REQUEST_FILENAME} -d [NC]
RewriteRule .* - [L]
RewriteRule ^(.*)/$ ?path=$1 [QSA,L]

*/

/*
Nginx:

location / {
    try_files $uri $uri/ /index.php?path=$uri&$args;
}

*/

//die;

//try {
//    $template = \App\Classes\Templater::getInstance()->twig->load('index.html');
//    $images = \App\Classes\DB::getInstance()->fetchAll("SELECT * FROM `images` ORDER BY `views` DESC");
//
//    echo $template->render([]);
//
//} catch (\Exception $e) {
//    die ('ERROR: ' . $e->getMessage());
//}