<?php
/**
 * Archive template.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <header class="archive-header">
        <h1 class="archive-title"><?php the_archive_title(); ?></h1>
        <div class="archive-description"><?php the_archive_description(); ?></div>
    </header>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content', get_post_type() );
        endwhile;
        the_posts_pagination();
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif;
    ?>
</main>

<?php get_footer();
