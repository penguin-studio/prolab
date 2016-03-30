<?php get_header();?>

<?php if ( have_posts() ) : ?>
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
  global $product, $woocommerce_loop;
?>

<div class="center-box">
  <a class="back" href="<?php echo get_home_url().'/katalog-tovarov'; ?>">Вернуться в каталог</a>
</div>
<aside class="card-col__left pl-scroll-fix">
  <div class="product-img__container">
    <?php
     //$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 300, 300 );
     //$product_img_src = $image_attributes[0];

     //   if($tax = get_the_terms( $post->ID, 'product_cat' )) {
     //     foreach ($tax as $item) {
     //       if(strcmp('specialnoe-predlozhenie',$item->slug) == 0){
              $product_img_src = wp_get_attachment_image_url(get_post_meta($post->ID,'product-img',true), 'full');
     //         break;
      //      }
      //    }
      //  }
            if($product_img_src == ''){
              $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 300, 300 );
              $product_img_src = $image_attributes[0];
            }
    ?>
      <div class="product-img__container_incide">
        <img src="<?php echo $product_img_src; ?>" height="" width="" />
      </div>
  </div>
  <?php
  woocommerce_template_single_add_to_cart();
  ?>
  <a class="continue" href="<?php echo get_home_url().'/katalog-tovarov'; ?>">Продолжить покупки</a>
</aside>
<aside class="card-col__right">
  <div class="main-desc">
    <ul class="main-desc__list">
      <li class="main-desc__item1">Официальный дистрибьютор</li>
      <li class="main-desc__item2">Доставка по всей Украине</li>
      <li class="main-desc__item3">Высокое качество</li>
      <li class="main-desc__item4">Вся продукция
        сертифицирована
      </li>
    </ul>
  </div>
  <h3 class="comment-title">Комментарии к товару</h3>
    <?php   get_template_part('woo','comments');?>
</aside>
<section class="card-content">
  <?php
  $color_class = '';
  if ($color = get_post_meta($post->ID,'product-title-color', true)):
    $color_class = $color;
  endif; ?>
  <h1 class="product-title" style="color: <?php echo $color_class; ?>;"><?php echo get_the_title(); ?></h1>

  <div class="row clearfix">
    <div class="row-col__left">
      <?php if ($product_weight_gr = get_post_meta($post->ID,'product-weight-gr', true)): ?>
        <span class="weight">
        <?php
          $number = ''.(floatval($product_weight_gr));
          echo $number."<span>".str_replace($number,'',$product_weight_gr)."</span>";
        ?>
        </span>
      <?php endif; ?>

        <?php
          if($product->is_in_stock()){?>
          <span class="availability">есть в наличии</span>
          <?php
          }else{
            ?>
          <span class="availability" style="background-color: #CCCCCC;">нет в наличии</span>
          <?php
          }
        ?>

    </div>
    <div class="row-col__right">
      <?php if ($product_button_type = get_post_meta($post->ID,'product-button-type', true)): ?>
        <?php if ($product_button_type == 1): ?><button type="button" class="btn-health">Для здоровья</button><?php endif; ?>
        <?php if ($product_button_type == 2): ?><button type="button" class="btn-weight">Для набора массы</button><?php endif; ?>
        <?php if ($product_button_type == 3): ?><button type="button" class="btn-training">Для продуктивных тренировок</button><?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="row clearfix">

  </div>
  <?php the_content(); ?>

</section>
      <?php
/*
      if ( empty( $product ) || ! $product->exists() ) {
        return;
      }

      $related = $product->get_cross_sells();//get_related( 3 );
      $cross = array();
      foreach($related as $id){
        array_push($cross,$id);
      }

      if ( sizeof( $related ) === 0 ) return;

      $args =  array(
          'post_type'            => 'product',
          'ignore_sticky_posts'  => 1,
          'no_found_rows'        => 1,
          'posts_per_page'       => 3,
          'orderby'              => 'ASC',
          'post__in'             => $cross,
          'post__not_in'         => array( $product->id )
      );

      $products = new WP_Query( $args );


      if ( $products->have_posts() ) : ?>


          <?php while ( $products->have_posts() ) : $products->the_post();


            echo the_title();

          endwhile;
        endif;


          wp_reset_postdata();*/
      ?>
<?php
	endwhile;
endif;
?>

<?php get_footer(); ?>
