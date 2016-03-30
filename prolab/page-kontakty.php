<?php get_header();?>
<?php $options = get_option( 'theme_settings' ); ?>
<div class="blockContact">
		<h2>Контакты</h2>
		<div class="contact">
				<p class="tel_text"><?php echo $options['contact_phone_1'];?></p>
				<p class="tel_text"><?php echo $options['contact_phone_2'];?></p>
				<p class="mail_text"><?php echo $options['contact_email'];?></p>
				<p class="vk"><?php echo $options['contact_vk'];?></p>
		</div>
		<div class="timeBlock"><?php echo $options['contact_work_time_block'];?></div>
		<div class="clearfix"></div>
</div>
<div class="map">
		<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=lM1kqOrqmMYcZGSwHQSXEWjd13LKz2D6&width=901&height=249&lang=ru_UA&sourceType=constructor"></script>
</div>
<?php get_footer(); ?>
