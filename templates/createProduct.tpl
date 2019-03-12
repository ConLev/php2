<form class="my_form" action="" method="POST">
    <div>
        <div>
            <!-- атрибут value позволяет выставить значение по умолчанию -->
            <label class="product_label">product id:
                <input class="product_id" type="text" name="id" placeholder="id (int(11)" required>
            </label>
        </div>
        <div>
            <label class="product_label">product name:
                <input class="product_name" type="text" name="name" placeholder="name (varchar(255))" required>
            </label>
        </div>
        <div>
            <label class="product_label">product price:
                <input class="product_price" type="text" name="price" placeholder="price (decimal(10,2))" required>
            </label>
        </div>
        <div>
            <label class="product_label">product image:
                <input class="product_img" type="text" name="image" placeholder="src (img/product_1.jpg)" required>
            </label>
        </div>
        <div>
            <input class="update_submit" type="submit">
        </div>
    </div>
    <div>
        <!-- для textarea значение по умолчанию выглядит так -->
        <label class="product_label">product description:
            <textarea class="product_description" name="description" cols="100" rows="30"
                      placeholder="description text" required></textarea>
        </label>
    </div>
</form>

<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так
<form enctype="multipart/form-data" action="__URL__" method="POST">
    Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла (в байтах)
    <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
    Название элемента input определяет имя в массиве $_FILES
    Отправить этот файл: <input name="user_file" type="file"/>
    <input type="submit" value="Send File"/>
</form> -->