<?php
/**
 * Примеры кастомизации для WordPress.
 * Вставлять в functions.php дочерней темы.
 */

// --- 1. Убираем админ-панель на сайте для всех, кроме админов ---
// Бесит, когда эта панель ломает верстку или просто мешается.
add_action('after_setup_theme', function() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
});


// --- 2. Меняем унылый логотип WordPress на свой на странице входа ---
// Повышает узнаваемость бренда, если у клиента есть доступ в админку.
add_action('login_enqueue_scripts', function() {
    echo '<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/assets/images/logo.svg); /* Путь к своему лого */
            background-size: contain;
            background-position: center center;
            width: 200px; /* Ширина своего лого */
            height: 80px; /* Высота своего лого */
        }
    </style>';
});


// --- 3. Создаем кастомный тип записей "Проекты" для портфолио ---
// Гораздо правильнее, чем лепить портфолио в обычные "Записи".
add_action('init', function() {
    register_post_type('project', // Системное имя (латиницей, в единственном числе)
        array(
            'labels'      => array(
                'name'          => 'Проекты', // Название в меню
                'singular_name' => 'Проект',
                'add_new_item'  => 'Добавить новый проект',
            ),
            'public'      => true,          // Делаем видимым на сайте и в админке
            'has_archive' => true,          // Включаем страницу архива (site.com/projects/)
            'rewrite'     => array('slug' => 'projects'), // Адрес страницы
            'menu_icon'   => 'dashicons-portfolio', // Иконка в меню
            'supports'    => array('title', 'editor', 'thumbnail', 'custom-fields') // Что будет на странице редактирования
        )
    );
});

// EOF. No closing tag needed if file is pure PHP.
