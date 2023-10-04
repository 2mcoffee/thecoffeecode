<?php get_header(); ?>

<main>
    <section>
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <?php
            $sticky_posts = get_option('sticky_posts');

            
            if ($sticky_posts) {
                
                $latest_sticky_post = get_post(end($sticky_posts));

                if ($latest_sticky_post) {
                    $post_title = get_the_title($latest_sticky_post);
                    $post_excerpt = wp_trim_words(get_the_excerpt($latest_sticky_post), 30);
                    $post_link = get_permalink($latest_sticky_post);
                    ?>
                    <div class="col-lg-6 px-0">
                        <h1 class="display-4 fst-italic"><?php echo esc_html($post_title); ?></h1>
                        <p class="lead my-3"><?php echo esc_html($post_excerpt); ?></p>
                        <p class="lead mb-0"><a href="<?php echo esc_url($post_link); ?>" class="btn btn-outline-blog">Leer más <i class="bi bi-arrow-right-square-fill strong"></i></a></p>
                    </div>
                    <?php
                } else {
                    echo '<p>No se encontraron entradas fijadas.</p>';
                }
            } else {
                echo '<p>No se encontraron entradas fijadas.</p>';
            }
            ?>
        </div>
    </section>

    <section>
        <div class="row row-cols-1 row-cols-sm-2 g-2 mb-4">
            <?php
            
            $posts_per_page = 10;

            $total_posts = wp_count_posts()->publish;

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            $offset = ($paged - 1) * $posts_per_page;

            $total_pages = ceil(($total_posts - count($sticky_posts)) / $posts_per_page);

            $args = array(
                'posts_per_page' => $posts_per_page,
                'orderby' => 'date',
                'order' => 'DESC',
                'offset' => $offset,
                'post__not_in' => $sticky_posts,
            );

            $posts_query = new WP_Query($args);

            if ($posts_query->have_posts()) :
                while ($posts_query->have_posts()) :
                    $posts_query->the_post();

                    $categories = get_the_category();
                    $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Sin categoría';
                    $post_title = get_the_title();
                    $post_date = get_the_date();
                    $post_author = get_the_author();
                    $post_excerpt = wp_trim_words(get_the_excerpt(), 20);
                    $post_link = get_permalink();
                    ?>

                    <div class="col col-sm-6">
                        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative h-100">
                            <div class="col p-4 d-flex flex-column position-static">
                                <strong class="d-inline-block mb-2 text-primary-emphasis text-blog"><?php echo esc_html($category_name); ?></strong>
                                <h3 class="mb-0"><?php echo esc_html($post_title); ?></h3>
                                <div class="mb-1 text-body-secondary small">Publicado por <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-blog"><?php the_author(); ?></a> el <?php the_time('d/m/Y'); ?></div>
                                <p class="mb-auto"><?php echo esc_html($post_excerpt); ?></p>
                                <a href="<?php echo esc_url($post_link); ?>" class="text-blog">Leer más <i class="bi bi-arrow-right-square"></i></a>
                            </div>
                            <div class="col-auto d-none d-lg-block">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('thumbnail', array('class' => 'bd-placeholder-img'));
                                } else {
                                    echo '<img src="'.get_template_directory_uri().'/img/no-image.jpg" class="bd-placeholder-img" alt="Thumbnail">';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

            <?php
                endwhile;
            ?>
        </div>
        <div class="row mb-4">
            <?php

                echo '<div class="col-12">';
                echo '<nav aria-label="Page navigation example">';
                echo '<ul class="pagination pagination-custom justify-content-center">';

                if ($paged > 1) {
                    echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged - 1)) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&laquo;</span></li>';
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $paged) {
                        echo '<li class="page-item active"><span class="page-link">' . esc_html($i) . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($i)) . '">' . esc_html($i) . '</a></li>';
                    }
                }

                if ($paged < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="' . esc_url(get_pagenum_link($paged + 1)) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                } else {
                    echo '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&raquo;</span></li>';
                }

                echo '</ul>';
                echo '</nav>';
                echo '</div>';

                wp_reset_postdata();
            else :
                echo 'No se encontraron posts.';
            endif;
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
