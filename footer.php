        <footer>
            <div class="copyright mb-4">
                <div class="mb-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/logo-min.png" class="img-fluid img-footer img-unselectable" alt="THE COFFEE CODE">
                </div>
                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <div class="mb-4">
                        The Coffee Code es un rincón virtual donde la expresión libre y la diversión se encuentran para satirizar los problemas cotidianos que todos enfrentamos. Aquí, no hay límites para la creatividad, y estamos listos para compartir historias, aventuras, música, videos, podcasts, líneas de código y mucho más.
                        </div>
                        <div class="social mb-2">
                            <?php custom_social_links(); ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-2 mb-2">
                        <div class="text-uppercase mb-2 title">
                            Páginas
                        </div>
                        <div>
                            <?php
                            $args = array(
                                'post_type' => 'page',
                                'posts_per_page' => -1,
                                'order' => 'ASC',
                                'orderby' => 'title',
                            );

                            $pages_query = new WP_Query($args);

                            if ($pages_query->have_posts()) :
                                while ($pages_query->have_posts()) :
                                    $pages_query->the_post();
                                    ?>
                                    <a class="footer-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><br>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-2 mb-2">
                        <div class="text-uppercase mb-2 title">
                            Posts
                        </div>
                        <div>
                            <?php
                            $args = array(
                                'posts_per_page' => 4,
                                'orderby' => 'date',
                                'order' => 'DESC',
                            );
                            $recent_posts = get_posts($args);

                            foreach ($recent_posts as $post) {
                                setup_postdata($post);
                                $post_title = get_the_title();
                                $post_title_short = (strlen($post_title) > 20) ? substr($post_title, 0, 20) . '...' : $post_title; // Acortar a 20 caracteres
                                $post_link = get_permalink();
                                echo '<a class="footer-link" href="' . esc_url($post_link) . '" title="' . esc_attr($post_title) . '">' . esc_html($post_title_short) . '</a>';
                                echo '<br>';
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-2 mb-2">
                        <div class="text-uppercase mb-2 title">
                            Categorias
                        </div>
                        <div>
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'number' => 4,
                            ));

                            foreach ($categories as $category) {
                                $category_name = $category->name;
                                $category_link = get_category_link($category->term_id);
                                echo '<a class="footer-link" href="' . esc_url($category_link) . '" title="' . esc_attr($category_name) . '">' . esc_html($category_name) . '</a>';
                                echo '<br>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-6 col-sm-2 mb-2">
                        <div class="text-uppercase mb-2 title">
                            Meta
                        </div>
                        <div>
                            <?php
                                if (is_user_logged_in()) {
                                    $dashboard_link = admin_url();
                                    echo '<a class="footer-link" href="' . esc_url($dashboard_link) . '" title="Mi Cuenta">Mi Cuenta</a>';
                                } else {
                                    $login_link = wp_login_url();
                                    echo '<a class="footer-link" href="' . esc_url($login_link) . '" title="Iniciar Sesión">Iniciar Sesión</a>';
                                }
                            ?>
                            <br>
                            <a class="footer-link" href="<?php echo wp_registration_url(); ?>" title="Registrarse">Registrarse</a>
                            <br>
                            <a class="footer-link" href="<?php echo wp_lostpassword_url(); ?>" title="Cambiar clave">Cambiar clave</a>
                            <br>
                            <?php
                                if (is_user_logged_in()) {
                                    $logout_link = wp_logout_url(home_url('/'));
                                    echo '<a class="footer-link" href="' . esc_url($logout_link) . '" title="Salir">Salir</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <hr class="mb-2">
                <div>
                    <strong><small>Copyright &copy; <?php echo date("Y"); ?> | Desarrollado por Luciano Alfonsin utilizando <a rel="noopener" href="https://wordpress.org/" target="_blank" title="Wordpress"><i class="bi bi-wordpress"></i></a></small></strong>
                </div>   
            </div>
        </footer>
    </div>
    
<?php wp_footer(); ?>
<a class="search shadow-sm" data-bs-toggle="modal" data-bs-target="#searchModal"> <i class="bi bi-search"></i></a>
<script>
    $(document).ready(function(){
        $(window).scroll(function () {
            $('.search').fadeIn();
                if($(this).scrollTop()==0){
                $('.search').fadeOut();
            }
        });
    });
</script>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
            <h1 class="fw-bold mb-0 fs-2">Buscar entradas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-5 pt-0">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="form-floating mb-3">
                    <input type="search" name="s" id="search-input" class="form-control rounded-3" value="<?php echo get_search_query(); ?>" placeholder="Buscar..." >
                    <label for="floatingInput">Buscar</label>
                </div>
                <button type="submit" class="btn btn-outline-blog">Buscar</button>
                <small class="text-body-secondary">¡Buena suerte! <i class="bi bi-stars"></i></small>
            </form>
        </div>
    </div>
  </div>
</div>





</body>
</html>