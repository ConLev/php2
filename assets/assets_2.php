<?php

class Article
{
    public $id;
    public $title;
    public $content;

    // Метод для вывода статьи
    function view()
    {
        echo "<h1>$this->title</h1><p>$this->content</p>";
    }
}

$a = new Article();
$a->id = 1;
$a->title = 'Новая статья';
$a->content = 'Какой-то текст!';
$a->view();

class Article2
{
    public $id;
    public $title;
    public $content;

    function __construct($id, $title, $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    // Метод для вывода статьи
    function view()
    {
        echo "<h1>$this->title</h1><p>$this->content</p>";
    }
}

$a = new Article2(1, 'Новая статья', 'Какой-то текст!');
$a->view();

class J
{
    function Test()
    {
        echo 'Это класс J<br />';
    }

    function Call()
    {
        $this->Test();
    }
}

class K extends J
{
    function Test()
    {
        echo 'Это класс K<br />';
    }
}

$j = new J();
$k = new K();
$j->Call(); // Выводит: «Это класс A»
$k->Test(); // Выводит: «Это класс K»
$k->Call(); // Выводит: «Это класс K»

class Article3
{
    private $id;
// ...
}

$a = new Article3();

//echo $a->id; // Обратились к приватному полю не изнутри класса

class MathOperations
{
    const PI = 3.14;

    public function abs($x)
    {
        return ($x >= 0) ? $x : (-1) * $x;
    }

    public function RangeLength($rad)
    {
        return 2 * $rad * self::PI;
    }
}

$MathOperations = new MathOperations();
echo $MathOperations->RangeLength(12);
echo $MathOperations->abs(-15);
echo $MathOperations::PI;

class MathOperations2
{
    const PI = 3.14;

    public static function abs($x)
    {
        return ($x >= 0) ? $x : (-1) * $x;
    }

    public static function RangeLength($rad)
    {
        return 2 * $rad * self::PI;
    }
}

echo MathOperations2::RangeLength(12);
echo MathOperations2::abs(-15);
echo MathOperations2::PI;