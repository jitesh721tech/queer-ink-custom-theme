<?php
/**
 * Template for the "About QI Journal" page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "about-qi-journal" — no manual template assignment
 * needed. See template-parts/content-page-boxed.php for the shared
 * boxed layout + single "Back" link.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content-page-boxed', null, array(
            'back_url'   => home_url( '/qi-journal/' ),
            'back_label' => esc_html__( 'Back to QI Journal', 'queer-ink-theme' ),
        ) );
    endwhile;
    ?>
</main>

<?php get_footer();
