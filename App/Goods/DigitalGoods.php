<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Goods;

/**
 * Class DigitalGoods
 * @package App\Goods
 */
class DigitalGoods extends Goods
{
    /**
     * DigitalGoods constructor.
     * @param $goods
     */
    function __construct($goods)
    {
        parent::__construct($goods);
    }

    /**
     * Возвращает финальную стоимость товара
     * @param $price - цена за еденицу товара
     * @param $count - кол-во
     * @return int|float - финальная стоимость товара
     */
    protected function getPrice(float $price, float $count): float
    {
        return $price;
    }

    /**
     * Возвращает прибыль с продажи товара
     * @param $price - финальная стоимость еденицы товара
     * @param $amount - кол-во
     * @return float|int - прибыль с продажи товара
     */
    protected static function getSalesRevenue(float $price, float $amount): float
    {
        return parent::getSalesRevenue($price, $amount);
    }

    /**
     * Отображает таблицу с результатами
     */
    public function view()
    {
        self::renderHeaderTable();
        self::renderBodyTable();
        parent::call();
    }

    /**
     * Возвращает заголовок таблицы
     * @return mixed
     */
    function renderHeaderTable()
    {
        echo '<tr>';
        echo "<td style='border: 1px solid black; padding: 5px'>id</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Цифровой товар</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Цена</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Продано</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Доход с продаж</td>";
        echo '</tr>';
    }

    /**
     * Возвращает тело таблицы
     * @return mixed
     */
    function renderBodyTable()
    {
        echo "<tr data-id='{$this->goods['id']}'>";
        echo "<td style='border: 1px solid black; padding: 5px'>{$this->goods['id']}</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>{$this->goods['name']}</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>₽ $this->finalCost</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>{$this->goods['amount']}</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>₽ $this->salesRevenue</td>";
        echo '</tr>';
    }
}