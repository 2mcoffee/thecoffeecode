<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ($comments_number === 1) {
                printf(esc_html__('1 Comentario'));
            } else {
                printf(
                    esc_html(_n('%s Comentarios', '%s Comentarios', $comments_number)),
                    esc_html(number_format_i18n($comments_number))
                );
            }
            ?>
        </h2>

        <ul class="comment-list">
            <?php
                wp_list_comments(array(
                    'style' => 'ul',
                    'short_ping' => true,
                    'avatar_size' => 50,
                ));
            ?>
        </ul>

        <?php
        if (!comments_open() && get_comments_number()) :
        ?>
            <p class="no-comments"><?php esc_html_e('Los comentarios se encuentran cerrados.'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
        comment_form(array(
            'class_form' => 'comment-form',
            'title_reply' => esc_html__('Dejar un Comentario:'),
            'comment_notes_before' => '',
            'comment_field' => '<div class="form-group mb-2">
                <label for="comment" class="sr-only">' . esc_html__('Comentario:') . '</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
            </div>',
            'class_submit' => 'btn btn-outline-blog',
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' =>
                    '<div class="form-group mb-2">' .
                    '<label for="author" class="sr-only">' . esc_html__('Nombre:') . '</label> ' .
                    '<input id="author" name="author" type="text" class="form-control" placeholder="' . esc_attr__('Nombre') . '" ' . ($req ? 'required' : '') . '>' .
                    '</div>',

                'email' =>
                    '<div class="form-group mb-2">' .
                    '<label for="email" class="sr-only">' . esc_html__('Correo Electrónico:') . '</label> ' .
                    '<input id="email" name="email" type="email" class="form-control" placeholder="' . esc_attr__('Correo Electrónico') . '" ' . ($req ? 'required' : '') . '>' .
                    '</div>',

                'url' =>
                    '<div class="form-group mb-2">' .
                    '<label for="url" class="sr-only">' . esc_html__('Sitio Web:') . '</label> ' .
                    '<input id="url" name="url" type="url" class="form-control" placeholder="' . esc_attr__('Sitio Web') . '">' .
                    '</div>',
            )),
        ));
    ?>

</div>