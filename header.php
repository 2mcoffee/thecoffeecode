<!DOCTYPE html>
<html <?php language_attributes(); ?>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?><?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <?php wp_head(); ?>
    
    <link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
    <script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/jquery/jquery-3.7.1.min.js"></script>
    <link href="<?php echo get_template_directory_uri(); ?>/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <header class="border-bottom lh-1 py-3 text-center">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="img-fluid img-logo img-unselectable pt-4" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>"></a>
        </header>
        <div class="nav-scroller py-1 mb-3 border-bottom">
            <nav class="nav nav-underline justify-content-between">
                <?php
                $categories = get_categories();

                foreach ($categories as $category) {
                    $category_name = $category->name;
                    $category_link = get_category_link($category->term_id);
                    echo '<a class="nav-item nav-link link-body-emphasis" href="' . esc_url($category_link) . '">' . esc_html($category_name) . '</a>';
                }
                ?>
            </nav>
        </div>
