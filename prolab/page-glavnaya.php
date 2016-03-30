<?php get_header('shop'); ?>
<script>
		$(document).ready(function() {
				$('.bxslider').bxSlider({
						mode: 'fade',
						autoStart: true,
						auto: true,
						speed: 4000
				});
		});
</script>
<div class="slider">
	<?php echo slider_view('slajder-glavnoj-stranicy'); ?>
</div>
<!-- Вывод товаров -->
<div class="bestOffer catalog clearfix">
    <h2>Лучшие предложения</h2>
	<?php get_template_part('woo','main_page_loop');?>
</div>
<!-- Конец вывода товаров -->
<a href="<?php echo get_home_url().'/katalog-tovarov'; ?>" class="buttonGrey">Перейти в каталог</a>
<div class="mainInfo">
		<div class="reviews">
			<h2>Отзывы спортсменов:</h2>
			<?php get_template_part('review','loop');?>
		</div>
		<div class="secondBlock">
			<?php $options = get_option( 'theme_settings' ); ?>
			<div class="proLabText">
					<h2 class="proLabText-title">Что такое Prolab?</h2>
					<p><?php echo $options['prolab_is']; ?></p>
			</div>
			<div class="questionForm">
					<h2>У вас возникли вопросы?</h2>
					<p>Оставьте свой номер и мы перезвоним вам.</p>
					<div class="form">
						<?php
						$options = get_option( 'theme_settings' );
						$mail_to = $options['contacts_email'];
						?>
							<form id="main-send-form" method="post">
									<div>
											<label for="POST-name">Ваше имя:</label>
											<input id="POST-name" type="text" name="name">
									</div>
									<div>
											<label for="POST-tel">Номер телефона:</label>
											<input id="POST-tel" type="text" name="phone">
									</div>
									<div>
											<label for="POST-com" class="comentL">Комментарий:</label>
									<textarea name="text" id="POST-com" cols="27" rows="4"></textarea>
										<input type="hidden" name="mail_to" value="<?php echo $mail_to; ?>">
									</div>
									<input type="submit" class="button" value="Отправить">
							</form>
					</div>
			</div>
		</div>

</div>
<div class="thirdInfo">
		<div class="sertificate">
				<h2>Сертификаты качества</h2>
				<?php for ($i=1; $i <= 2; $i++):
					$image_attributes = wp_get_attachment_image_src( $options['sertifikat_'.$i], 'sertificate' );
					$img_url = $image_attributes[0];
					$image_attributes = wp_get_attachment_image_src( $options['sertifikat_'.$i], 'full' );
					$img_url_full = $image_attributes[0];
				?>
				<a class="quickbox" href="<?php echo $img_url_full; ?>" data-lightbox="image-1">
						<img src="<?php echo $img_url; ?>" alt="" <?php if ($i == 1):?> class="firstSert"<?php endif; ?>>
				</a>
				<?php endfor; ?>
		</div>
		<div class="photoClien">
				<h2>Фото наших клиентов</h2>
				<?php for ($i=1; $i <= 4; $i++):
					$image_attributes = wp_get_attachment_image_src( $options['client_foto_'.$i], 'client_foto' );
					$img_url = $image_attributes[0];
				?>
				<div class="fotoBlock <?php if($i % 2 != 0): ?>first <?php endif; ?>"><img src="<?php echo $img_url; ?>" alt=""></div>
				<?php endfor; ?>
		</div>
</div>
<?php get_footer('shop'); ?>
