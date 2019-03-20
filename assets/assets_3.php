<?php

/*
 * Homework
 */

//use App/Path/To/MyClass as MyClass

/*
 * try-catch
 */

$exception = new Exception();
throw $exception;

//getMessage() – получает сообщение исключения;
//getCode() – возвращает числовой код, который представляет исключение;
//getFile() – возвращает файл, в котором произошло исключение;
//getLine() – возвращает номер строки в файле, где произошло исключение;
//getTrace() – возвращает массив backtrace() до возникновения исключения;
//getPrevious() – возвращает исключение, произошедшее перед текущим, если оно было;
//getTraceAsString() – возвращает массив backtrace() исключения в виде строки;

class A
{
    function myMethod()
    {
        // do something
        throw new Exception("Exception time!");
    }
}

$my_a = new A();
try {
    $my_a->myMethod();
} catch (Exception $e) {
    echo $e->getMessage();
}

/*
 * Подключение к БД
 */

try {
    $dbh = new PDO('mysql:dbname=geek_brains;host=localhost', 'root', '123123');
} catch (PDOException $e) {
    echo "Error: Could not connect. " . $e->getMessage();
}

// Установка error-режима
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM books";
$sth = $dbh->prepare($sql);
$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_OBJ);
unset($dbh);

/*
 * composer
 */

try {
// Указывает, где хранятся шаблоны
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
// Инициализируем Twig
    $twig = new \Twig\Environment($loader);
// Подгружаем шаблон
    $template = $twig->load('index.html');
// Передаем в шаблон переменные и значения
// Выводим сформированное содержание
    echo $template->render([
        'name' => 'Clark Kent',
        'username' => 'ckent',
        'password' => 'krypt0n1te',
    ]);
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}

//<html>
//<head></head>
//<body>
//<h2>Account successfully created!</h2>
//<p>Hello {{ name }}</p>
//<p>Thank you for registering with us. Your account details are as follows: </p>
//<p style="margin-left: 10px">
//	Username: {{ username }} <br/>
//	Password: {{ password }}
//</p>
//<p>You've already been logged in, so go on in and have some fun!</p>
//</body>
//</html>

/*
 * Условные операторы twig
 */

//
//<html>
//  <head></head>
//  <body>
//<h2>Odd or Even</h2>
//	    {% if div == 0 %}
//	      {{ num }} is even.
//	    {% else %}
//	      {{ num }} is odd.
//	    {% endif % }
//  </body>
//</html>

$num = rand(0, 30);
$div = ($num % 2);

echo $template->render([
    'num' => $num,
    'div' => $div
]);

/*
 * Пример 2
 */

//<html>
//<head></head>
//<body>
//<h2>Seasons</h2>
//{% if month > 0 and month <= 3 %}
//	Spring is here, watch the flowers bloom!
//{% elseif month > 3 and month <= 6 %}
//	Summer is here, time to hit the beach!
//{% elseif month > 6 and month <= 9 %}
//	Autumn is here, watch the leaves slowly fall!
//{% elseif month > 9 and month <= 12 %}
//	Winter is here, time to hit the slopes!
//{% endif %}
//</body>
//</html>

echo $template->render([
    'month' => date('m', time())
]);

/*
 * Циклы
 */

//<html>
//  <head></head>
//  <body>
//    <h2>Shopping list</h2>
//    <ul>
//      {% for item in items %}
//        <li>{{ item }}</li>
//      {% endfor %}
//    </ul>
//  </body>
//</html>

$items = [
    'eye of newt',
    'wing of bat',
    'leg of frog',
    'hair of beast'
];

echo $template->render(array(
    'items' => $items
));

/*
 * Ассоцитивные массивы
 */

