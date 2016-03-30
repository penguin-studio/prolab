<?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
// подключение меню
add_action('after_setup_theme', function(){
    register_nav_menus( array(
        'header_menu' => 'Меню в шапке',
        'footer_menu' => 'Меню в подвале'
    ) );
});
// подключение меню конец
add_theme_support('post-thumbnails');
add_theme_support( 'woocommerce' );
remove_filter( 'the_content', 'wpautop' );

add_image_size( 'client_foto', 233, 233, true );
add_image_size( 'sertificate', 226, 329, true );

add_image_size( 'slider', 1120, 280, true );

function true_include_jquery() {
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'true_include_jquery' );
function mytheme_enqueue_options_style() {
    wp_enqueue_style( 'mytheme-options-style', get_template_directory_uri().'/components/theme-setting/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'mytheme_enqueue_options_style' );
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
// Подключение настроек темы
require get_template_directory() . '/components/theme-setting/theme-setting.php';
//Подключение функций темы
require get_template_directory() . '/components/theme-function.php';

require get_template_directory() . '/components/post-types/post-type-setting.php';

require  get_template_directory(). '/components/woo-setting/woo-setting.php';

require  get_template_directory(). '/components/account-function.php';

require  get_template_directory(). '/components/pengstud-footer/pengstud-footer.php';

function login_redirect() {

        return home_url('/sotrudnichestvo');

}
add_filter('login_redirect', 'login_redirect');

function logout_redirect(){
    wp_redirect( '/sotrudnichestvo' );
    exit();
}
add_action('wp_logout','logout_redirect');
