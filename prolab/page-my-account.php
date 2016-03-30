<?php get_header();?>
<?php if( is_user_logged_in()) {
    $user_id = get_current_user_id();
    $user_type = get_user_meta($user_id, 'user_type_field', true);

    if ($user_type == 'opt') {
        get_template_part('account', 'opt-user-page');
    }
    if ($user_type == 'drop') {
        get_template_part('account', 'drop-user-page');
    }

}else{
    ?>
    Зарегистрируйтесь
<?php } ?>
<?php get_footer(); ?>