//<html>
//<head>
//	<style type="text/css">
//	table {
//	border-collapse: collapse;
//		}
//		tr.heading {
//	font-weight: bolder;
//		}
//		td {
//	border: 1px solid black;
//			padding: 0 0.5em;
//		}
//	</style>
//</head>
//<body>
//<h2>Book details</h2>
//<table>
//	<tr>
//		<td><strong>Title</strong></td>
//		<td>{{ book.title }}</td>
//	</tr>
//	<tr>
//		<td><strong>Author</strong></td>
//		<td>{{ book.author }}</td>
//	</tr>
//	<tr>
//		<td><strong>Publisher</strong></td>
//		<td>{{ book.publisher }}</td>
//	</tr>
//	<tr>
//		<td><strong>Pages</strong></td>
//		<td>{{ book.pages }}</td>
//	</tr>
//	<tr>
//		<td><strong>Category</strong></td>
//		<td>{{ book.category }}</td>
//	</tr>
//</table>
//</body>
//</html>

$book = [
    'title' => 'Harry Potter and the Deathly Hallows',
    'author' => 'J. K. Rowling',
    'publisher' => 'Scholastic',
    'category' => 'Children\'s fiction',
    'pages' => '784'
];
echo $template->render(array(
    'book' => $book
));

/*
 * Пример для работы с БД
 */

//<html>
//<head>
//	<style type="text/css">
//	table {
//	border-collapse: collapse;
//		}
//
//		tr.heading {
//	font-weight: bolder;
//		}
//
//		td {
//	border: 1px solid black;
//			padding: 0 0.5em;
//		}
//	</style>
//</head>
//<body>
//<h2>Countries and capitals</h2>
//<table>
//	<tr class="heading">
//		<td>Title</td>
//		<td>Author</td>
//		<td>Publisher</td>
//		<td>Category</td>
//		<td>Pages</td>
//	</tr>
//	{% for d in data %}
//	<tr>
//		<td>{{ d.title|escape }}</td>
//		<td>{{ d.author|escape }}</td>
//		<td>{{ d.publisher|escape }}</td>
//		<td>{{ d.category|escape }}</td>
//		<td>{{ d.pages|escape }}</td>
//	</tr>
//	{% endfor %}
//</table>
//</body>
//</html>

$dbh = new PDO('mysql:dbname=geek_brains;host=localhost', 'root', '123123');
// Установка error-режима
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM books";
$sth = $dbh->prepare($sql);
$sth->execute();
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
unset($dbh);

echo $template->render([
    'data' => $data
]);

/*
 * Подгрузка
 */

//<html>
//<head>
//	<link rel="stylesheet" type="text/css" href="main.css" />
//</head>
//<body>
//<div id="page">
//	<div id="header">
//		{% include 'primary.html' %}
//	</div>
//	<div id="left">
//		{% include 'secondary.html' %}
//	</div>
//	<div id="right">
//	This is the main page content. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
//	</div>
//	<div id="footer">
//		{% include 'footer.html' %}
//	</div>
//</div>
//</body>
//</html>

$nav = [
    'primary' => [
        ['name' => 'Clothes', 'url' => '/clothes'],
        ['name' => 'Shoes and Accessories', 'url' => '/accessories'],
        ['name' => 'Toys and Gadgets', 'url' => '/toys'],
        ['name' => 'Books and Movies', 'url' => '/media'],
    ],
    'secondary' => [
        ['name' => 'By Price', 'url' => '/selector/v328ebs'],
        ['name' => 'By Brand', 'url' => '/selector/gf843k2b'],
        ['name' => 'By Interest', 'url' => '/selector/t31h393'],
        ['name' => 'By Recommendation', 'url' => '/selector/gf942hb']
    ]
];
echo $template->render([
    'nav' => $nav,
    'updated' => '24 Jan 2011'
]);

/*
 * Фильтры
 */

