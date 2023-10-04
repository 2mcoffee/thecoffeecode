<?php

// Registrar un menú de navegación
function register_custom_menu() {
    register_nav_menu('custom-menu', __('Menú Personalizado'));
}
add_action('after_setup_theme', 'register_custom_menu');

// Agregar soporte para imágenes destacadas
add_theme_support('post-thumbnails');

// Cambiar el tamaño de las imágenes destacadas (puedes personalizar los valores)
add_image_size('custom-thumbnail', 300, 200, true);

// Registrar una barra lateral (widget)
function register_custom_sidebar() {
    register_sidebar(array(
        'name' => __('Barra lateral personalizada'),
        'id' => 'custom-sidebar',
        'description' => __('Área de widgets para la barra lateral.'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'register_custom_sidebar');

// Agregar soporte para formatos de entrada (por ejemplo, galería, cita, etc.)
add_theme_support('post-formats', array('gallery', 'quote', 'video'));

// Deshabilitar la barra de administración en el sitio web
function disable_admin_bar() {
    show_admin_bar(false);
}
add_action('after_setup_theme', 'disable_admin_bar');

// Cambiar el número de palabras del extracto
function custom_excerpt_length($length) {
    return 20; // Cambia el número de palabras según tus preferencias
}
add_filter('excerpt_length', 'custom_excerpt_length');

// Personalizar el texto "Leer más"
function custom_read_more_link($link) {
    return '<a class="read-more" href="' . get_permalink() . '">Leer más</a>';
}
add_filter('the_content_more_link', 'custom_read_more_link');

// Habilitar comentarios anidados
function enable_nested_comments() {
    if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'enable_nested_comments');

if (! function_exists('featured_image')) {
    function featured_image()
    {
        global $post;
        $featured_image = '';

        if (has_post_thumbnail($post->ID)) {
            if (is_singular()) {
                $featured_image = '<div class="featured-image">' . get_the_post_thumbnail($post->ID, 'full') . '</div>';
            } else {
                $featured_image = '<div class="featured-image"><a href="' . esc_url(get_permalink()) . '" tabindex="-1">' . esc_html(get_the_title()) . get_the_post_thumbnail($post->ID, 'full') . '</a></div>';
            }
        }

        $featured_image = apply_filters('featured_image', $featured_image);

        if ($featured_image) {
            echo $featured_image;
        }
    }
}

function use_single_template_for_pages($template) {
    if (is_page()) {
        $new_template = locate_template(array('single.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('page_template', 'use_single_template_for_pages');

function custom_social_links() {
    $social_links = array(
        'Facebook' => array(
            'url' => 'https://facebook.com/',
            'icon_class' => 'bi bi-facebook',
            'title' => 'Facebook',
        ),
        'Twitter' => array(
            'url' => 'https://twitter.com/',
            'icon_class' => 'bi bi-twitter-x',
            'title' => 'Twitter',
        ),
        'Instagram' => array(
            'url' => 'https://instagram.com/',
            'icon_class' => 'bi bi-instagram',
            'title' => 'Instagram',
        ),
        'Spotify' => array(
            'url' => 'https://spotify.com/',
            'icon_class' => 'bi bi-spotify',
            'title' => 'Spotify',
        ),
        'GitHub' => array(
            'url' => 'https://github.com/2mcoffee/thecoffeecode',
            'icon_class' => 'bi bi-github',
            'title' => 'GitHub',
        ),
    );

    echo '<div class="social">';
    foreach ($social_links as $network => $link_data) {
        echo '<a rel="noopener" href="' . esc_url($link_data['url']) . '" target="_blank" title="' . esc_attr($link_data['title']) . '"><i class="' . esc_attr($link_data['icon_class']) . '"></i></a> ';
    }
    echo '</div>';
}

?>