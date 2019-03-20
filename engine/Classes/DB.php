<?php

namespace engine\Classes;

use engine\Traits\SingletonTrait;
use \PDO;

class DB
{
    use SingletonTrait;

    public $pdo;

    protected function __construct()
    {
        $this->pdo = new PDO('mysql:dbname=geek_brains_shop;host=localhost', 'geek_brains', '123123');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function fetchAll($sql)
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        return $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}