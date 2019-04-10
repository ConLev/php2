<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class AccountControllerTest extends BaseTest
{
    protected $fixture;

    /**
     * @throws Exception
     */
    public function testIndex()
    {
        $this->assertTrue($this->fixture->index());
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\AccountController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}