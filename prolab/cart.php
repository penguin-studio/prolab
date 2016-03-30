<h1 class="main-title">Корзина</h1>

<?php echo do_shortcode('[woocommerce_checkout]'); ?>
<section class="basket-col__right">
		<span class="delivery-label">Бесплатная доставка от 1000грн</span>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
<?php

foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {


	$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		?>

		<div class="product clearfix" id="">
				<div class="product-desc">
					<?php

					 $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 180, 180 );
						if($_product->product_type == 'variation'){
							$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->variation_id ), 180, 180 );
						}
					  $product_img_src = $image_attributes[0];
					?>
					<img class="product-img" src="<?php echo $product_img_src; ?>" height="113" width="107" alt="">
						<div class="product-text">
							<?php
							$color_class = '';

							if ($color = get_post_meta($product_id,'product-title-color', true)):
								$color_class = $color;
							endif; ?>
							<a href="<?php echo get_the_permalink($product_id); ?>" style="text-decoration: none;">
								<h1 style="color: <?php echo $color_class; ?>;" class="product-title" data-title="<?php _e( 'Product', 'woocommerce' ); ?>" ><?php echo $_product->get_title(); ?></h1>
							</a>
								<?php if ($product_weight_gr = get_post_meta($product_id,'product-weight-gr', true)): ?>
										<p class="weight"><b>Вес: </b><?php echo (int)($product_weight_gr); ?> грамм</p>
								<?php endif?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>

									<?php if ( $price_html = $_product->get_price() ) : ?>
									<p class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>" ><?php echo $price_html; ?><span>грн</span></p>
		            <?php endif; ?>

						</div>
				</div>
				<div class="product-desc__right">
						<!--dropdown-->
						<div class="wrapper-dropdown product-quantity" tabindex="1" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</div>
						<p class="product-price product-price-scnd " data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
							<?php echo str_replace('&#8372;','',apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key )); ?>грн</p>
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="product-del" title="%s" data-product_id="%s" data-product_sku="%s">удалить</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
				</div>
		</div>
		<div style="clear: both;"></div>

<?php } } ?>
	<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	<input type="submit" class="button cart" style="opacity: 0;" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />
		<p class="total-price">Сумма к оплате <span><?php echo str_replace('&#8372;','',(WC()->cart->get_cart_subtotal())); ?> </span>грн</p>
</section>




</form>
<div style="clear:both;"></div>
