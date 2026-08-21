<?php
/**
 * Front page template.
 *
 * Renders the static front page's own post content (edited from
 * wp-admin -> Pages -> Home) instead of hardcoded template parts, matching
 * the page-{slug}.php convention used by Publishing/Archiving/etc. — see
 * inc/block-patterns.php for how bespoke section markup stays editable via
 * Custom HTML blocks.
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
