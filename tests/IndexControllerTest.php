<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class IndexControllerTest extends BaseTest
{
    protected $fixture;

    /**
     * @throws Exception
     */
    public function testIndex()
    {
        $this->assertTrue($this->fixture->index());
    }

    /**
     * @dataProvider providerError
     * @param $data
     * @throws Exception
     */
    public function testError($data)
    {
        $this->assertTrue($this->fixture->error($data));
    }

    public function providerError()
    {
        return [
            ['data' => null],
            ['error' => true],
            ['error_text' => 'Ошибка'],
        ];
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\IndexController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}