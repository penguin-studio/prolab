<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//wc_print_notices();

//do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<h1 class="main-title">Корзина</h1>
<section class="basket-col__left">
<div class="order">
<h2 class="payment clearfix">к оплате <span><?php echo str_replace('&#8372;','',(WC()->cart->get_cart_subtotal()));?></span>грн</h2>
<form name="checkout" method="post" class="form-payment" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php  do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>
	<a class="continue" href="<?php echo get_home_url().'/katalog-tovarov'; ?>">Продолжить покупки</a>
</div>
</section>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

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
						if($tax = get_the_terms( $product_id, 'product_cat' )) {
							foreach ($tax as $item) {
								if(strcmp('specialnoe-predlozhenie',$item->slug) == 0){
									$product_img_src = wp_get_attachment_image_url(get_post_meta($product_id,'product-img',true));
									break;
								}
							}
						}

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
								<p class="weight"><b>Вес: </b><?php echo $product_weight_gr; ?></p>
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