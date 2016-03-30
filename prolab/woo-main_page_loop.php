<style>
  .added_to_cart.wc-forward{
    display: none;
  }
</style>
<?php


$args = array( 'post_type' => 'product',
               'posts_per_page' => 4,
                'order'   => 'ASC',
               'tax_query' => array(
                 'relation' => 'AND',
                 array(
                  'taxonomy' => 'product_cat',
                  'field' => 'slug',
                  'terms' => 'glavnaya-stranica')
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


     <div class="product-bot__item">
        <?php if(get_post_meta($post->ID,'best-offer', true) == '1'):?>
         <div class="bestOffer"><span class="text">Лидер продаж</span></div>
        <?php endif; ?>
         <a class="product-link" href="<?php echo get_the_permalink(); ?>" target="_blank">
         <?php
         $color_class = '';
         if ($color = get_post_meta($post->ID,'product-title-color', true)):
             $color_class = $color;
         endif; ?>
         <?php if ($product_title = get_the_title()): ?>
         <h4 class="product-bot__item-title " style="color: <?php echo $color_class; ?>;"><?php echo $product_title; ?></h4>
         <?php endif; ?>
         <div class="product-bot__img">
             <?php
              //$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 180, 180 );
              $product_img_src = get_the_post_thumbnail_url($product->ID,180,180); //$image_attributes[0];
             ?>
             <img class="img-vita" src="<?php echo $product_img_src; ?>">
         </div>
         </a>
         <div class="product-bot__lable">
           <?php if ($product_weight = get_post_meta($post->ID,'product-weight', true)): ?>
           <?php  $number = ''.(floatval($product_weight));
           ?>
           <span class="product-bot__desc product-bot__desc1"><?php echo $number."<span>".str_replace($number,'',$product_weight)."</span>"; ?></span>
           <?php endif?>
           <?php if ( $price_html = $product->get_price() ) : ?>
           <span class="product-bot__desc product-bot__desc2"><?php echo $price_html; ?><b>грн</b></span>
           <?php endif; ?>
         </div>
         <div class="product-buy">
             <?php
             echo apply_filters( 'woocommerce_loop_add_to_cart_link',
             	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s" onclick="_gaq.push(["_trackEvent", " Preview order3", "order3"]);">%s</a>',
             		esc_url( $product->add_to_cart_url() ),
             		1,
             		esc_attr( $product->id ),
             		esc_attr( $product->get_sku() ),
             		'product-buy__btn ajax_add_to_cart add_to_cart_button',
             		'Купить'
             	),
             $product );
             ?>
         </div>
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
