<?php
get_header();
?>

<main>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="mb-4">
                <h1><?php single_cat_title(); ?></h1>
            </div>
            <?php
            $posts_per_page = 10; 
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            $args = array(
                'post_type' => 'post',
                'category_name' => single_cat_title("", false),
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
            );

            $category_query = new WP_Query($args);

            if ($category_query->have_posts()) :
                while ($category_query->have_posts()) :
                    $category_query->the_post();
            ?>
                    <div class="card mb-4">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail', ['class' => 'img-fluid rounded-start', 'alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/no-image.jpg" class="img-fluid rounded-start" alt="Imagen no disponible">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <p class="card-text">
                                        <?php
                                        $excerpt = get_the_excerpt();
                                        echo '<div class="mb-3">' . " \n";
                                        echo wp_trim_words($excerpt, 20) . " \n";
                                        echo '</div>' . " \n";
                                        echo '<a href="' . get_permalink() . '">Leer más <i class="bi bi-arrow-right-square"></i></a>';
                                        ?>
                                    </p>
                                    <p class="card-text"><small class="text-body-secondary">Publicado por <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-blog"><?php the_author(); ?></a> el <span class="text-blog"><?php the_time('d/m/Y'); ?></span></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endwhile; ?>
            <?php

            echo '<div class="col-12">';
            echo '<nav aria-label="Page navigation example">';
            echo '<ul class="pagination pagination-custom justify-content-center">';

            if ($paged > 1) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged - 1)) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            } else {
                echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&laquo;</span></li>';
            }

            for ($i = 1; $i <= $category_query->max_num_pages; $i++) {
                if ($i == $paged) {
                    echo '<li class="page-item active"><span class="page-link">' . esc_html($i) . '</span></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html($i) . '</a></li>';
                }
            }

            if ($paged < $category_query->max_num_pages) {
                echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged + 1)) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
            } else {
                echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&raquo;</span></li>';
            }

            echo '</ul>';
            echo '</nav>';
            echo '</div>';

            wp_reset_postdata();
            ?>
            <?php else : ?>
                <p><?php esc_html_e('No se encontraron entradas en esta categoría.', 'tu-tema-textdomain'); ?></p>
            <?php endif; ?>
        </div>
        <aside class="col-md-4">
            <!-- Barra lateral aquí... -->
        </aside>
    </div>
</main>

<?php get_footer(); ?>
