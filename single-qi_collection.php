<?php
/**
 * Single view for the qi_collection CPT — full detail page (featured
 * image, title, full content) instead of the compact card partial
 * single.php falls back to for post types without their own
 * single-{post_type}.php.
 *
 * @package Queer_Ink_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();
    ?>

    <main id="site-content" class="site-content container" role="main">
        <article id="collection-<?php the_ID(); ?>" <?php post_class( 'qi-single-book' ); ?>>
            <div class="qi-single-book__layout">
                <div class="qi-single-book__cover">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'qi-single-book__cover-img' ) ); ?>
                    <?php else : ?>
                        <span class="qi-single-book__cover-placeholder" aria-hidden="true"></span>
                    <?php endif; ?>
                </div>

                <div class="qi-single-book__body">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <p class="qi-single-book__back">
                        <a href="<?php echo esc_url( home_url( '/archiving/#connections' ) ); ?>">&larr; <?php esc_html_e( 'Back to Our Collections', 'queer-ink-theme' ); ?></a>
                    </p>
                </div>
            </div>
        </article>
    </main>

    <?php
endwhile;

get_footer();
