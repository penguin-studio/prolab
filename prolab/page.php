<?php get_header();?>
<div class="content-full">
<?php if ( have_posts() ) : ?>
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
?>
			<?php
				/* translators: %s: Name of current post */
				the_content();
			?>

<?php
	endwhile;
endif;
?>
</div>
<?php get_footer(); ?>
