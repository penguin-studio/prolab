<?php

function view_contacts_row(){
  $options = get_option( 'theme_settings' );
  return '
  <div class="contact">
      <p class="tel_text">'.$options['contact_phone_1'].'</p>
      <p class="tel_text">'.$options['contact_phone_2'].'</p>
      <p class="mail_text"><a href="mailto:'.$options['contact_email'].'" >'.$options['contact_email'].'</a></p>
      <p class="vk"><a href="'.$options['contact_vk'].'" >'.$options['contact_vk'].'</a></p>
  </div>
  ';
}
add_shortcode( 'contact_row', 'view_contacts_row' );

function two_arrow_block($atts, $content = null){
  extract( shortcode_atts( array(
      'title' => '',
  ), $atts ) );

  return '
  <div class="content-cooperation__desc clearfix">
      <h2 class="content-title content-title__rad">'.$title.'</h2>
      '.do_shortcode($content).'
  </div>
  ';
}
add_shortcode( 'two_arrow_block', 'two_arrow_block' );

function two_arrow_block_ul($atts, $content = null){
  extract( shortcode_atts( array(
      'title' => '',
      'float' => 'l'
  ), $atts ) );
  $float_class = 'left';
  if($float == 'r'){
    $float_class = 'right';
  }
  return '
  <section class="content-col content-col__'.$float_class.'">
      <h1 class="content-col__title">'.$title.'</h1>
      <ul class="content-col__list">
          '.do_shortcode($content).'
      </ul>
  </section>
  ';
}
add_shortcode( 'two_arrow_block_ul', 'two_arrow_block_ul' );
function get_price_url($price_type = ''){
  $options = get_option( 'theme_settings' );
  if($price_type == '') {
    $user_id = get_current_user_id();
    if($user_id == 0){
      return $options['default_full_price'];
    }
    else{
      $user_type = get_user_meta($user_id, 'user_type_field', true);
      if($user_type == 'opt'){
        return $options['opt_full_price'];
      }
      if($user_type == 'drop'){
        return $options['drop_full_price'];
      }
    }
    return $options['default_full_price'];
  }
  else{
    $return_value ='';
    switch ($price_type) {
      case 'opt':  $return_value = $options['opt_full_price']; break;
      case 'drop': $return_value =  $options['drop_full_price']; break;
      case 'default':  $return_value =  $options['opt_full_price']; break;
      default: $return_value =  $options['opt_full_price']; break;
    }
    return $return_value;
  }
  return 0;
}
function get_image_url($value, $size = 'full')
{
  $preview = wp_get_attachment_image_src( $value, $size );
  $preview = $preview[0];

  return $preview;
}

