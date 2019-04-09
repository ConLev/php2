<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class CartControllerTest extends BaseTest
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
     * @dataProvider providerAdd
     * @param $data
     * @throws Exception
     */
    public function testAdd($data)
    {
        $this->assertTrue($this->fixture->add($data));
    }

    public function providerAdd()
    {
        return [
            ['id' => 1],
            ['price' => 52],
            ['discount' => 0.5],
        ];
    }

    /**
     * @dataProvider providerUpdate
     * @param $data
     * @throws Exception
     */
    public function testUpdate($data)
    {
        $this->assertTrue($this->fixture->update($data));
    }

    public function providerUpdate()
    {
        return [
            ['id' => 1],
            ['price' => 52],
            ['quantity' => 3],
            ['discount' => 0.5],
        ];
    }

    /**
     * @dataProvider providerRemove
     * @param $data
     * @throws Exception
     */
    public function testRemove($data)
    {
        $this->assertTrue($this->fixture->remove($data));
    }

    public function providerRemove()
    {
        return [
            ['product_id' => 1],
        ];
    }

    /**
     * @throws Exception
     */
    public function testClear()
    {
        $this->assertTrue($this->fixture->clear());
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\CartController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}