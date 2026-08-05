<?php
/**
 * Single post template.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', get_post_type() );
    endwhile;
    ?>
</main>

<?php get_footer();
