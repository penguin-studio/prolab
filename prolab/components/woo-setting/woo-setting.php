<?php

function woocommerce_additional_fields(){
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'woo-additional-field' );

    $product_weight = get_post_meta($post->ID,'product-weight', true);
    $product_weight_gr = get_post_meta($post->ID,'product-weight-gr', true);
    $product_button_type = get_post_meta($post->ID,'product-button-type', true);
    $product_title_color = get_post_meta($post->ID,'product-title-color', true);
    $product_img = get_post_meta($post->ID,'product-img', true);
    $best_offer = get_post_meta($post->ID,'best-offer', true);

    ?>  <style>
        table td{
            vertical-align: middle;
        }
    </style>

    <table class="add-box">
        <tr valign="top">
            <td><h3>Лидер продаж:</h3></td>
            <td><input type="checkbox" name="best-offer" value="1" <?php if($best_offer=='1') echo ' checked="checked"';?>></td>
            <td><label> - Отметьте для отображения лидера продаж</label></td>
        </tr>
        <tr valign="top">
            <td><h3>Миниатюра товара для страницы описания специальных предложений:</h3></td>
            <td><?php logo_upload_function('product-img', $product_img);?></td>
            <td><label> - Заполните миниатюру товара для страницы описания</label></td>
        </tr>
        <tr valign="top">
            <td><h3>Поле вес товара для каталогов:</h3></td>
            <td><input style="width:240px;" type="text" size="10" name="product-weight" value="<?php echo $product_weight; ?>" /></td>
            <td><label> - Заполните поле вес товара</label></td>
        </tr>
        <tr valign="top">
            <td><h3>Поле вес товара для карточки товара :</h3></td>
            <td><input style="width:240px;" type="text" size="10" name="product-weight-gr" value="<?php echo $product_weight_gr; ?>" /></td>
            <td><label> - Заполните поле вес товара. </label></td>
        </tr>
        <tr valign="top">
            <td><h3>Выберите кнопку:</h3></td>
            <td>
                <select name="product-button-type" >
                    <option value="0" <?php selected( $product_button_type, '0' )?> >Не выбрано</option>
                    <option value="1" <?php selected( $product_button_type, '1' )?> >Для здоров'я</option>
                    <option value="2" <?php selected( $product_button_type, '2' )?> >Для набора масы</option>
                    <option value="3" <?php selected( $product_button_type, '3' )?> >Для продуктивных тренировок</option>
                </select>
            </td>
            <td><label> - Выберите кнопку. </label></td>
        </tr>

        <tr valign="top">
            <td><h3>Выберите цвет заголовка товара:</h3></td>
            <td><input class="color-field"  type="text" size="10" name="product-title-color" value="<?php echo $product_title_color; ?>" /></td>
            <td><label></label></td>
        </tr>

    </table>
    <?php
}

function woocommerce_additional_fields_save ( $post_id ) {
    // проверяем, пришёл ли запрос со страницы с метабоксом
    if ( !isset( $_POST['woo-additional-field'] )
        || !wp_verify_nonce( $_POST['woo-additional-field'], basename( __FILE__ ) ) )
        return $post_id;
    // проверяем, является ли запрос автосохранением
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
    // проверяем, права пользователя, может ли он редактировать записи
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    // теперь также проверим тип записи
    $post = get_post($post_id);

    if ($post->post_type == 'product')
    { // укажите собственный
        update_post_meta($post->ID,'product-weight', $_POST['product-weight']);
        update_post_meta($post->ID,'product-weight-gr', $_POST['product-weight-gr']);
        update_post_meta($post->ID,'product-button-type', $_POST['product-button-type']);
        update_post_meta($post->ID,'product-title-color', $_POST['product-title-color']);
        update_post_meta($post->ID,'product-img', $_POST['product-img']);
        $best_offer = 0;
        if(isset($_POST['best-offer'])){
            $best_offer = 1;
        }
        update_post_meta($post->ID,'best-offer', $best_offer);
    }
    return $post_id;
}
add_action('save_post', 'woocommerce_additional_fields_save');

function load_woocommerce_additional_fields() {
    add_meta_box('', 'Дополнительные данные о товаре', 'woocommerce_additional_fields', 'product', 'normal', 'high');
}
add_action( 'admin_menu', 'load_woocommerce_additional_fields' );

function woocommerce_additional_fields_js() {
    // у вас в админке уже должен быть подключен jQuery, если нет - раскомментируйте следующую строку:
    wp_enqueue_script('jquery');
    // дальше у нас идут скрипты и стили загрузчика изображений WordPress
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script( 'woocommerce_additional_fields_js', get_template_directory_uri() . '/components/woo-setting/woo-setting.js', array('jquery'), null, false );
}
add_action( 'admin_enqueue_scripts', 'woocommerce_additional_fields_js' );


