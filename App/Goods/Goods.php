<?php

namespace App\Goods;

/**
 * Class Goods
 * @property string class
 * @package App\Goods
 */
abstract class Goods
{
    protected $goods = [];
    protected $finalCost;
    protected $salesRevenue;

    /**
     * Goods constructor.
     * @param $goods
     */
    protected function __construct(array $goods)
    {
        $this->class = get_class($this);
        $this->goods = $goods;
        $this->finalCost = $this->getPrice($goods['price'], $goods['count']);
        $this->salesRevenue = $this->getSalesRevenue($this->getPrice($goods['price'], $goods['count']), $goods['amount']);
    }

    /**
     * Отображает таблицу с результатами
     */
    private function view()
    {
        echo '<table style="border: 1px solid black; border-collapse: collapse">';
        echo '<thead>';
        echo '<tr>';
        echo "<td colspan='6' style='text-align: center; padding: 5px'>$this->class</td>";
        echo '</tr>';
        $this->renderHeaderTable();
        echo '</thead>';
        echo '<tbody>';
        $this->renderBodyTable();
        echo '</tbody>';
        echo '</table></br>';
    }

    /**
     * Возвращает заголовок таблицы
     * метод должен быть переопределен в дочернем классе
     * @return mixed
     */
    abstract protected function renderHeaderTable();

    /**
     * Возвращает тело таблицы
     * метод должен быть переопределен в дочернем классе
     * @return mixed
     */
    abstract protected function renderBodyTable();

    function call()
    {
        $this->view();
    }

    /**
     * Возвращает финальную стоимость товара
     * @param $price - цена за еденицу товара
     * @param $count - кол-во
     * @return int|float - финальная стоимость товара
     * метод должен быть переопределен в дочернем классе
     */
    abstract protected function getPrice(float $price, float $count): float;

    /**
     * Возвращает прибыль с продажи товара
     * @param $price - финальная стоимость еденицы товара
     * @param $amount - кол-во
     * @return float|int - прибыль с продажи товара
     */
    protected static function getSalesRevenue(float $price, float $amount): float
    {
        return $price * $amount;
    }
}