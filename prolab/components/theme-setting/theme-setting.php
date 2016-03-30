<?php


//Настройки панели администрирования
//Регистрация функции настроек
function theme_settings_init(){
  register_setting( 'theme_settings', 'theme_settings' );
}
// Добавление настроек в меню страницы
function add_settings_page() {
add_menu_page( __( 'Опции темы' ), __( 'Опции темы' ), 'manage_options', 'settings', 'theme_settings_page');
}
//Добавление действий
add_action( 'admin_init', 'theme_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );
//Сохранение настроек
function theme_settings_page() {
global $select_options; if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
?>
<div class="dachi-opt">
<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
<div id="message" class="updated">
  <p><strong>Настройки сохранены</strong></p>
</div>
<?php endif; ?>
<div>

<form method="post" action="options.php">
<?php settings_fields( 'theme_settings' ); ?>
<?php $options = get_option( 'theme_settings' ); ?>

<div id="container">
    <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Шапка|Подвал">Шапка|Подвал</label>

        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Компания">***</label>

        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="Рассылка">Файлы/Рассылка</label>

        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="Контент">Контент</label>

        <section id="content1">
           <table class="theme-option-table">
             <tr valign="top"><td colspan='2'><h1>Настройка шапки сайта</h1></td></tr>
           </table>
           <table class="theme-option-table table-block" >
             <tr valign="top">
               <td><h3>Логотип:</h3></td>
               <td>
                 <?php logo_upload_function('theme_settings[logo_uri]', $options['logo_uri']);?>
               </td>
             </tr>
             <tr valign="top">
               <td><h3>Фавикон:</h3></td>
               <td>
                 <?php logo_upload_function('theme_settings[favicon]', $options['favicon'], 16, 16);?>
               </td>
             </tr>
             <tr valign="top">
             <td><h3>Заголовок:</h3></td>
             <td><textarea  name="theme_settings[header_title]" rows="5" cols="40"><?php esc_attr_e( $options['header_title'] ); ?></textarea></td>
             <td> - Укажите заголовок шапки сайта.</td>
             </tr>
           </table>
           <table class="theme-option-table">
             <tr valign="top"><td colspan='2'><h1>Настройка подвала сайта</h1></td></tr>
           </table>
           <table class="theme-option-table table-block" >

             <tr valign="top">
             <td colspan="3"><h2>Текст подвала:</h2></td>
             </tr>
             <tr valign="top">
               <td colspan="3" style="min-width:800px;">
               <?php
              wp_editor($options['footer_text'], 'footer_text', array(
                 'wpautop' => 1,
                 'media_buttons' => 1,
                 'textarea_name' => 'theme_settings[footer_text]', //нужно указывать!
                 'textarea_rows' => 10,
                 'tabindex'      => null,
                 'editor_css'    => '',
                 'editor_class'  => '',
                 'teeny'         => 0,
                 'dfw'           => 0,
                 'tinymce'       => 1,
                 'quicktags'     => 1,
                 'drag_drop_upload' => false
               ) );
               ?>
             </td>
             </tr>
             <tr valign="top">
             <td colspan="3"><h2>Копирайт:</h2></td>
             </tr>
             <tr valign="top">
               <td colspan="3" style="min-width:800px;">
               <?php
              wp_editor($options['footer_copyright'], 'footer_copyright', array(
                 'wpautop' => 1,
                 'media_buttons' => 1,
                 'textarea_name' => 'theme_settings[footer_copyright]', //нужно указывать!
                 'textarea_rows' => 5,
                 'tabindex'      => null,
                 'editor_css'    => '',
                 'editor_class'  => '',
                 'teeny'         => 0,
                 'dfw'           => 0,
                 'tinymce'       => 1,
                 'quicktags'     => 1,
                 'drag_drop_upload' => false
               ) );
               ?>
             </td>
             </tr>
           </table>
       </section>
       <section id="content2">

        </section>
        <section id="content3">
            <table class="theme-option-table">
                <tr valign="top"><td colspan='3'><h1>Настройка рассылки</h1></td></tr>
            </table>
            <table class="theme-option-table table-block" >
                <tr valign="top">
                    <td><h3>Введите E-mail адрес:</h3></td>
                    <td><input id="theme_settings[contacts_email]" type="text" size="40" name="theme_settings[contacts_email]" value="<?php esc_attr_e( $options['contacts_email'] ); ?>" /></td>
                    <td> - Введите E-mail адресс для рассылки.</td>
                </tr>
            </table>
            <table class="theme-option-table">
            <tr valign="top"><td colspan='3'><h1>Файлы </h1></td></tr>
          </table>
         <table class="theme-option-table table-block" >

            <tr valign="top"><td colspan='3'><h2>Прайс для обычных пользователей</h2></td></tr>
            <tr valign="top">
                <td colspan="3">
                <?php
                    $default_price = array(
                        'full_name'  => 'theme_settings[default_full_price]',
                        'short_name' => 'theme_settings[default_short_price]',
                        'full_name_value'  => isset($options['default_full_price'])?$options['default_full_price']:'',
                        'short_name_value' => isset($options['default_short_price'])?$options['default_short_price']:'',
                        'style_input' => 'width:300px;'
                    );
                    echo file_upload($default_price);
                ?>
                </td>
            </tr>
            <tr valign="top"><td colspan='3'><h2>Прайс для дропшипинга</h2></td></tr>
            <tr valign="top">
                <td colspan="3">
                    <?php
                    $drop_price = array(
                        'full_name'  => 'theme_settings[drop_full_price]',
                        'short_name' => 'theme_settings[drop_short_price]',
                        'full_name_value'  => isset($options['drop_full_price'])?$options['drop_full_price']:'',
                        'short_name_value' => isset($options['drop_short_price'])?$options['drop_short_price']:'',
                        'style_input' => 'width:300px;'
                    );
                    echo file_upload($drop_price);
                    ?>
                </td>
            </tr>
            <tr valign="top"><td colspan='3'><h2>Прайс для оптовиков</h2></td></tr>
            <tr valign="top">
                <td colspan="3">
                    <?php
                    $opt_price = array(
                        'full_name'  => 'theme_settings[opt_full_price]',
                        'short_name' => 'theme_settings[opt_short_price]',
                        'full_name_value'  => isset($options['opt_full_price'])?$options['opt_full_price']:'',
                        'short_name_value' => isset($options['opt_short_price'])?$options['opt_short_price']:'',
                        'style_input' => 'width:300px;'
                    );
                    echo file_upload($opt_price);
                    ?>
                </td>
            </tr>
            </table>
        </section>
        <section id="content4">
          <table class="theme-option-table">
            <tr valign="top"><td colspan='3'><h1>Главная</h1></td></tr>
          </table>
          <table class="theme-option-table table-block" >
            <tr valign="top">
            <td colspan="3"><h2>Текст блока что такое ProLab</h2></td>
            </tr>
            <tr valign="top">
              <td colspan="3" style="min-width:800px;">
              <?php
             wp_editor($options['prolab_is'], 'prolab_is', array(
                'wpautop' => 1,
                'media_buttons' => 1,
                'textarea_name' => 'theme_settings[prolab_is]', //нужно указывать!
                'textarea_rows' => 10,
                'tabindex'      => null,
                'editor_css'    => '',
                'editor_class'  => '',
                'teeny'         => 0,
                'dfw'           => 0,
                'tinymce'       => 1,
                'quicktags'     => 1,
                'drag_drop_upload' => false
              ) );
              ?>
            </td>
            </tr>
            <tr valign="top">
              <td><h3>Сертификаты качества</h3></td>
            </tr>
            <tr valign="top">
              <td><h3>Сертификат качества 1:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[sertifikat_1]', $options['sertifikat_1']);?>
              </td>
            </tr>
            <tr valign="top">
              <td><h3>Сертификат качества 2:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[sertifikat_2]', $options['sertifikat_2']);?>
              </td>
            </tr>
            <tr valign="top">
              <td><h3>Фото наших клиентов</h3></td>
            </tr>
            <tr valign="top">
              <td><h3>Фото 1:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[client_foto_1]', $options['client_foto_1']);?>
              </td>
            </tr>
            <tr valign="top">
              <td><h3>Фото 2:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[client_foto_2]', $options['client_foto_2']);?>
              </td>
            </tr>
            <tr valign="top">
              <td><h3>Фото 3:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[client_foto_3]', $options['client_foto_3']);?>
              </td>
            </tr>
            <tr valign="top">
              <td><h3>Фото 4:</h3></td>
              <td>
                <?php logo_upload_function('theme_settings[client_foto_4]', $options['client_foto_4']);?>
              </td>
            </tr>
          </table>
          <table class="theme-option-table">
            <tr valign="top"><td colspan='3'><h1>Контакты </h1></td></tr>
          </table>
          <table class="theme-option-table table-block" >
            <tr valign="top">
            <td><h3>Введите телефон 1:</h3></td>
            <td><input type="text" size="40" name="theme_settings[contact_phone_1]" value="<?php esc_attr_e( $options['contact_phone_1'] ); ?>" /></td>
            <td> - Введите телефон 1.</td>
            </tr>
            <tr valign="top">
            <td><h3>Введите телефон 2:</h3></td>
            <td><input type="text" size="40" name="theme_settings[contact_phone_2]" value="<?php esc_attr_e( $options['contact_phone_2'] ); ?>" /></td>
            <td> - Введите телефон 2.</td>
            </tr>
            <tr valign="top">
            <td><h3>Введите Email:</h3></td>
            <td><input type="text" size="40" name="theme_settings[contact_email]" value="<?php esc_attr_e( $options['contact_email'] ); ?>" /></td>
            <td> - Введите електронный сайта.</td>
            </tr>
            <tr valign="top">
            <td><h3>Введите адрес вконтакте:</h3></td>
            <td><input type="text" size="40" name="theme_settings[contact_vk]" value="<?php esc_attr_e( $options['contact_vk'] ); ?>" /></td>
            <td> - Введите адрес вконтакте.</td>
            </tr>
            <tr valign="top">
            <td colspan="3"><h2>Блок часы работы:</h2></td>
            </tr>
            <tr valign="top">
              <td colspan="3" style="min-width:800px;">
              <?php
             wp_editor($options['contact_work_time_block'], 'contact_work_time_block', array(
                'wpautop' => 1,
                'media_buttons' => 1,
                'textarea_name' => 'theme_settings[contact_work_time_block]', //нужно указывать!
                'textarea_rows' => 10,
                'tabindex'      => null,
                'editor_css'    => '',
                'editor_class'  => '',
                'teeny'         => 0,
                'dfw'           => 0,
                'tinymce'       => 1,
                'quicktags'     => 1,
                'drag_drop_upload' => false
              ) );
              ?>
            </td>
            </tr>
              <tr valign="top">
                  <td colspan="3"><h2>Личный кабинет оптовый пользователь (документ):</h2></td>
              </tr>
              <tr valign="top">
                  <td colspan="3" style="min-width:800px;">
                      <?php
                      wp_editor($options['lk-opt-doc'], 'lk-opt-doc', array(
                          'wpautop' => 1,
                          'media_buttons' => 1,
                          'textarea_name' => 'theme_settings[lk-opt-doc]', //нужно указывать!
                          'textarea_rows' => 10,
                          'tabindex'      => null,
                          'editor_css'    => '',
                          'editor_class'  => '',
                          'teeny'         => 0,
                          'dfw'           => 0,
                          'tinymce'       => 1,
                          'quicktags'     => 1,
                          'drag_drop_upload' => false
                      ) );
                      ?>
                  </td>
              </tr>
          </table>
        </section>
   </div>
</div>
<p><input name="submit" id="submit" class="button button-primary my-button-primary" value="Сохранить" type="submit"></p>
</form>
</div>
</div>
<?php }


function logo_upload_function($name, $value = '', $w = 115, $h = 'auto') {
  $default = get_template_directory_uri() . '/components/theme-setting/no-logo.png';
	if( $value ) {
		$image_attributes = wp_get_attachment_image_src( $value, 'full' );
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}?>
	<div>
		<img data-src="<?php echo  $default;?>" src="<?php echo $src; ?>" width="<?php echo $w; ?>px" height="<?php echo $h;?>px" />
		<div>
			<input type="hidden" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value;?>" />
			<button type="button" class="upload_image_button button">Загрузить</button>
			<button type="button" class="remove_image_button button">&times;</button>
		</div>
	</div>
	<?php
}
function img_upload($name, $value = '', $w = 115, $h = 'auto') {
  $default = get_template_directory_uri() . '/components/theme-setting/no-logo.png';
	if( $value ) {
		$image_attributes = wp_get_attachment_image_src( $value, 'full' );
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}


  return '
	<div>
		<img data-src="'.$default.'" src="'.$src.'" width="'.$w.'px" height="'.$h.'px" />
		<div>
			<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />
			<button type="button" class="upload_image_button button">Загрузить</button>
			<button type="button" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
}
/* full_name, short_name, full_name_value, short_name_value style_input style_button параметры передающиеся в массив */
function file_upload($field_array){

    return '
      <input id="file-name-full" type="hidden" name="'.(isset($field_array['full_name'])?$field_array['full_name']:'').'" value="'.(isset($field_array['full_name_value'])?$field_array['full_name_value']:'').'" />
      <input id="file-name-short" type="text" style="'.(isset($field_array['style_input'])?$field_array['style_input']:'').'" name="'.(isset($field_array['short_name'])?$field_array['short_name']:'').'" value="'.(isset($field_array['short_name_value'])?$field_array['short_name_value']:'').'" />
      <input type="button" style="'.(isset($field_array['style_button'])?$field_array['style_button']:'').'" class="chose-file-button" value="Выбрать/Загрузить">
    ';
}
function logo_upload_js() {
  // у вас в админке уже должен быть подключен jQuery, если нет - раскомментируйте следующую строку:
  wp_enqueue_script('jquery');
  // дальше у нас идут скрипты и стили загрузчика изображений WordPress
  if ( ! did_action( 'wp_enqueue_media' ) ) {
    wp_enqueue_media();
  }
  wp_enqueue_script( 'logouploadscript', get_template_directory_uri() . '/components/theme-setting/logo-upload.js', array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'logo_upload_js' );


?>
