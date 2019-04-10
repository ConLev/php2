<?php

declare(strict_types=1);

require_once 'BaseTest.php';

class OrdersControllerTest extends BaseTest
{
    protected $fixture;

    /**
     * @throws Exception
     */
    public function testCreateOrder()
    {
        $this->assertTrue($this->fixture->createOrder());
    }

    /**
     * @dataProvider providerUpdateStatus
     * @param $data
     * @throws Exception
     */
    public function testUpdateStatus($data)
    {
        $this->assertTrue($this->fixture->updateStatus($data));
    }

    public function providerUpdateStatus()
    {
        return [
            ['id' => 1],
            ['order_id' => 1],
            ['product_id' => 4],
            ['amount' => 3],
            ['status' => 1],
        ];
    }

    /**
     * @dataProvider providerDeleteProductOfOrder
     * @param $data
     * @throws Exception
     */
    public function testDeleteProductOfOrder($data)
    {
        $this->assertTrue($this->fixture->deleteProductOfOrder($data));
    }

    public function providerDeleteProductOfOrder()
    {
        return [
            ['order_id' => 1],
            ['product_id' => 4],
        ];
    }

    /**
     * @dataProvider providerRemoveOrder
     * @param $data
     * @throws Exception
     */
    public function testRemoveOrder($data)
    {
        $this->assertTrue($this->fixture->removeOrder($data));
    }

    public function providerRemoveOrder()
    {
        return [
            ['order_id' => 1],
        ];
    }

    protected function setUp(): void
    {
        $this->fixture = new App\Controllers\OrdersController();
    }

    protected function tearDown(): void
    {
        $this->fixture = NULL;
    }
}