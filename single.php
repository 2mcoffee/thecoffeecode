<?php get_header(); ?>
<?php featured_image(); ?>
<main class="pt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <?php
                while (have_posts()) : the_post();
            ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h1>
                            <?php the_title(); ?>
                        </h1>
                        <p class="small">
                            Publicado por <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="text-blog"><?php the_author(); ?></a> el <span class="text-blog"><?php the_date(); ?></span>
                            <?php if (is_user_logged_in()) : ?>
                                <?php if (is_single() && get_post_type() === 'post') : ?>
                                    <?php
                                        edit_post_link('<i class="bi bi-pencil"></i>', '', '', null, 'btn rounded btn-danger btn-sm');
                                    ?>
                                <?php elseif (is_page() && get_post_type() === 'page') : ?>
                                    <?php
                                        edit_post_link('<i class="bi bi-pencil"></i>', '', '', null, 'btn rounded btn-danger btn-sm');
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </p>
                    </header>

                    <div class="content">
                        <?php the_content(); ?>
                    </div>

                    <?php if (is_single()) : ?>
                    <p class="small">Categorías: <?php the_category(', '); ?> | Etiquetas: 
                        <?php
                        $post_tags = get_the_tags();
                        if ($post_tags) {
                            $tag_count = count($post_tags);
                            $i = 0;

                            foreach ($post_tags as $tag) {
                                echo '<span class="text-blog">' . esc_html($tag->name) . '</span>';

                                if ($i < $tag_count - 1) {
                                    echo ', ';
                                }

                                $i++;
                            }
                        }
                        ?>
                    </p>
                    <?php endif; ?>

                </article>
                <?php if (is_single()) : ?>
                <?php if (comments_open() || get_comments_number()) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endif;
            endwhile;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
