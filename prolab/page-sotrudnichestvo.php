<?php get_header();?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
<?php
				endwhile;
			endif; ?>
<section class="registration">
	<a class="registration-btn" href="#">Зарегистрироваться</a>
	<a class="enter js-enter" href="#">Войти в Личный кабинет</a>
	<div class="img-container">
		<img src="<?php echo get_template_directory_uri(); ?>/images/boxes.png" height="221" width="260" alt="boxes">
	</div>
	<a class="download-price" href="<?php echo get_price_url(); ?>" download>Скачать оптовый прайс</a>
</section>
<?php
//avtomatic_order();
?>
<?php get_footer(); ?>
