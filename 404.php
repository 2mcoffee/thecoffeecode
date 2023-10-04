<?php
    get_header();
?>

<main>
    <div class="container">
        <div class="text-center">
            <h1>¡Error 404!</h1>
            <p>Parece que has llegado a un callejón sin salida.</p>
            <p>No te preocupes, incluso los astronautas se pierden de vez en cuando.</p>
            <img src="<?php echo get_template_directory_uri(); ?>/img/404-astro.png" alt="Astronauta perdido" class="img-astro img-fluid img-unselectable">
            <p>¿Qué tal si volvemos a <a href="<?php echo esc_url(home_url('/')); ?>">casa</a> o intentamos buscar algo más emocionante?</p>
        </div>
    </div>
</main>

<?php
    get_footer();
?>