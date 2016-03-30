<?php
function slider_post_type() {
	$labels = array(
		'name' => 'Слайдер',
		'singular_name' => 'Добавить слайд', // админ панель Добавить->Функцию
		'add_new' => 'Добавить слайд',
		'add_new_item' => 'Добавить слайд', // заголовок тега <title>
		'edit_item' => 'Редактировать слайд',
		'new_item' => 'Новый слайд',
		'all_items' => 'Все слайды',
		'view_item' => 'Посмотреть слайд на сайте',
		'search_items' => 'Найти слайд',
		'not_found' =>  'Слайд не найден.',
		'not_found_in_trash' => 'Слайд не найден в корзине.',
		'menu_name' => 'Слайдер' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true,
		'taxonomies' => array(),
		'menu_icon' => 'dashicons-format-gallery', // иконка в меню
		'menu_position' => 27, // порядок в меню
		'supports' => array('title')
	);
	register_post_type('slider', $args);
}
add_action( 'init', 'slider_post_type' );
function slider_taxonomies() {
	/* создаем функцию с произвольным именем и вставляем
    в неё register_taxonomy() */
	register_taxonomy('slider_cat',
		array('slider'),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => 'Slider category',
				'singular_name' => 'Слайдер',
				'search_items' =>  'Найти слайдер',
				'popular_items' => 'Популярный категория',
				'all_items' => 'Все слайдеры',
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => 'Редактировать слайдер',
				'update_item' => 'Обновить слайдер',
				'add_new_item' => 'Добавить новый слайдер',
				'new_item_name' => 'Имя нового слайдера',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
				'menu_name' => 'Слайдер'
			),
			'public' => true,
			/* каждый может использовать таксономию, либо
			только администраторы, по умолчанию - true */
			'show_in_nav_menus' => true,
			/* добавить на страницу создания меню */
			'show_ui' => true,
			/* добавить интерфейс создания и редактирования */
			'show_tagcloud' => true,
			/* нужно ли разрешить облако тегов для этой таксономии */
			'update_count_callback' => '_update_post_term_count',
			/* callback-функция для обновления счетчика $object_type */
			'query_var' => 'equipm_cat',
			/* разрешено ли использование query_var, также можно
			указать строку, которая будет использоваться в качестве
			него, по умолчанию - имя таксономии */
			'rewrite' => array(
				/* настройки URL пермалинков */
				'slug' => 'equipm_cat', // ярлык
				'hierarchical' => false // разрешить вложенность

			),
		)
	);
}
add_action( 'init', 'slider_taxonomies', 0 );