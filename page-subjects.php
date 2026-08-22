<?php
/**
 * Template for the "Subjects" page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "subjects" — no manual template assignment needed.
 * Reuses template-parts/content-page.php (the generic page content
 * partial) and the .qi-page-back component; only the extra
 * body.page-id-147-scoped CSS in digital-library.css widens/centers the
 * listing itself.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <p class="qi-page-back"><a href="<?php echo esc_url( home_url( '/digital-library/' ) ); ?>">&larr; <?php esc_html_e( 'Back to Digital Library', 'queer-ink-theme' ); ?></a></p>
        <?php
        get_template_part( 'template-parts/content', 'page' );
    endwhile;
    ?>
</main>

<?php get_footer();
