<?php
function view_login_registration_form(){

    global $user_ID, $user_identity;

    get_currentuserinfo();

    ?>

    <div class="popup-box popup-box-enter">
        <div class="top clearfix">
            <a class="popup-box-enter__btn popup-box-enter__btn-reg" href="#">Регистрация</a>
            <a class="popup-box-enter__btn popup-box-enter__btn-enter active" href="#">Вход</a>
        </div>
        <div class="bottom tab_content">
            <div class="tab-1">
                <?php custom_registration_function(); ?>
            </div>
            <div class="tab-2">
                <?php
                if (!$user_ID):
                ?>
                <form name="loginform" id="autoriz" action="<?php echo get_site_url(); ?>/wp-login.php" method="post">
                    <label class="popup-label popup-email">
                        <input type="text" name="log" placeholder="Логин" value="" id="login" />
                    </label>
                    <label class="popup-label popup-pass">
                        <input type="password" name="pwd" placeholder="Пароль" value="" id="password" />
                    </label>
                    <label class="check">
                        <input name="rememberme" id="rememberme" type="checkbox" />Запомнить меня<span></span>
                    </label>
                    <input class="popup-submit" type="submit" value="Войти">
                </form>
                <?php else: ?>

                <h5 class="smile">Добро пожаловать, <?php echo $user_identity; ?>.</h5><?php wp_loginout(); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

function custom_registration_function() {
    global $username, $password, $email, $password_rep, $phone, $user_type;

    if (isset($_POST['custom-reg'])) {

        $result = registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['password_rep'],
            $_POST['email'],
            $_POST['phone']
        );


        $username	= 	sanitize_user($_POST['username']);
        $password 	= 	esc_attr($_POST['password']);
        $password_rep 	= 	esc_attr($_POST['password_rep']);
        $email 		= 	sanitize_email($_POST['email']);
        $phone 		= 	esc_attr($_POST['phone']);
        $user_type = '';

        if(isset($_POST['opt'])){$user_type = $_POST['opt'];}
        if(isset($_POST['drop'])){$user_type = $_POST['drop'];}


        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
            $username,
            $password,
            $email,
            $phone,
            $user_type
        );
        if($result == 0){
            echo '
            <script>
                $(window).load(function(){
                    $(".registration-btn").click();
                });
            </script>
        ';
        }else{
        echo '
            <script>
                $(window).load(function(){
                    var scrollPos = $(window).scrollTop();
                    $(".popup-box-registration").show();
                    $(".blackout").show();
                    $(document).scrollTop(scrollPos);
                });
            </script>
        ';}
    }

    registration_form(
        $username,
        $password,
        $password_rep,
        $email,
        $phone
    );
}

function registration_form( $username, $password, $password_rep, $email, $phone) {

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">

	<label class="popup-label popup-name">
	<input type="text"  autocomplete="off"  placeholder="Ваше логин"  name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
	</label>
    <label class="popup-label popup-email">
	<input type="text"  autocomplete="off"  placeholder="Ваш e-mail" name="email" value="' . (isset($_POST['email']) ? $email : null) . '">
	</label>
	<label class="popup-label popup-phone">
        <input type="text"  placeholder="Ваш номер телефона" name="phone"  value="' . (isset($_POST['phone']) ? $phone : null) . '">
    </label>
	<label class="popup-label popup-pass">
	<input type="password"  autocomplete="off"  placeholder="Пароль"   name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
	</label>
    <label class="popup-label popup-pass2">
	<input type="password"  autocomplete="off"  placeholder="Повторите пароль"  name="password_rep" value="' . (isset($_POST['password_rep']) ? $password_rep : null) . '">
	</label>

        <input type="hidden" name="custom-reg" value="default-form">
        <label class="check"><input id="opt-chbox" type="checkbox"  name="opt" value="opt">Опт<span></span></label>
        <label class="check check2"><input id="rozn-chbox" type="checkbox" checked="checked" name="drop" value="drop">Дропшиппинг<span></span></label>
    	<input class="popup-submit popup-submit__reg" type="submit" value="Зарегистрироваться">
	</form>

	';
}

