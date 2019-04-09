<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class AuthenticationControllerTest extends BaseTest
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
     * @dataProvider providerLogin
     * @param $data
     * @throws Exception
     */
    public function testLogin($data)
    {
        $this->assertTrue($this->fixture->login($data));
    }

    public function providerLogin()
    {
        return [
            ['login' => 'admin'],
            ['password' => 'password'],
        ];
    }

    /**
     * @throws Exception
     */
    public function testLogout()
    {
        $this->assertTrue($this->fixture->logout());
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\AuthenticationController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}