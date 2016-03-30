<?php
global $post;

function customer_review_data($post){

	wp_nonce_field( basename( __FILE__ ), 'customer_review_data' );

  $review_status = get_post_meta($post->ID,'review_status', true);
  $review_name = get_post_meta($post->ID,'review_name', true);
  $review_img = get_post_meta($post->ID,'review_img', true);
  $review_text = get_post_meta($post->ID,'review_text', true);
  $review_about = get_post_meta($post->ID,'review_about', true);
  $review_url = get_post_meta($post->ID,'review_url', true);

?>  <style>
      table td{
        vertical-align: middle;
      }
    </style>
		<table class="add-box">

				<tr valign="top">
  				<td><h3>Статус:</h3></td>
  				<td>
            <select name="review_status" >
          		<option value="0" <?php selected( $review_status, '0' )?> >Не показывать</option>
          		<option value="1" <?php selected( $review_status, '1' )?> >Показывать</option>
          	</select>
          </td>
  				<td><label> - Выберите статус отзыва. </label></td>
				</tr>

        <tr valign="top">
          <td colspan='2'><h2>Фото спортсмена:</h2></td>
        </tr>
        <tr valign="top">
          <td colspan="3"><?php echo img_upload('review_img', $review_img, 150, 150); ?></td>
        </tr>
				<tr valign="top">
  				<td><h3>Имя Фамилия:</h3></td>
  				<td><input style="width:400px;" type="text" size="10" name="review_name" value="<?php echo $review_name; ?>" /></td>
  				<td><label> - Укажите Имя и Фамилию спортсмена. </label></td>
				</tr>
        <tr valign="top">
        <td colspan="3"><h2>О спортсмене:</h2></td>
        </tr>
        <tr valign="top">
          <td colspan="3" style="min-width:800px;">
          <?php
         wp_editor($review_about, 'review_about', array(
            'wpautop' => 1,
            'media_buttons' => 1,
            'textarea_name' => 'review_about', //нужно указывать!
            'textarea_rows' => 4,
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
  				<td><h3>Ссылка отзыва:</h3></td>
  				<td><input style="width:400px;" type="text" size="10" name="review_url" value="<?php echo $review_url; ?>" /></td>
  				<td><label> - Введите ссылку на отзыв. </label></td>
				</tr>
        <tr valign="top">
        <td colspan="3"><h2>Текст отзыва:</h2></td>
        </tr>
        <tr valign="top">
          <td colspan="3" style="min-width:800px;">
          <?php
         wp_editor($review_text, 'review_text', array(
            'wpautop' => 1,
            'media_buttons' => 1,
            'textarea_name' => 'review_text', //нужно указывать!
            'textarea_rows' => 4,
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
	<?php
}

function customer_review_data_save ( $post_id ) {
	// проверяем, пришёл ли запрос со страницы с метабоксом
	if ( !isset( $_POST['customer_review_data'] )
	|| !wp_verify_nonce( $_POST['customer_review_data'], basename( __FILE__ ) ) )
        return $post_id;
	// проверяем, является ли запрос автосохранением
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
	// проверяем, права пользователя, может ли он редактировать записи
	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	// теперь также проверим тип записи
	$post = get_post($post_id);
	//if ($post->post_type == 'object_1_room')
	//необходимо добавлять новый объект!!!
  if ($post->post_type == 'customer_review')
  { // укажите собственный
    update_post_meta($post->ID,'review_status', $_POST['review_status']);
    update_post_meta($post->ID,'review_name', $_POST['review_name']);
    update_post_meta($post->ID,'review_img', $_POST['review_img']);
		update_post_meta($post->ID,'review_url', $_POST['review_url']);
		update_post_meta($post->ID,'review_text', $_POST['review_text']);
		update_post_meta($post->ID,'review_about', $_POST['review_about']);
  }
	return $post_id;
}
add_action('save_post', 'customer_review_data_save');

function load_customer_review_data() {
	add_meta_box('', 'Данные отзыва', 'customer_review_data', 'customer_review', 'normal', 'high');
}

add_action( 'admin_menu', 'load_customer_review_data' );
