<?php get_header();?>
<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$order = '';

$user_id = get_current_user_id();
$res_1 = avtomatic_drop_order();
$res_2 = avtomatic_opt_order();

if($res_1){
    $order = $res_1;
}
if($res_2){
    $order = $res_2;
}

if ( $order ) : ?>

    <?php if ( $order->has_status( 'failed' ) ) : ?>

        <p class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

        <p class="woocommerce-thankyou-order-failed-actions">
            <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
            <?php endif; ?>
        </p>

    <?php else : ?>

        <p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>

        <ul class="woocommerce-thankyou-order-details order_details">
            <li class="order">
                <?php _e( 'Order Number:', 'woocommerce' ); ?>
                <strong><?php echo $order->get_order_number(); ?></strong>
            </li>
            <li class="date">
                <?php _e( 'Date:', 'woocommerce' ); ?>
                <strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
            </li>
            <?php if($order->get_total() != 0):?>
            <li class="total">
                <?php _e( 'Total:', 'woocommerce' ); ?>
                <strong><?php echo $order->get_total(); ?> грн</strong>
            </li>
            <?php endif; ?>
        </ul>
        <div class="clear"></div>

    <?php endif; ?>


<?php else : ?>

    <p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
<?php get_footer(); ?>