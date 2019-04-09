<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class ProductsControllerTest extends BaseTest
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
     * @throws Exception
     */
    public function testUpdate()
    {
        $this->assertTrue($this->fixture->update());
    }

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $this->assertTrue($this->fixture->create());
    }

    /**
     * @throws Exception
     */
    public function testView()
    {
        $this->assertTrue($this->fixture->view());
    }

    /**
     * @throws Exception
     */
    public function testDelete()
    {
        $this->assertTrue($this->fixture->delete());
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\ProductsController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}