//<html>
//  <head></head>
//  <body>
//  {{ "now"|date("d M Y h:i")  }} <br/>
//  {{ "now"|date("d/m/y")  }}
//  </body>
//</html>
//
//<html>
//  <head></head>
//  <body>
//  {{ "the cow jumped over the moon"|upper  }} <br/>
//  {{ "the cow jumped over the moon"|capitalize  }} <br/>
//  {{ "the cow jumped over the moon"|title  }} <br/>
//  {{ "The Cow jumped over the Moon"|lower  }} <br/>
//  </body>
//</html>
//
//<html>
//  <head></head>
//  <body>
//  {{ "<div>I said \"<b>Go away!</b>\"</div>"|striptags  }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {{ "I want a red boat"|replace({"red" : "yellow", "boat" : "sports car"})  }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//Escaped output: {{ html|escape }} <br/>
//  Raw output: {{ html|raw }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {% autoescape true %}
//  Escaped output: {{ html }} <br/>
//  {% endautoescape %}
//  {% autoescape false %}
//  Raw output: {{ html }}
//  {% endautoescape %}
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  <h2>Account successfully created!</h2>
//	  <p>Hello {{ name }}</p>
//	  <p>Thank you for registering with us. Your account details are as follows: </p>
//  <p style="margin-left: 10px">
//	  Username: {{ username }} <br/>
//	  Password: {{ password }}
//	  </p>
//	  <p>You've already been logged in, so go on in and have some fun!</p>
//  </body>
//</html>

//// Подгружаем и активируем автозагрузчик Twig-а
//require_once 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//try {
//// Указывает, где хранятся шаблоны
//    $loader = new Twig_Loader_Filesystem('templates');
//// Инициализируем Twig
//    $twig = new Twig_Environment($loader);
//// Подгружаем шаблон
//    $template = $twig->loadTemplate('thanks.tmpl');
//// Передаем в шаблон переменные и значения
//// Выводим сформированное содержание
//    echo $template->render(array(
//        'name' => 'Clark Kent',
//        'username' => 'ckent',
//        'password' => 'krypt0n1te',
//    ));
//} catch (Exception $e) {
//    die ('ERROR: ' . $e->getMessage());
//}

//<html>
//  <head></head>
//  <body>
//<h2>Odd or Even</h2>
//	    {% if div == 0 %}
//	      {{ num }} is even.
//	    {% else %}
//	      {{ num }} is odd.
//	    {% endif % }
//  </body>
//</html>

//	include 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//try {
//  $loader = new Twig_Loader_Filesystem('templates');
//  $twig = new Twig_Environment($loader);
//  $template = $twig->loadTemplate('numbers.tmpl');
//// Генерируем случайное число
//// Проверяем его на четность
//  $num = rand (0,30);
//  $div = ($num % 2);
//  echo $template->render(array (
//    'num' => $num,
//    'div' => $div
//  ));
//} catch (Exception $e) {
//  die ('ERROR: ' . $e->getMessage());
//}

//<html>
//	<head></head>
//	  <body>
//	    <h2>Seasons</h2>
//	    {% if month > 0 and month <= 3 %}
//	      Spring is here, watch the flowers bloom!
//	    {% elseif month > 3 and month <= 6 %}
//	      Summer is here, time to hit the beach!
//	    {% elseif month > 6 and month <= 9 %}
//	      Autumn is here, watch the leaves slowly fall!
//	    {% elseif month > 9 and month <= 12 %}
//	      Winter is here, time to hit the slopes!
//	    {% endif %}
//	  </body>
//</html>

//include 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//try {
//  $loader = new Twig_Loader_Filesystem('templates');
//  $twig = new Twig_Environment($loader);
//   $template = $twig->loadTemplate('seasons.tmpl');
//// Получаем номер месяца
//  $month = date('m', mktime());
//  echo $template->render(array (
//    'month' => $month
//  ));
//} catch (Exception $e) {
//  die ('ERROR: ' . $e->getMessage());
//}

//<html>
//  <head></head>
//  <body>
//    <h2>Shopping list</h2>
//    <ul>
//      {% for item in items %}
//        <li>{{ item }}</li>
//      {% endfor %}
//    </ul>
//  </body>
//</html>

//// Формируем массив
//$items = array(
//  'eye of newt',
//  'wing of bat',
//  'leg of frog',
//  'hair of beast'
//);
// include 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//try {
//  $loader = new Twig_Loader_Filesystem('templates');
//  $twig = new Twig_Environment($loader);
//  $template = $twig->loadTemplate('list.tmpl');
//  echo $template->render(array (
//    'items' => $items
//  ));
//} catch (Exception $e) {
//  die ('ERROR: ' . $e->getMessage());
//}