function registration_validation($username, $password, $password_rep, $email, $phone)  {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty( $username ) || empty( $password ) || empty( $email ) || empty( $password_rep ) || empty( $phone )) {
        $reg_errors->add('field', 'Не все поля заполнены');
    }

    if ( strlen( $username ) < 4 ) {
        $reg_errors->add('username_length', 'Слишком короткое логин пользователя');
    }

    if ( username_exists( $username ) )
        $reg_errors->add('user_name', 'Данный логин занят!');

    if ( !validate_username( $username ) ) {
        $reg_errors->add('username_invalid', 'Не коректное имя пользователя');
    }

    if ( strcmp( $password, $password_rep ) != 0 ) {
        $reg_errors->add('password_compare', 'Пароли не совпадают');
    }

    if ( strlen( $password ) <= 5 ) {
        $reg_errors->add('password', 'Пароль должен быть не менее 6 символов');
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add('email_invalid', 'Не корректный email');
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add('email', 'Email уже используется');
    }

    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>Ошибка</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
        if(count($reg_errors->get_error_messages()) > 0){
            return 0;
        }
        else {return 1;}

    }

}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $phone, $user_type;
    if ( count($reg_errors->get_error_messages()) < 1 ) {
        /*$userdata = array(
            'user_login'	=> 	$username,
            'user_email' 	=> 	$email,
            'user_pass' 	=> 	$password,
        );*/
        $userdata = apply_filters( 'woocommerce_new_customer_data', array(
            'user_login' => $username,
            'user_pass'  => $password,
            'user_email' => $email,
            'role'       => 'customer'
        ) );

        $user = wp_insert_user( $userdata );

       wp_new_user_notification($user);


        update_user_meta( $user, 'billing_email', $email );
        update_user_meta( $user, 'billing_first_name', $username );
        update_user_meta( $user, 'billing_phone', $phone );
        update_user_meta( $user, 'user_type_field', $user_type );
        update_user_meta( $user, 'user_order_total', 0);
        update_user_meta( $user, 'user_to_next_sale', 5000 );
        update_user_meta( $user, 'user_sale', 0 );
    }
}
function add_additional_data( $user )
{
    $user_type = esc_attr(get_the_author_meta( 'user_type_field', $user->ID ));
    $user_order_total = esc_attr(get_the_author_meta( 'user_order_total', $user->ID ));
    $user_to_next_sale = esc_attr(get_the_author_meta( 'user_to_next_sale', $user->ID ));
    $user_sale = esc_attr(get_the_author_meta( 'user_sale', $user->ID ));
    ?>
    <table class="form-table">
        <tbody>
        <tr>
        <th scope="row">Тип покупателя</th>
        <td>
        <select name="user_type_field" >
            <option value="opt" <?php selected( $user_type, 'opt' )?> >Оптовый покупатель</option>
            <option value="drop" <?php selected( $user_type, 'drop' )?> >Розничный покупатель</option>
        </select>
        </td>
        </tr>
        <tr>
            <th scope="row">Заказов на сумму</th>
            <td>
                <input type="text" name="user_order_total" value="<?php echo $user_order_total; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">До следующей скидки</th>
            <td>
                <input type="text" name="user_to_next_sale" value="<?php echo $user_to_next_sale; ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">Скидка в процентах от 0</th>
            <td>
                <input type="text" name="user_sale" value="<?php echo $user_sale; ?>">
            </td>
        </tr>
        </tbody>
    </table>
    <?php
}
function save_additional_data( $user_id )
{
    update_user_meta( $user_id, 'user_type_field', sanitize_text_field( $_POST['user_type_field'] ) );
    update_user_meta( $user_id, 'user_order_total', sanitize_text_field( $_POST['user_order_total'] ) );
    update_user_meta( $user_id, 'user_to_next_sale', sanitize_text_field( $_POST['user_to_next_sale'] ) );
    update_user_meta( $user_id, 'user_sale', sanitize_text_field( $_POST['user_sale'] ) );
}
//Добавление полей
add_action( 'show_user_profile', 'add_additional_data' );
add_action( 'edit_user_profile', 'add_additional_data' );
//Сохранение полей
add_action( 'personal_options_update', 'save_additional_data' );
add_action( 'edit_user_profile_update', 'save_additional_data' );

function true_user_id_column( $columns ) {
    print_r($columns);
    $columns['phone'] = 'Телефон';
    $columns['user_type'] = 'Тип пользователя';
    return $columns;

}
add_filter('manage_users_columns', 'true_user_id_column');

function true_user_phone_column_content($value, $column_name, $user_id) {
    if ( 'phone' == $column_name )
        return get_user_meta( $user_id, 'billing_phone', true );
    return $value;
}
add_action('manage_users_custom_column',  'true_user_phone_column_content', 10, 3);

function true_user_type_column_content($value, $column_name, $user_id) {
    if ( 'user_type' == $column_name ) {
        $user_type = get_user_meta($user_id, 'user_type_field', true);
        if($user_type == 'opt'){
            return 'Оптовый покупатель';
        }
        if($user_type == 'drop'){
            return 'Розничный покупатель';
        }
        return 'Не определён';
    }
    return $value;
}
add_action('manage_users_custom_column',  'true_user_type_column_content', 10, 3);


