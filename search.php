<?php
/**
 * Search results template.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <header class="search-header">
        <h1 class="search-title"><?php printf( esc_html__( 'Search Results for: %s', 'queer-ink-theme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
