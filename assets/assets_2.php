<?php

class BaseClass
{
    function __construct()
    {
        echo "Конструктор класса BaseClass\n";
    }
}

class SubClass extends BaseClass
{
    function __construct()
    {
        parent::__construct();
        echo "Конструктор класса SubClass\n";
    }
}

$obj = new BaseClass();
echo '<br>';
$obj = new SubClass();
echo '<br>';

abstract class MyAbstractClass
{
    /* Данный метод должен быть переопределен в дочернем классе */
    abstract protected function getValue();

    /* Общий метод */
    public function printValue()
    {
        print $this->getValue() . "\n";
    }
}

class ChildClass extends MyAbstractClass
{
    protected function getValue()
    {
        return " ChildClass ";
    }
}

$class1 = new ChildClass();
$class1->printValue();
echo '<br>';

// Объявим интерфейс 'CarTemplate'
interface CarTemplate
{
    public function getId();    // Получить id автомобиля

    public function getName();  // Получить название

    public function add();      // Добавить новый автомобиль
}

// Объявим интерфейс 'CarTemplate'
class Audi implements CarTemplate
{
    function getId()
    {
        return "1-ATHD98";
    }

    function getName()
    {
        return "Audi";
    }

    function add()
    {
    }
}

class Bmw implements CarTemplate
{
    function getId()
    {
        return "2-HHFY14";
    }

    function getName()
    {
        return "BMW";
    }

    function add()
    {
    }
}

//public void __set (string $name , mixed $value)
//public mixed __get (string $name)

class MyClass
{
    public $c = "c value";

    public function __set($name, $value)
    {
        echo "__set, property - {$name} is not exists \n";
    }

    public function __get($name)
    {
        echo "__get, property - {$name} is not exists \n";
    }
}

$obj = new MyClass;
$obj->a = 1;    // Запись в свойство (свойство не существует)
echo '<br>';
echo $obj->b;   // Получаем значение свойства (свойство не существует)
echo '<br>';
echo $obj->c;   // Получаем значение свойства (свойство существует)
echo '<br>';

//public mixed __call (string $name , array $arguments)

class MyClass2
{
    public function __call($name, $arguments)
    {
        return "__call, method - {$name} is not exists \n";
    }

    public function getId()
    {
        return "AH-15474";
    }
}

$obj = new MyClass2;
echo $obj->getName(); // Вызов метода (метод не существует)
echo '<br>';
echo $obj->getId();   // Вызов метода (метод существует)
echo '<br>';

//public string __toString ()

class MyClass3
{
    public function __toString()
    {
        return "MyClass class";
    }
}

$obj = new MyClass3;
echo $obj;  // Результат: MyClass class
echo '<br>';

//function isValidStatusCode(int $statusCode): bool {
//    return isset($this->statuses[$statusCode]);
//}

class MyClass4
{
    public function names(array $names)
    {   // Тип Аrray
        $res = "<ul>";
        foreach ($names as $name) {
            $res .= "<li>{$name}</li>";
        }
        return $res .= "</ul>";
    }

    public function otherClassTypeFunc(OtherClass $otherClass)
    {    // Тип OtherClass
        return $otherClass->var1;
    }
}

$obj = new MyClass4;
$names = array(
    'Иван Андреев',
    'Олег Симонов',
    'Андрей Ефремов',
    'Алексей Самсонов'
);
echo $obj->names($names);   // Работает

//$names = "Олег Симонов";
// Получим фатальную ошибку: Argument 1 passed to MyClass::names() must be of the type array, string given
//echo $obj->names($names);

// Получим фатальную ошибку: Argument 1 passed to MyClass::names() must be an instance of OtherClass, string given
//echo $obj->otherClassTypeFunc("test string");

// App/Main/MyClass.php
//namespace App\Main;
//class MyClass
//{
//    function hello()
//    {
//        return "hello";
//    }
//}

// namespace.php
//namespace App\Main;
//require_once "App\Main\MyClass.php";
//$obj = new \App\Main\MyClass;
//echo $obj->hello(); // hello

// App/Core/MyClass.php
//namespace App\Core;
//class MyClass
//{
//    function hello()
//    {
//        return "hello, it's core";
//    }
//}

//namespace App\Core;
//require_once "App\Core\MyClass.php";
//$obj = new \App\Core\MyClass;
//echo $obj->hello(); // hello it's core

//use App/Core/Controller as CoreController;
//// …
//$app = new CoreController\AppControoler.php;

trait MyTrait
{
    public function myFunc()
    {
        return 2 + 2;
    }
}

trait MyTransliterator
{
    private $letters = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v',
        'г' => 'g', 'д' => 'd', 'е' => 'e',
        'е' => 'e', 'ж' => 'zh', 'з' => 'z',
        'и' => 'i', 'й' => 'y', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r',
        'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
        'ь' => '', 'ы' => 'y', 'ъ' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        'А' => 'A', 'Б' => 'B', 'В' => 'V',
        'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
        'Е' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
        'И' => 'I', 'Й' => 'Y', 'К' => 'K',
        'Л' => 'L', 'М' => 'M', 'Н' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R',
        'С' => 'S', 'Т' => 'T', 'У' => 'U',
        'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
        'Ь' => '', 'Ы' => 'Y', 'Ъ' => '_',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        'є' => 'ye', 'ї' => 'yi', 'і' => 'i',
        'Є' => 'YE', 'Ї' => 'YI', 'І' => 'I',
        ' ' => '_'
    );

    public function translate($str)
    {
        // Заменяем символы кириллицы на латиницу
        return strtr(trim($str), $this->letters);
    }
}

class MyClass7
{
    use MyTransliterator;
    private $data;

    /**
     * Некая функция для добавления данных в наш массив
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     *     Некая функция для подготовки данных
     */
    public function getPreparedData()
    {
        // Допустим, мы хотим сделать адрес страницы по названию
        // Тогда нам нужно перевести название с кириллическими символами на латиницу
        $this->data['url'] = strtolower($this->translate($this->data['title']));
        return $this->data;
    }
}

$obj = new MyClass7;
$obj->setData([
    'title' => 'Не очень простое название для страницы',
    'content' => 'Текст страницы'
]);
$data = $obj->getPreparedData();
echo "<pre>";
print_r($data);
echo "</pre>";

class Singleton
{
    private static $instance;  // Экземпляр объекта

// Защищаем от создания через new Singleton
    private function __construct()
    { /* ... @return Singleton */
    }

// Защищаем от создания через клонирование
    private function __clone()
    { /* ... @return Singleton */
    }

// Защищаем от создания через unserialize
    private function __wakeup()
    { /* ... @return Singleton */
    }

// Возвращает единственный экземпляр класса. @return Singleton
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function doAction()
    {
    }
}

/* Применение*/
Singleton::getInstance()->doAction();