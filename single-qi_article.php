<?php
/**
 * Single view for the qi_article CPT — full detail page (media, section,
 * date, writer byline, full article content) instead of the compact
 * card partial single.php falls back to for post types without their
 * own single-{post_type}.php. Reuses the .qi-single-book layout/CSS
 * (single-content.css) — the same sticky image column + body column
 * shape as single-qi_timeline.php — so image sizing and sticky-scroll
 * behavior stay identical across both without duplicating any CSS.
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
        <article id="article-<?php the_ID(); ?>" <?php post_class( 'qi-single-book' ); ?>>
            <p class="qi-single-book__back qi-single-book__back--top">
                <a href="<?php echo esc_url( home_url( '/qi-journal/' ) ); ?>">&larr; <?php esc_html_e( 'Back to QI Journal', 'queer-ink-theme' ); ?></a>
            </p>
            <div class="qi-single-book__layout">
                <div class="qi-single-book__cover">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'qi-single-book__cover-img' ) ); ?>
                    <?php else : ?>
                        <span class="qi-single-book__cover-placeholder" aria-hidden="true"></span>
                    <?php endif; ?>

                    <?php if ( $qi_article_sections && ! is_wp_error( $qi_article_sections ) ) : ?>
                        <p class="qi-single-article__meta">
                            <span class="qi-single-article__section"><?php echo esc_html( $qi_article_sections[0]->name ); ?></span>
                        </p>
                    <?php endif; ?>

                    <?php if ( $qi_article_topics && ! is_wp_error( $qi_article_topics ) ) : ?>
                        <p class="qi-single-article__tags">
                            <?php foreach ( $qi_article_topics as $qi_article_topic ) : ?>
                                <a class="qi-single-book__tag" href="<?php echo esc_url( get_term_link( $qi_article_topic ) ); ?>"><?php echo esc_html( $qi_article_topic->name ); ?></a>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="qi-single-book__body">
                    <header class="entry-header">
                        <p class="qi-single-article__meta">
                            <span class="qi-single-article__date"><?php echo esc_html( get_the_date() ); ?></span>
                        </p>

                        <h1 class="entry-title"><?php the_title(); ?></h1>

                        <?php if ( $qi_article_sections && ! is_wp_error( $qi_article_sections ) ) : ?>
                            <p class="qi-single-article__taxonomy-line">
                                <span class="qi-single-article__taxonomy-label"><?php esc_html_e( 'Category', 'queer-ink-theme' ); ?></span> — <?php echo esc_html( $qi_article_sections[0]->name ); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( $qi_article_topics && ! is_wp_error( $qi_article_topics ) ) : ?>
                            <p class="qi-single-article__taxonomy-line">
                                <span class="qi-single-article__taxonomy-label"><?php esc_html_e( 'Topic', 'queer-ink-theme' ); ?></span> — <?php echo esc_html( implode( ', ', wp_list_pluck( $qi_article_topics, 'name' ) ) ); ?>
                            </p>
                        <?php endif; ?>

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
                </div>
            </div>
        </article>
    </main>

    <?php
endwhile;

get_footer();
