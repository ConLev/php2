<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Goods;

/**
 * Class WeightGoods
 * @package App\Goods
 */
class WeightGoods extends PieceGoods
{
    /**
     * WeightGoods constructor.
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
        return parent:: getPrice($price, $count);
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
        parent::renderBodyTable();
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
        echo "<td style='border: 1px solid black; padding: 5px'>Весовой товар</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Цена</td>";
        echo "<td style='border: 1px solid black; padding: 5px'>Количество, кг</td>";
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
        parent::renderBodyTable();
    }
}