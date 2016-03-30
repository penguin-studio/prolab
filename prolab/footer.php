      <div style="clear:both;"></div>
    </main><!-- .content -->
  </div><!-- .wrapper -->

<?php $options = get_option( 'theme_settings' ); ?>
<!-- footer начало -->

<footer class="footer maxw">
    <div class="nav">
        <ul>
          <li><a href="<?php echo get_home_url(); ?>"<?php if (is_front_page()):?> class="active" <?php endif; ?>>Главная</a></li>
          <?php
              $menu_items = wp_get_nav_menu_items('Меню в подвале');
              global $post;
              foreach ($menu_items as $item): ?>
                <li>
                  <a <?php if (stristr($item->url, $post->post_name)):?> class="active" <?php endif; ?>  href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                </li>
              <?php endforeach;	?>
        </ul>
    </div>
    <p><?php echo $options['footer_copyright'];?></p>
    <p><?php echo $options['footer_text'];?></p>
</footer>
      <?php
      view_login_registration_form();
      ?>
      <div class="popup-box popup-box-registration">
          <div class="bottom tab_content">
              <h1>Спасибо за регистрацию</h1>
          </div>
      </div>
<!-- popup -->
<div class="popup-box" id="popup-box" style="display:block;">
	<div class="close"></div>
	<div class="top">
		<h6>Товар успешно добавлен в корзину</h6>
	</div>
	<div class="bottom">
		<a class="popup-btn" href="<?php echo get_home_url().'/cart'; ?>">Перейти в корзину</a>
		<a class="popup-btn popup-btn__continue" href="<?php echo get_home_url().'/katalog-tovarov'; ?>">Продолжить покупки</a>
	</div>
</div>
<!-- footer конец -->
<?php
$template_url = get_template_directory_uri().'/components/';
$pengstud_url = 'http://dp.pengstud.com/';
do_action('penguin-footer',$template_url,$pengstud_url);
?>

  <script src="<?php echo get_template_directory_uri(); ?>/js/lightbox-plus-jquery.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.bxslider.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>
  <?php  wp_footer();?>
	</body>
</html>
