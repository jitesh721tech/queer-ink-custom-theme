<?php
/**
 * Template for the Digital Library landing page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "digital-library" — no manual template assignment needed.
 *
 * Deliberately renders the_content() directly (no generic entry-header/
 * title band) because the page's block content supplies its own hero
 * heading — see inc/block-patterns.php for the editable building blocks.
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
    ?>
</main>

<?php get_footer();
