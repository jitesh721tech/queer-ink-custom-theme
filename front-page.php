<?php
/**
 * Front page template.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php get_template_part( 'template-parts/section', 'hero' ); ?>
    <?php get_template_part( 'template-parts/section', 'feature-strip' ); ?>
    <?php get_template_part( 'template-parts/section', 'channel-band' ); ?>
</main>

<?php get_footer();
