<?php
/**
 * Template for the About landing page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "about" — no manual template assignment needed.
 *
 * Deliberately renders the_content() directly (no generic entry-header/
 * title band) because the page's block content supplies its own hero
 * heading — see inc/block-patterns.php for the editable building blocks.
 *
 * The closing "Stay in the loop" band reuses the same channel-band
 * template part as the homepage (front-page.php) instead of a separate
 * block-content copy, so both stay pixel-identical by construction.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    get_template_part( 'template-parts/section', 'channel-band' );
    ?>
</main>

<?php get_footer();
