<?php

global $wp_query;
$temp = $wp_query;
$wp_query = null;
$args = array( 'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => 'dropshipping'
        )
    )
);
$wp_query = new WP_Query($args);

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        global $product;
        ?>
        <div class="product product-first clearfix">
            <div class="product-desc">
                <?php
                $product_img_src = get_the_post_thumbnail_url($product->id,100,100); //$image_attributes[0];
                ?>
                <img class="product-img my-account" src="<?php echo $product_img_src; ?>" alt="product-1">
                <div class="product-text">
                    <?php
                    $color_class = '';
                    if ($color = get_post_meta($post->ID,'product-title-color', true)):
                        $color_class = $color;
                    endif; ?>
                    <?php if ($product_title = get_the_title()): ?>
                    <a href="<?php echo get_the_permalink(); ?>">
                        <h4 class="product-title " style="color: <?php echo $color_class; ?>;"><?php echo $product_title; ?></h4>
                    </a>
                    <?php endif; ?>
                    <?php if ($product_weight_gr = get_post_meta($post->ID,'product-weight-gr', true)): ?>
                        <p class="weight"><b>Вес: </b><?php echo $product_weight_gr; ?></p>
                    <?php endif?>
                    <?php if ( $price_html = $product->get_price() ) : ?>
                        <span class="product-price product-price__po"><?php echo $price_html; ?><b>грн</span>
                    <?php endif; ?>
                </div>

            </div>
            <div class="product-desc__right">

                <?php if(strcmp($product->product_type,'variable') == 0):?>
                <div class="quantity-items">
                    <div class="quantity-items__desc">
                        <?php

                        foreach($product->get_children() as $_product_id){
                            $mas = wc_get_product_variation_attributes($_product_id);//код получение slug вариативного товара

                            $var_name = get_term_by('slug', $mas['attribute_pa_vkus'],'pa_vkus');//код дляполучения имени вариации из slug
                            $var_name = $var_name->name.'<br>';
                            echo '<p>'.$var_name.'</p>';
                        }
                        ?>
                    </div>

                    <div id="summ-price-box" price="<?php echo $product->get_price(); ?>" uid="<?php echo $product->id;?>">
                    <?php
                    foreach($product->get_children() as $_product_id):
                        $mas = wc_get_product_variation_attributes($_product_id);
                        ?>
                    <input class="quantity" type="text" product-id="<?php echo $_product_id; ?>" slug="<?php echo $mas['attribute_pa_vkus']; ?>" value="0">
                    <?php endforeach; ?>
                    </div>
                </div>
                <?php else:?>
                    <div class="quantity-items">
                        <div class="quantity-items__desc">

                        </div>
                        <div id="summ-price-box" price="<?php echo $product->get_price(); ?>" uid="<?php echo $product->id;?>">
                            <input class="quantity" type="text" product-id="<?php echo $product->id;?>" value="0">
                        </div>
                    </div>
                <?php endif; ?>
                <p class="product-price product-price-scnd"><span id="block-price-<?php echo $product->id;?>">0</span> грн</p>
            </div>
        </div>
    <?php
    endwhile;
endif;

// Возвращаем переменную $wp_query в исходное положение
$wp_query = null;
$wp_query = $temp;
wp_reset_postdata();