function view_comments($post_g, $comment_id = ''){
global $post;
$post = $post_g;

$post_ID = $post->ID;
$comm_class = 'comment';

if($comment_id == ''){
    $comments = get_comments(array('post_id' => $post_ID, 'hierarchical' => 'threaded'));
}
else{
    $comments = get_comments(array('post_id' => $post_ID, 'parent' => (int)$comment_id));
    $comm_class = 'answer';
}

if($comments){
foreach ($comments as $comment) :
    ?>
    <?php //$comment_type = get_comment_type(); ?>
    <?php if(true) { ?>

    <div class="comments-item <?php echo $comm_class; ?>" id="comm-<?php echo $comment->comment_ID; ?>">
        <?php echo $comment->comment_content; ?>
        <?php
            $autor = $comment->comment_author;
            if(strpos(trim($comment->comment_author),' ')){
                $autor = substr($comment->comment_author,0,strpos(trim($comment->comment_author),' '));
            }

        ?>
        <span class="comment-label"><?php echo $autor; ?><b class="date">  <?php echo get_comment_date('d.m.Y', $comment->comment_ID); ?></b>
         <a href="#comm-<?php echo $comment->comment_ID; ?>" id="reply-button" comm-post-id="<?php echo $post_ID; ?>" comm-id="<?php echo $comment->comment_ID; ?>" >Ответить</a>
        </span>
    </div>
<?php
    view_comments($post, $comment->comment_ID);
    ?>
<?php } /* End of is_comment statement */ ?>
<?php endforeach;
}else{
    return 1;
}
}

add_filter( 'woocommerce_checkout_fields' , 'woo_remove_billing_checkout_fields' );


function woo_remove_billing_checkout_fields( $fields ) {

        unset($fields['billing']['billing_last_name']); // убираем опцию указания фамилия
        unset($fields['billing']['billing_company']); // убираем опцию указания компании
        //unset($fields['billing']['billing_address_1']); // убираем первую строку адреса
        unset($fields['billing']['billing_address_2']); // убираем вторую строку адреса
        //unset($fields['billing']['billing_city']); // убираем город
        unset($fields['billing']['billing_postcode']); // убираем поле индекса
        unset($fields['billing']['billing_country']); // убираем страну
        unset($fields['billing']['billing_state']); // убираем штат/область
        //unset($fields['billing']['billing_phone']); // убираем опцию указания номера телефона
        //unset($fields['order']['order_comments']); // убираем поле примечания/комментариев к заказу
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['ship-to-different-address-checkbox']);

        $fields['billing']['billing_first_name']['label'] = 'Имя';
        $fields['billing']['billing_first_name']['label_class'] = array('icon', 'name');
        $fields['billing']['billing_first_name']['placeholder'] = '*Как вас зовут?';
        $fields['billing']['billing_first_name']['required'] = true;

        $fields['billing']['billing_phone']['label'] = 'Номер телефона';
        $fields['billing']['billing_phone']['class'] = array('icon', 'phone');
        $fields['billing']['billing_phone']['placeholder'] = '*Ваш номер телефона';

        $fields['billing']['billing_email']['label'] = 'Електронный адрес';
        $fields['billing']['billing_email']['class'] = array('icon', 'email');
        $fields['billing']['billing_email']['placeholder'] = 'e-mail';
        $fields['billing']['billing_email']['required'] = false;

        $fields['order']['order_comments']['placeholder'] = 'Комментарий к заказу';
        $fields['order']['order_comments']['class'] = array('icon', 'message');
        $fields['order']['order_comments']['label'] = 'Комментарий';

        $fields['billing']['billing_address_1']['placeholder'] = 'В какой город доставить';
        $fields['billing']['billing_address_1']['class'] = array('icon', 'city');
        $fields['billing']['billing_address_1']['label'] = 'Город доставки';
        $fields['billing']['billing_address_1']['required'] = false;

        $fields['billing']['billing_city']['placeholder'] = 'Отделение Новой Почты';
        $fields['billing']['billing_city']['class'] = array('icon', 'post');
        $fields['billing']['billing_city']['label'] = 'Отделение Новой почты';
        $fields['billing']['billing_city']['required'] = false;

    $temp_arr = $fields;

    $fields = array(
        'billing' => array(
            'billing_first_name' => $temp_arr['billing']['billing_first_name'],
            'billing_city' => $temp_arr['billing']['billing_city'],
            'billing_address_1' => $temp_arr['billing']['billing_address_1'],
            'billing_phone' => $temp_arr['billing']['billing_phone'],
            'billing_email' => $temp_arr['billing']['billing_email']
        ),
        'shipping' => $temp_arr['shipping'],
        'order' => $temp_arr['order']
    );
    return $fields;
}


