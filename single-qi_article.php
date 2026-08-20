<?php
/**
 * Single view for the qi_article CPT — full detail page (media, section,
 * date, writer byline, full article content) instead of the compact
 * card partial single.php falls back to for post types without their
 * own single-{post_type}.php.
 *
 * @package Queer_Ink_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();

    $qi_article_sections  = get_the_terms( get_the_ID(), 'qi_article_section' );
    $qi_article_authors   = get_the_terms( get_the_ID(), 'qi_article_author' );
    // qi_subject is book-only now — qi_article_topic is the article-side
    // equivalent, shown here the same way Subjects used to be.
    $qi_article_topics    = get_the_terms( get_the_ID(), 'qi_article_topic' );
    ?>

    <main id="site-content" class="site-content container" role="main">
        <article id="article-<?php the_ID(); ?>" <?php post_class( 'qi-single-article' ); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="qi-single-article__media">
                    <?php the_post_thumbnail( 'large', array( 'class' => 'qi-single-article__media-img' ) ); ?>
                </div>
            <?php endif; ?>

            <header class="entry-header">
                <p class="qi-single-article__meta">
                    <?php if ( $qi_article_sections && ! is_wp_error( $qi_article_sections ) ) : ?>
                        <span class="qi-single-article__section"><?php echo esc_html( $qi_article_sections[0]->name ); ?></span>
                    <?php endif; ?>
                    <span class="qi-single-article__date"><?php echo esc_html( get_the_date() ); ?></span>
                </p>

                <h1 class="entry-title"><?php the_title(); ?></h1>

                <?php if ( $qi_article_authors && ! is_wp_error( $qi_article_authors ) ) : ?>
                    <p class="qi-single-article__authors">
                        <?php esc_html_e( 'By', 'queer-ink-theme' ); ?>
                        <?php
                        $qi_article_author_links = array();
                        foreach ( $qi_article_authors as $qi_article_author ) {
                            $qi_article_author_links[] = '<a href="' . esc_url( get_term_link( $qi_article_author ) ) . '">' . esc_html( $qi_article_author->name ) . '</a>';
                        }
                        echo wp_kses_post( implode( ', ', $qi_article_author_links ) );
                        ?>
                    </p>
                <?php endif; ?>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php if ( $qi_article_topics && ! is_wp_error( $qi_article_topics ) ) : ?>
                <p class="qi-single-article__tags">
                    <?php foreach ( $qi_article_topics as $qi_article_topic ) : ?>
                        <a class="qi-single-book__tag" href="<?php echo esc_url( get_term_link( $qi_article_topic ) ); ?>"><?php echo esc_html( $qi_article_topic->name ); ?></a>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <p class="qi-single-book__back">
                <a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>">&larr; <?php esc_html_e( 'Back to Journal', 'queer-ink-theme' ); ?></a>
            </p>
        </article>
    </main>

    <?php
endwhile;

get_footer();
