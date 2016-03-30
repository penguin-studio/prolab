<?php
global $post;
global $wp_query;
$temp = $wp_query;
$wp_query = null;

$args = array( 'post_type' => 'customer_review',
               'posts_per_page' => 4,
               'ignore_sticky_posts'=>true
             );
             $args['meta_query'][] = array(
                          'key'     => 'review_status',
                          'value'   => '1',
                          'type' => 'numeric'
             );

$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) :
 while ($wp_query->have_posts()) : $wp_query->the_post();
   $review_name = get_post_meta($post->ID,'review_name', true);
   $review_img = get_post_meta($post->ID,'review_img', true);
   $review_text = get_post_meta($post->ID,'review_text', true);
   $review_about = get_post_meta($post->ID,'review_about', true);
   $review_url = get_post_meta($post->ID,'review_url', true);

   $image_attributes = wp_get_attachment_image_src( $review_img, 150 , 150 );
   $img_url = $image_attributes[0];
?>
<div class="blockReviews">
    <a href="<?php echo $review_url; ?>" style="background: url('<?php echo $img_url; ?>') no-repeat;" target="_blank" class="imageMan" >
        <span class="blockReviews-bg"><span class="blockReviews-btn">Перейти к отзыву</span></span>
    </a>
    <div class="blockText">
        <div class="text"><img src="<?php echo get_template_directory_uri(); ?>/images/treyg.png" alt=""><p><?php echo $review_text; ?></p></div>
        <div class="faqMan">
            <h4><span><?php echo $review_name; ?></span></h4>
            <p><?php echo $review_about; ?></p>
        </div>
    </div>
</div>
<?php
 endwhile;
endif;

$wp_query = null;
$wp_query = $temp;
wp_reset_postdata();
?>
