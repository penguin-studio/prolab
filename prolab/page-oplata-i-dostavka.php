<?php get_header();?>
<div class="blockInfo">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
<?php
				endwhile;
			endif;
?>
</div>
<?php get_footer(); ?>
