<?php

declare(strict_types=1);

use App\Classes\MathClass;

class MathClassTest extends PHPUnit\Framework\TestCase
{
    public function testFactorial()
    {
        $my = new MathClass();
        $this->assertEquals(6, $my->factorial(3));
    }
}

class MathClassTest2 extends PHPUnit\Framework\TestCase
{
    protected $fixture;

    /**
     * @dataProvider providerFactorial
     * @param $a
     * @param $b
     */
    public function testFactorial($a, $b)
    {
//        $my = new MathClass();
//        $this->assertEquals($b, $my->factorial($a));
        $this->assertEquals($b, $this->fixture->factorial($a));
    }

    public function providerFactorial()
    {
        return [
            [0, 1],
            [1, 1],
            [2, 2],
            [3, 6],
            [4, 24],
            [5, 120],
        ];
    }

    protected function setUp(): void
    {
        $this->fixture = new MathClass();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}