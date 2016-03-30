<?php
function customer_review_post_type() {
	$labels = array(
		'name' => 'Отзывы',
		'singular_name' => 'Добавить отзыв', // админ панель Добавить->Функцию
		'add_new' => 'Добавить отзыв',
		'add_new_item' => 'Добавить отзыв', // заголовок тега <title>
		'edit_item' => 'Редактировать отзыв',
		'new_item' => 'Новый отзыв',
		'all_items' => 'Все отзывы',
		'view_item' => 'Посмотреть отзывы на сайте',
		'search_items' => 'Найти отзыв',
		'not_found' =>  'Отзыв не найден.',
		'not_found_in_trash' => 'Отзыв не найден в корзине.',
		'menu_name' => 'Отзывы' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true,
		'taxonomies' => array(),
		'menu_icon' => 'dashicons-star-empty', // иконка в меню
		'menu_position' => 26, // порядок в меню
		'supports' => array('title')
	);
	register_post_type('customer_review', $args);
}
add_action( 'init', 'customer_review_post_type' );
?>
