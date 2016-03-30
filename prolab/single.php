<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
?>
<div class="news-detail">
      <span class="news-date-time"><?php echo get_the_date('F d, Y'); ?></span>
      <h1><?php the_title();?></h1>
			<?php
				/* translators: %s: Name of current post */
				the_content();
			?>
  <div style="clear:both"></div>
	<br />
</div>
<?php $src_blog = get_site_url().'/novosti-blog/ '; ?>
<p class="link_prev"><a href="<?php echo $src_blog; ?>">Возврат к списку</a></p>
<?php
	endwhile;
endif;
?>
<?php get_footer(); ?>