//<html>
//	  <head>
//	    <style type="text/css">
//	      table {
//	        border-collapse: collapse;
//	      }
//	      tr.heading {
//	        font-weight: bolder;
//	      }
//	      td {
//	        border: 1px solid black;
//	        padding: 0 0.5em;
//	      }
//	    </style>
//	  </head>
//	  <body>
//	    <h2>Book details</h2>
//	    <table>
//	      <tr>
//	        <td><strong>Title</strong></td>
//	        <td>{{ book.title }}</td>
//	      </tr>
//	      <tr>
//	        <td><strong>Author</strong></td>
//	        <td>{{ book.author }}</td>
//	      </tr>
//	      <tr>
//	        <td><strong>Publisher</strong></td>
//	        <td>{{ book.publisher }}</td>
//	      </tr>
//	      <tr>
//	        <td><strong>Pages</strong></td>
//	        <td>{{ book.pages }}</td>
//	      </tr>
//	      <tr>
//	        <td><strong>Category</strong></td>
//	        <td>{{ book.category }}</td>
//	      </tr>
//	    </table>
//	  </body>
//</html>

//// Готовим ассоциативный массив
//	$book = array(
//	  'title'     => 'Harry Potter and the Deathly Hallows',
//	  'author'    => 'J. K. Rowling',
//	  'publisher' => 'Scholastic',
//	  'category'  => 'Children\'s fiction',
//	  'pages'     => '784'
//	);
//	include 'Twig/Autoloader.php';
//	Twig_Autoloader::register();
//	try {
//	  $loader = new Twig_Loader_Filesystem('templates');
//	  $twig = new Twig_Environment($loader);
//	  $template = $twig->loadTemplate('book.tmpl');
//	  echo $template->render(array (
//	    'book' => $book
//	  ));
//	} catch (Exception $e) {
//	  die ('ERROR: ' . $e->getMessage());
//	}

//<html>
//	  <head>
//	    <style type="text/css">
//	      table {
//	        border-collapse: collapse;
//	      }
//	      tr.heading {
//	        font-weight: bolder;
//	      }
//	      td {
//	        border: 1px solid black;
//	        padding: 0 0.5em;
//	      }
//	    </style>
//	  </head>
//	  <body>
//	    <h2>Countries and capitals</h2>
//	    <table>
//	      <tr class="heading">
//	        <td>Country</td>
//	        <td>Region</td>
//	        <td>Population</td>
//	        <td>Capital</td>
//	        <td>Language</td>
//	      </tr>
//	      {% for d in data %}
//	      <tr>
//	        <td>{{ d.name|escape }}</td>
//	        <td>{{ d.region|escape }}</td>
//	        <td>{{ d.population|escape }}</td>
//	        <td>{{ d.capital|escape }}</td>
//	        <td>{{ d.language|escape }}</td>
//	      </tr>
//	      {% endfor %}
//	    </table>
//	  </body>
//</html>

//include 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//// Подключение к бд
//try {
//  $dbh = new PDO('mysql:dbname=world;host=localhost', 'root', 'guessme');
//} catch (PDOException $e) {
//  echo "Error: Could not connect. " . $e->getMessage();
//}
//// Установка error-режима
//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//// Выполняем запрос
//try {
//// Формируем SELECT-запрос
//// В результате каждая строка таблицы будет объектом
//  $sql = "SELECT country.Code AS code, country.Name AS name, country.Region AS region, country.Population AS population, countrylanguage.Language AS language, ity.Name AS capital FROM country, city, countrylanguage WHERE country.Code = city.CountryCode AND country.Capital = city.ID AND country.Code = countrylanguage.CountryCode AND countrylanguage.IsOfficial = 'T' ORDER BY population DESC LIMIT 0,20";
//  $sth = $dbh->query($sql);
//  while ($row = $sth->fetchObject()) {
//    $data[] = $row;
//  }
//// Закрываем соединение
//  unset($dbh);
//   $loader = new Twig_Loader_Filesystem('templates');
//  $twig = new Twig_Environment($loader);
//  $template = $twig->loadTemplate('countries2.tmpl');
//  echo $template->render(array (
//    'data' => $data
//  ));
//} catch (Exception $e) {
//  die ('ERROR: ' . $e->getMessage());
//}

