<?php
/**
 * Single view for the qi_timeline CPT — full detail page (year, featured
 * image, title, full content) instead of the compact card partial
 * single.php falls back to for post types without their own
 * single-{post_type}.php. Reuses the .qi-single-book layout/CSS
 * (single-content.css) since the shape (image + title + tag + content +
 * back link) is identical — no new CSS needed for this template.
 *
 * @package Queer_Ink_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();

    $qi_timeline_year = get_post_meta( get_the_ID(), '_qi_timeline_year', true );
    ?>

    <main id="site-content" class="site-content container" role="main">
        <article id="timeline-<?php the_ID(); ?>" <?php post_class( 'qi-single-book' ); ?>>
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

                        <?php if ( $qi_timeline_year ) : ?>
                            <p class="qi-single-book__meta">
                                <span class="qi-single-book__tag"><?php echo esc_html( $qi_timeline_year ); ?></span>
                            </p>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <p class="qi-single-book__back">
                        <a href="<?php echo esc_url( home_url( '/archiving/#timeline' ) ); ?>">&larr; <?php esc_html_e( 'Back to Our Journey Through Time', 'queer-ink-theme' ); ?></a>
                    </p>
                </div>
            </div>
        </article>
    </main>

    <?php
endwhile;

get_footer();
