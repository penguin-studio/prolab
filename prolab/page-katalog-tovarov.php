<?php get_header();?>
<div class="specialOffer ">
		<h2 class="specialOffer-title">Специальные Предложения</h2>
		<?php  get_template_part('woo','all_special_product_loop');?>
</div>
<div class="bestOffer catalog clearfix">
		<h2>Каталог Товаров</h2>
		<?php get_template_part('woo','all_product_loop');?>
</div>
<?php get_footer(); ?>
