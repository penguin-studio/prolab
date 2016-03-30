<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/css/style.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/font/webfontkit-20160129-140755/fonts.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/jquery.bxslider.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/lightbox.css" rel="stylesheet">

	<!-- style end -->
	<!-- script -->
			<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.12.0.min.js"></script>
			<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-migrate-1.2.1.min.js"></script>
	<!-- script end -->

	<?php
	global $post;
	$options = get_option( 'theme_settings' ); ?>
	<!-- Вывод фавикон -->
	<?php if($options['favicon']):?>
		<?php
			$favicon_attributes = wp_get_attachment_image_src( $options['favicon'], 'full' );
			$favicon_src = $favicon_attributes[0];
		?>
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $favicon_src;?>">
	<?php endif;?>
	<!-- Вывод фавикон конец -->
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-74252831-1', 'auto');
      ga('send', 'pageview');

    </script>


	<?php wp_head(); ?>
</head>
<body>
<!-- Хедер начало -->
<header class="header maxw">
    <div class="wrapper_top">
        <div class="contact">
            <p class="tel_text"><?php echo $options['contact_phone_1'];?></p>
            <p class="tel_text"><?php echo $options['contact_phone_2'];?></p>
            <p class="mail_text"><?php echo $options['contact_email'];?></p>
        </div>
        <div class="logo">
            <a href="<?php echo get_home_url(); ?>">
							<?php
								$image_attributes = wp_get_attachment_image_src( $options['logo_uri'], 'full' );
								$logo_url = $image_attributes[0];
								if($logo_url == ''){
									$logo_url = get_template_directory_uri().'/images/logo.png';
								}
							?>
                <img src="<?php echo $logo_url;?>" alt="">
                <p><?php echo $options['header_title'];?></p>
            </a>
        </div>
		<?php if( is_user_logged_in()):
			$user_id = get_current_user_id();
			$user_info = get_userdata($user_id);
			?>
		<div class="enter-private-office">
			<p>Вы вошли как <b><?php echo $user_info->user_login; ?></b><a href="<?php echo wp_logout_url();?>">[Выйти]</a></p>
		</div>
		<div class="cart__off"><a class="product-buy__btn" href="<?php echo get_site_url().'/my-account'?>">Перейти в личный кабинет</a></div>
		<?php endif; ?>
		<?php if( !is_user_logged_in()): ?>
        <div class="car cart_totals">
					<?php
						$cart_product_count = WC()->cart->get_cart_contents_count();
						$cart_product_totalprice = str_replace('&#8372;','грн',(WC()->cart->get_cart_subtotal()));

					?>
            <p><span>В корзине: </span><?php echo $cart_product_count; ?></p>
            <p><span>На сумму: </span><?php echo $cart_product_totalprice; ?></p>
            <a href="<?php echo get_home_url().'/cart'; ?>">Перейти в корзину</a>
        </div>
		<?php endif; ?>
        <div class="clearfix"></div>
    </div>
    <div class="nav">
        <ul>
            	<li><a href="<?php echo get_home_url(); ?>" <?php if (is_front_page()):?> class="active" <?php endif; ?>>Главная</a></li>
            	<?php
							$menu_items = wp_get_nav_menu_items('Меню в подвале');



									?>

									<?php foreach ($menu_items as $item):  ?>
										<li>
											<a <?php if (stristr($item->url, $post->post_name) ):?> class="active" <?php endif; ?>  href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
										</li>
									<?php endforeach;	?>
        </ul>
    </div>
</header>
<!-- Хедер конец -->
<div class="wrapper">
	<main style="height:auto !important; padding-bottom:30px;" class="content <?php if( is_page('cart') || is_page('checkout') || is_page('my-account')): ?> content-basket clearfix <?php endif; ?> <?php if( is_single() ): ?>content-cart<?php endif; ?> <?php if( is_page('sotrudnichestvo') ): ?>content-cooperation<?php endif; ?> maxw">
