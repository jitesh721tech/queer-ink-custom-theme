<?php
/**
 * Archive template.
 *
 * Shared by every post type that doesn't have its own archive-{type}.php
 * (qi_book, qi_article, qi_timeline). A "Back" link is added for each,
 * pointing at its obvious parent/main page (Books -> Publishing,
 * Timeline -> Archiving, Articles -> the QI Journal page at /qi-journal/,
 * not the raw /journal/ archive itself).
 *
 * @package Queer_Ink_Theme
 */

$qi_archive_back_url   = '';
$qi_archive_back_label = '';

if ( is_post_type_archive( 'qi_timeline' ) ) {
    $qi_archive_back_url   = home_url( '/archiving/' );
    $qi_archive_back_label = __( 'Back to Archiving', 'queer-ink-theme' );
} elseif ( is_post_type_archive( 'qi_book' ) ) {
    $qi_archive_back_url   = home_url( '/publishing/' );
    $qi_archive_back_label = __( 'Back to Publishing', 'queer-ink-theme' );
} elseif ( is_post_type_archive( 'qi_article' ) ) {
    $qi_archive_back_url   = home_url( '/qi-journal/' );
    $qi_archive_back_label = __( 'Back to QI Journal', 'queer-ink-theme' );
}

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <?php if ( $qi_archive_back_url ) : ?>
        <p class="qi-page-back"><a href="<?php echo esc_url( $qi_archive_back_url ); ?>">&larr; <?php echo esc_html( $qi_archive_back_label ); ?></a></p>
    <?php endif; ?>
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
