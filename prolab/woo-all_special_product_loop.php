<style>
  .added_to_cart.wc-forward{
    display: none;
  }
</style>
<?php


$args = array(
               'post_type' => 'product',
               'posts_per_page' => 4,
               'tax_query' => array(
                 array(
                  'taxonomy' => 'product_cat',
                  'field' => 'slug',
                  'terms' => 'specialnoe-predlozhenie'
                )
               )
             );
global $wp_query;
$temp = $wp_query;
$wp_query = null;

$wp_query = new WP_Query($args);


if ( have_posts() ) :
 while ( have_posts() ) : the_post();
 global $product, $woocommerce_loop;

 ?>
 <?php
  $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'full' );
  $product_img_src = $image_attributes[0];

 ?>
 <div class="blockSpecial" style="background: url(<?php echo $product_img_src; ?>) no-repeat;">

     <a href="<?php echo get_the_permalink(); ?>">
     <?php
     $color_class = '';
     if ($color = get_post_meta($post->ID,'product-title-color', true)):
         $color_class = $color;
     endif; ?>
     <h3 style="background-color: <?php echo $color_class; ?>;"><?php echo get_the_title()?></h3>
     </a>
     <?php $price_html = $product->get_price(); ?>
     <p><span class="old-price"><img src="<?php echo get_template_directory_uri(); ?>/images/del-price.png" alt=""><?php echo $product->regular_price; ?></span><?php echo $product->sale_price; ?><span class="valut">грн</span></p>

     <?php
     echo apply_filters( 'woocommerce_loop_add_to_cart_link',
      sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
        esc_url( $product->add_to_cart_url() ),
        1,
        esc_attr( $product->id ),
        esc_attr( $product->get_sku() ),
        'buttonBuy product-buy__btn ajax_add_to_cart add_to_cart_button',
        'Купить'
      ),
     $product );
     ?>
 </div>

<?php
 endwhile;
endif;
?>
<?php
		// Возвращаем переменную $wp_query в исходное положение
		$wp_query = null;
		$wp_query = $temp;
		wp_reset_postdata();
?>
