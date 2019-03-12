<h3>Заказ #{{ID}}</h3>
<table class="order_table">
    <thead>
    <tr>
        <td class="order_thead">Название</td>
        <td class="order_thead">Стоимость</td>
        <td class="order_thead">Количество</td>
        <td class="order_thead">Сумма</td>
    </tr>
    </thead>
    <tbody>
    {{CONTENT}}
    <tr>
        <td class="order_thead" colspan="3">Итого</td>
        <td class="order_thead">$ {{SUM}}</td>
    </tr>
    <tr>
        <td class="order_thead">Статус заказа:</td>
        <td class="order_thead" data-id="{{ID}}" colspan="3"> {{UPDATE_STATUS}}</td>
    </tr>
    </tbody>
</table>