function avtomatic_drop_order(){
if(isset($_POST['drop-order'])) {
    $user_id = get_current_user_id();
    $first_name = isset($_POST['uname'])? esc_attr($_POST['uname']) : get_user_meta( $user_id, 'billing_first_name', true );
    $email = get_user_meta( $user_id, 'billing_email', true );
    $city = isset($_POST['ucity'])? esc_attr($_POST['ucity']) : get_user_meta( $user_id, 'billing_address_1', true );
    $post = isset($_POST['upost'])? esc_attr($_POST['upost']) : get_user_meta( $user_id, 'billing_city', true );
    $phone = isset($_POST['uphone'])? esc_attr($_POST['uphone']) : get_user_meta( $user_id, 'billing_phone', true );
    $order_comments = isset($_POST['order_comments'])? esc_attr($_POST['order_comments']) : get_user_meta( $user_id, 'order_comments', true );

    $products_id = esc_attr($_POST['products-id']);

    $order = wc_create_order(); //создаём новый заказ
//Записываем в массив данные о доставке заказа и данные клиента
    $address = array(
        'first_name' => $first_name,
        'last_name' => '',
        'company' => '',
        'email' => $email,
        'phone' => $phone,
        'address_1' => $city,
        'city' => $post
    );

    $products_id = explode(';',$products_id);
    foreach($products_id as $product_id){
        $product_id = explode(':',$product_id);

        $order->add_product(
            wc_get_product($product_id[1]),
            $product_id[0],
            array(
            'variation' => array(
                'attribute_pa_vkus' => $product_id[2]
                )
            )
        );
    }

    $order->set_address($address, 'billing'); //Добавляем данные о доставке
    $order->set_address($address, 'shipping'); // и оплате

    update_post_meta($order->id, 'order_custom_comment', $order_comments);

    $order->calculate_totals(); //подбиваем сумму и видим что наш заказ появился в админке

    $user_sale = 0;
    if(get_user_meta( $user_id, 'user_sale', true )) {
        $user_sale = get_user_meta($user_id, 'user_sale', true);
    }
    $full_sale = $order->get_total() * ((int)$user_sale/100);

    $order->set_total($order->get_total()-$full_sale);


    if( ! empty( $_FILES ) && $_FILES['my_file'] != '') {
        if($attachment_id = upload_user_file( $_FILES['my_file'] )) {
            update_post_meta($order->id, 'order_file_url', wp_get_attachment_url($attachment_id));
        }
    }


    if(get_user_meta( $user_id, 'billing_first_name', true ) || get_user_meta( $user_id, 'billing_first_name', true ) == ''){
        update_user_meta( $user_id, 'billing_first_name', $first_name );
    }
    if(get_user_meta( $user_id, 'billing_address_1', true ) || get_user_meta( $user_id, 'billing_address_1', true ) == ''){
        update_user_meta( $user_id, 'billing_address_1', $city );
    }
    if(get_user_meta( $user_id, 'billing_city', true ) || get_user_meta( $user_id, 'billing_city', true ) == ''){
        update_user_meta( $user_id, 'billing_city', $post );
    }
    if(get_user_meta( $user_id, 'billing_phone', true ) || get_user_meta( $user_id, 'billing_phone', true ) == ''){
        update_user_meta( $user_id, 'billing_phone', $phone );
    }

/*
    new WC_Emails;
    $mess = new WC_Email_New_Order();
    $mess->trigger( $order->id );
*/

    $order->update_status('processing');
    return $order;
}
    return 0;
}
add_action('woocommerce_email_customer_details', 'add_additional_email_field', 40);
function add_additional_email_field($order){
    if( get_post_meta($order->id, 'order_file_url', true) != '') {
        echo '<h2 style=\'color: #557da1; display: block; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;\'>Файл к заказу</h2>';
        echo '<a href="' . get_post_meta($order->id, 'order_file_url', true) . '" download>' . get_post_meta($order->id, 'order_file_url', true) . '</a>';
    }
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order)
{   if(get_post_meta($order->id, 'order_file_url', true) != '') {
        echo '<p><strong>' . __('Ссылка на файл заказа') . ':</strong> <a href="' . get_post_meta($order->id, 'order_file_url', true) . '" download>' . get_post_meta($order->id, 'order_file_url', true) . '</a></p>';
    }
    if(get_post_meta($order->id, 'order_custom_comment', true) != '') {
        echo '<p><strong>' . __('Комментарий к заказу') . ':</strong><br>'.get_post_meta($order->id, 'order_custom_comment', true).'</p>';
    }
}
function avtomatic_opt_order(){

    if(isset($_POST['opt-order'])) {
        $user_id = get_current_user_id();
        $first_name =  get_user_meta( $user_id, 'billing_first_name', true );
        $email = get_user_meta( $user_id, 'billing_email', true );
        $city = get_user_meta( $user_id, 'billing_address_1', true );
        $post = get_user_meta( $user_id, 'billing_city', true );
        $phone = get_user_meta( $user_id, 'billing_phone', true );
        $order_comments = isset($_POST['order_comments'])? esc_attr($_POST['order_comments']) : get_user_meta( $user_id, 'order_comments', true );


        $order = wc_create_order(); //создаём новый заказ
//Записываем в массив данные о доставке заказа и данные клиента
        $address = array(
            'first_name' => $first_name,
            'last_name' => '',
            'company' => '',
            'email' => $email,
            'phone' => $phone,
            'address_1' => $city,
            'city' => $post
        );



        $order->set_address($address, 'billing'); //Добавляем данные о доставке
        $order->set_address($address, 'shipping'); // и оплате
        $order->calculate_totals(); //подбиваем сумму и видим что наш заказ появился в админке

        update_post_meta($order->id, 'order_custom_comment', $order_comments);

        if( ! empty( $_FILES ) && $_FILES['my_file'] != '') {
            if($attachment_id = upload_user_file( $_FILES['my_file'] )) {
                update_post_meta($order->id, 'order_file_url', wp_get_attachment_url($attachment_id));
            }
        }

/*
        new WC_Emails;
        $mess = new WC_Email_New_Order();
        $mess->trigger( $order->id );
*/
        $order->update_status('processing');
        return $order;
    }
    if(isset($_POST['opt-catalog-order'])) {
        $user_id = get_current_user_id();
        $first_name = isset($_POST['uname'])? esc_attr($_POST['uname']) : get_user_meta( $user_id, 'billing_first_name', true );
        $email = get_user_meta( $user_id, 'billing_email', true );
        $city = isset($_POST['ucity'])? esc_attr($_POST['ucity']) : get_user_meta( $user_id, 'billing_address_1', true );
        $post = isset($_POST['upost'])? esc_attr($_POST['upost']) : get_user_meta( $user_id, 'billing_city', true );
        $phone = isset($_POST['uphone'])? esc_attr($_POST['uphone']) : get_user_meta( $user_id, 'billing_phone', true );
        $order_comments = isset($_POST['order_comments'])? esc_attr($_POST['order_comments']) : get_user_meta( $user_id, 'order_comments', true );


        $order = wc_create_order(); //создаём новый заказ
//Записываем в массив данные о доставке заказа и данные клиента
        $address = array(
            'first_name' => $first_name,
            'last_name' => '',
            'company' => '',
            'email' => $email,
            'phone' => $phone,
            'address_1' => $city,
            'city' => $post
        );

        $products_id = esc_attr($_POST['products-id']);
        $products_id = explode(';',$products_id);
        foreach($products_id as $product_id){
            $product_id = explode(':',$product_id);

            $order->add_product(
                wc_get_product($product_id[1]),
                $product_id[0],
                array(
                    'variation' => array(
                        'attribute_pa_vkus' => $product_id[2]
                    )
                )
            );
        }

        $order->set_address($address, 'billing'); //Добавляем данные о доставке
        $order->set_address($address, 'shipping'); // и оплате
        update_post_meta($order->id, 'order_custom_comment', $order_comments);

        $order->calculate_totals(); //подбиваем сумму и видим что наш заказ появился в админке

        $user_sale = 0;
        if(get_user_meta( $user_id, 'user_sale', true )) {
            $user_sale = get_user_meta($user_id, 'user_sale', true);
        }
        $full_sale = $order->get_total() * ((int)$user_sale/100);

        $order->set_total($order->get_total()-$full_sale);


        if(get_user_meta( $user_id, 'billing_first_name', true ) || get_user_meta( $user_id, 'billing_first_name', true ) == ''){
            update_user_meta( $user_id, 'billing_first_name', $first_name );
        }
        if(get_user_meta( $user_id, 'billing_address_1', true ) || get_user_meta( $user_id, 'billing_address_1', true ) == ''){
            update_user_meta( $user_id, 'billing_address_1', $city );
        }
        if(get_user_meta( $user_id, 'billing_city', true ) || get_user_meta( $user_id, 'billing_city', true ) == ''){
            update_user_meta( $user_id, 'billing_city', $post );
        }
        if(get_user_meta( $user_id, 'billing_phone', true ) || get_user_meta( $user_id, 'billing_phone', true ) == ''){
            update_user_meta( $user_id, 'billing_phone', $phone );
        }

/*
        new WC_Emails;
        $mess = new WC_Email_New_Order();
        $mess->trigger( $order->id );
*/
        $order->update_status('processing');

        return $order;
    }
    return 0;
}
function upload_user_file( $file = array() ) {
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    $file_return = wp_handle_upload( $file, array('test_form' => false ) );
    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        return false;
    } else {
        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );
        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );
        if( 0 < intval( $attachment_id ) ) {
            return $attachment_id;
        }
    }
    return false;
}