//<html>
//  <head>
//    <link rel="stylesheet" type="text/css" href="main.css" />
//  </head>
//  <body>
//    <div id="page">
//      <div id="header">
//      {% include 'primary.tmpl' %}
//      </div>
//      <div id="left">
//        {% include 'secondary.tmpl' %}
//      </div>
//      <div id="right">
//      This is the main page content. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
//      </div>
//      <div id="footer">
//        {% include 'footer.tmpl' %}
//      </div>
//    </div>
//  </body>
//</html>

//<!-- begin: primary.tmpl -->
//    <table>
//      <tr>
//        {% for item in nav.primary %}
//        <td><a href="{{ item.url }}">{{ item.name|upper }}</a></td>
//        {% endfor %}
//      </tr>
//    </table>
//<!-- end: primary.tmpl -->
//
//<!-- begin: secondary.tmpl -->
//   <ul>
//     {% for item in nav.secondary %}
//     <li><a href="{{ item.url }}">{{ item.name }}</a></li>
//     {% endfor %}
//   </ul>
//<!-- end: secondary.tmpl -->
//
//<!-- begin: footer.tmpl -->
// <div style="align:center">
// This page licensed under a Creative Commons License. Last updated on: {{ updated }}.
// </div>
//<!-- end: footer.tmpl -->

//// формируем массив
//$nav = array(
//  'primary' => array(
//    array('name' => 'Clothes', 'url' => '/clothes'),
//    array('name' => 'Shoes and Accessories', 'url' => '/accessories'),
//    array('name' => 'Toys and Gadgets', 'url' => '/toys'),
//    array('name' => 'Books and Movies', 'url' => '/media'),
//  ),
//  'secondary' => array(
//    array('name' => 'By Price', 'url' => '/selector/v328ebs'),
//    array('name' => 'By Brand', 'url' => '/selector/gf843k2b'),
//    array('name' => 'By Interest', 'url' => '/selector/t31h393'),
//    array('name' => 'By Recommendation', 'url' => '/selector/gf942hb')
//  )
//);
//include 'Twig/Autoloader.php';
//Twig_Autoloader::register();
//try {
//  $loader = new Twig_Loader_Filesystem('templates');
//  $twig = new Twig_Environment($loader);
//  $template = $twig->loadTemplate('shop.tmpl');
//  echo $template->render(array (
//    'nav' => $nav,
//    'updated' => '24 Jan 2011'
//  ));
//} catch (Exception $e) {
//  die ('ERROR: ' . $e->getMessage());
//}

//<html>
//  <head></head>
//  <body>
//  {{ "now"|date("d M Y h:i")  }} <br/>
//  {{ "now"|date("d/m/y")  }}
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {{ "the cow jumped over the moon"|upper  }} <br/>
//  {{ "the cow jumped over the moon"|capitalize  }} <br/>
//  {{ "the cow jumped over the moon"|title  }} <br/>
//  {{ "The Cow jumped over the Moon"|lower  }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {{ "<div>I said \"<b>Go away!</b>\"</div>"|striptags  }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {{ "I want a red boat"|replace({"red" : "yellow", "boat" : "sports car"})  }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  Escaped output: {{ html|escape }} <br/>
//  Raw output: {{ html|raw }} <br/>
//  </body>
//</html>

//<html>
//  <head></head>
//  <body>
//  {% autoescape true %}
//  Escaped output: {{ html }} <br/>
//  {% endautoescape %}
//  {% autoescape false %}
//  Raw output: {{ html }}
//  {% endautoescape %}
//  </body>
//</html>

//$exception = new Exception();
//throw $exception;

//class A{
//  function myMethod(){
//    // do something
//    throw new Exception("Exception time!");
//  }
//}
//$my_a = new A();
//try{
//   $my_a-> myMethod();
//}
//catch(Exception $e){
//   echo $e->getMessage();
//}