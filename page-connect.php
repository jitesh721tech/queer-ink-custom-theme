<?php
/**
 * Template for the Connect landing page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "connect" — no manual template assignment needed.
 *
 * Deliberately renders the_content() directly (no generic entry-header/
 * title band) because the page's block content supplies its own hero
 * heading — see inc/block-patterns.php for the editable building blocks.
 * The closing "Stay in the Loop" band reuses the same channel-band
 * template part as the homepage instead of duplicating it.
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
    <?php get_template_part( 'template-parts/section', 'channel-band' ); ?>
</main>

<?php get_footer();
