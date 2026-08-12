<?php
/**
 * Search results template.
 *
 * Combines the native WP_Query post search (Books, Articles, Pages, and
 * any other public post type — relevance-ordered via the posts_clauses
 * filter in inc/search.php) with a lookup of matching Author/Writer
 * taxonomy terms, since WP_Query's 's' parameter only searches post
 * fields and can't match a taxonomy term name.
 *
 * @package Queer_Ink_Theme
 */

get_header();

global $wp_query;

$qi_search_query     = get_search_query();
$qi_query_is_empty   = ( '' === trim( $qi_search_query ) );
$qi_matching_authors = $qi_query_is_empty ? array() : queer_ink_get_matching_authors( $qi_search_query );
$qi_has_posts        = have_posts();
$qi_total_results    = (int) $wp_query->found_posts + count( $qi_matching_authors );
?>

<main id="site-content" class="site-content container" role="main">
    <header class="search-header">
        <h1 class="search-title">
            <?php if ( $qi_query_is_empty ) : ?>
                <?php esc_html_e( 'Search Queer Ink', 'queer-ink-theme' ); ?>
            <?php else : ?>
                <?php
                printf(
                    /* translators: %s: the visitor's search query */
                    esc_html__( 'Search results for "%s"', 'queer-ink-theme' ),
                    '<span>' . esc_html( $qi_search_query ) . '</span>'
                );
                ?>
            <?php endif; ?>
        </h1>
        <?php if ( ! $qi_query_is_empty ) : ?>
            <p class="search-meta">
                <?php
                printf(
                    /* translators: %d: number of results found */
                    esc_html( _n( '%d result found', '%d results found', $qi_total_results, 'queer-ink-theme' ) ),
                    $qi_total_results
                );
                ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if ( $qi_query_is_empty ) : ?>

        <section class="search-empty-state">
            <p><?php esc_html_e( 'Enter a keyword above to search across Books, Articles, Pages, and Authors.', 'queer-ink-theme' ); ?></p>
        </section>

    <?php elseif ( ! $qi_has_posts && ! $qi_matching_authors ) : ?>

        <section class="search-no-results">
            <h2><?php esc_html_e( 'No results found', 'queer-ink-theme' ); ?></h2>
            <p>
                <?php
                printf(
                    /* translators: %s: the visitor's search query */
                    esc_html__( 'We couldn\'t find anything matching "%s". Try a different keyword, or explore:', 'queer-ink-theme' ),
                    '<strong>' . esc_html( $qi_search_query ) . '</strong>'
                );
                ?>
            </p>
            <div class="search-no-results__links">
                <a class="button button--outline" href="<?php echo esc_url( home_url( '/books/' ) ); ?>"><?php esc_html_e( 'Browse Books', 'queer-ink-theme' ); ?></a>
                <a class="button button--outline" href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Browse Articles', 'queer-ink-theme' ); ?></a>
                <a class="button button--outline" href="<?php echo esc_url( home_url( '/digital-library/' ) ); ?>"><?php esc_html_e( 'Visit the Digital Library', 'queer-ink-theme' ); ?></a>
            </div>
        </section>

    <?php else : ?>

        <?php if ( $qi_matching_authors ) : ?>
            <section class="search-authors" aria-labelledby="search-authors-title">
                <h2 id="search-authors-title" class="search-section-title"><?php esc_html_e( 'Authors', 'queer-ink-theme' ); ?></h2>
                <div class="search-authors__grid">
                    <?php foreach ( $qi_matching_authors as $qi_author_term ) : ?>
                        <?php get_template_part( 'template-parts/content-search-author', null, array( 'term' => $qi_author_term ) ); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( $qi_has_posts ) : ?>
            <section class="search-results" aria-labelledby="search-results-title">
                <?php if ( $qi_matching_authors ) : ?>
                    <h2 id="search-results-title" class="search-section-title"><?php esc_html_e( 'Results', 'queer-ink-theme' ); ?></h2>
                <?php endif; ?>
                <div class="search-results__grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content-search-result' );
                    endwhile;
                    ?>
                </div>
                <?php
                the_posts_pagination( array(
                    'mid_size'  => 1,
                    'prev_text' => esc_html__( '← Previous', 'queer-ink-theme' ),
                    'next_text' => esc_html__( 'Next →', 'queer-ink-theme' ),
                ) );
                ?>
            </section>
        <?php endif; ?>

    <?php endif; ?>
</main>

<?php get_footer();
