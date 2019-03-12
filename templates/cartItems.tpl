<div class="product-box-details">
    <img src="/{{IMAGE}}" class="product-box-img" alt="product_photo">
    <div class="product-details-box_parameter">
        <a class="product-details-link" href="#">{{NAME}}</a>
        <div class="box-details-comment">
            <span class="product-details-comment">☆☆☆☆☆</span>
        </div>
        <div class="product-details-color">
            <span class="product-details-parameter">Color:</span>
            <span class="product-details-value">red</span>
        </div>
        <div class="product-details-size">
            <span class="product-details-parameter">Size:</span>
            <span class="product-details-value">XXL</span>
        </div>
    </div>
    <div class="cart-product-price">
        <span class="cart-product-value_text">$ {{PRICE}}</span>
    </div>
    <label class="cart-product-quantity">
        <input class="cart-quantity-value" type="number" min="1" value="{{QUANTITY}}"
               data-id={{ID}} data-price={{PRICE}}>
    </label>
    <div class="cart-product-shipping">
        <span class="cart-product-value_text">FREE</span>
    </div>
    <div class="cart-product-subtotal">
        <span class="cart-product-subtotal_value">$ {{SUBTOTAL}}</span>
    </div>
    <div class="cart-product-action">
        <a href="#" class="cart-product-remBtn" data-id={{ID}}>&#10005;</a>
    </div>
</div>