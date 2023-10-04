<?php
get_header();
?>

<main>
    <div class="author-profile-instagram pt-4 mb-4">
        <?php
            $current_author = get_userdata(get_query_var('author'));
        ?>
        <div class="profile-header">
            <div class="profile-avatar">
                <?php
                    echo get_avatar($current_author->ID, 150, '', '', array('class' => array('img-fluid', 'rounded-circle')));
                ?>
            </div>
            <div class="profile-info">
                <h1><?php echo esc_html($current_author->first_name . ' ' . $current_author->last_name . ' (' . $current_author->user_nicename . ')'); ?></h1>
                <?php
                    $author_id = get_the_author_meta('ID');
                    $author_post_count = count_user_posts($author_id);
                    $author_comment_count = get_comments(array('user_id' => $author_id, 'count' => true));

                    echo '<p class="post-count"><i class="bi bi-stickies"></i> Entradas: ' . $author_post_count . ' | <i class="bi bi-chat"></i> Comentarios: ' . $author_comment_count . '</p>';
                ?>
            </div>
        </div>

        <?php
            if (!empty($current_author->description)) {
                echo '<p class="bio">' . esc_html($current_author->description) . '</p>';
            }
        ?>
    </div>

    <section>
        <div class="mb-3">
            <h3 class="fw-light"><?php _e('Entradas escritas por'); ?> <?php echo esc_html($current_author->first_name . ' ' . $current_author->last_name).':'; ?></h3>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 g-2 mb-4">
            <?php
            $posts_per_page = 10;

            $total_posts = wp_count_posts()->publish;

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            $offset = ($paged - 1) * $posts_per_page;

            $total_pages = ceil($total_posts / $posts_per_page);

            $args = array(
                'posts_per_page' => $posts_per_page,
                'orderby' => 'date',
                'order' => 'DESC',
                'offset' => $offset,
                'author' => $current_author->ID,
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
                                <div class="mb-1 text-body-secondary"><?php echo esc_html($post_date . ' por ' . $post_author); ?></div>
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
