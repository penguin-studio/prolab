<section class="basket-col__left">
    <div class="pl-scroll-fix" style="width:343px;">
    <div class="order">
        <div class="order-btn__group">
            <button id="order-catalog"  class="order-btn active" type="button">Из каталога</button>
            <button id="order-document"  class="order-btn" type="button">Документом</button>
        </div>
        <div id="catalog-form" >
        <h2 class="payment clearfix">к оплате <span id="cart-full-summ">0</span>грн</h2>
        <?php
            $user_id = get_current_user_id();

        ?>

        <form class="form-payment" method="post"  action="<?php echo get_site_url().'/order-complete' ?> ">
            <label class="icon name"><input type="text" name="uname" required value="<?php echo get_user_meta( $user_id, 'billing_first_name', true );?>" placeholder="ФИО получателя"></label>
            <label class="icon city"><input type="text" name="ucity" required value="<?php echo get_user_meta( $user_id, 'billing_address_1', true );?>" placeholder="В какой город доставить?"></label>
            <label class="icon post"><input type="text" name="upost" required value="<?php echo get_user_meta( $user_id, 'billing_city', true );?>" placeholder="Отделение Новой Почты"></label>
            <label class="icon phone"><input type="text" name="uphone" required value="<?php echo get_user_meta( $user_id, 'billing_phone', true );?>" placeholder="Номер телефона получателя"></label>
            <label class="icon message"><textarea name="order_comments" class="input-text " placeholder="Комментарий к заказу" rows="2" cols="5"></textarea></label>
            <p id="empty-cart" style="color: black;">Товары не выбраны</p>
            <input id="products-id-field" type="hidden" name="products-id" value="">
            <input class="submit-btn product-buy__btn" style="display: none;" type="submit" required name="opt-catalog-order" value="Оформить заказ">
            <p>*Минимальная сумма заказа 3000грн.</p>
        </form>
        </div>
        <div id="document-form" style="display: none;">
            <form class="form-payment" method="post" enctype="multipart/form-data" action="<?php echo get_site_url().'/order-complete' ?> ">
                <div class="chekout-form-text">
                    <p>
                        <?php
                        $options = get_option( 'theme_settings' );
                        echo $options['lk-opt-doc'];
                        ?>
                    </p>
                </div>
                <div class="mask-wrapper">
                    <div class="mask">

                        <input class="fileInputText" type="text" value="Выберите файл"  disabled>
                        <button class="send-file">Выбрать</button>
                    </div>
                    <input id="my_file" class="custom-file-input" type="file" name="my_file">
                </div>
                <input class="submit-btn product-buy__btn" type="submit" required name="opt-order" value="Оформить заказ">
                <p>*Минимальная сумма заказа 3000грн.</p>
            </form>
        </div>
    </div>
        </div>
</section>
<section class="basket-col__right private-office-products">
    <span class="delivery-label download-lable"><a href="<?php echo get_price_url('opt'); ?>" download>Скачать актуальный прайс-лист</a></span>
    <?php
    $user_sale = 0;
    $user_order_total = 0;
    $user_to_next_sale = 0;
    if(get_user_meta( $user_id, 'user_sale', true )) {
        $user_sale = get_user_meta($user_id, 'user_sale', true);
    }
    if(get_user_meta( $user_id, 'user_order_total', true )) {
        $user_order_total = get_user_meta($user_id, 'user_order_total', true);
    }
    if(get_user_meta( $user_id, 'user_to_next_sale', true )) {
        $user_to_next_sale = get_user_meta($user_id, 'user_to_next_sale', true);
    }
    ?>
    <span class="delivery-label private-office-label"><span>Заказов на сумму <b><?php echo $user_order_total; ?> грн</b></span><span id="user_sale" user-sale="<?php echo $user_sale; ?>" >Постоянная скидка <i><?php echo $user_sale; ?>%</i></span><span>До следующей скидки <b><?php echo $user_to_next_sale; ?> грн</b></span></span>
    <div class="slider slider-po">
        <script>
            $(document).ready(function() {
                $('.bxslider').bxSlider({
                    mode: 'fade'
                });
            });
        </script>
        <?php echo slider_view('slajder-dlya-opta'); ?>
    </div>
    <?php get_template_part('woo','opt_product_loop');?>
</section><div style="clear: both;"></div><p class="total-price">Сумма к оплате <span id="full-summ">0</span> грн</p>