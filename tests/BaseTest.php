<?php

require_once '../config/config.php';

class BaseTest extends PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        App\App::getInstance();
    }
}