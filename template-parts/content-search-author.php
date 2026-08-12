<?php
/**
 * Search-result card for a matching Author/Writer term
 * (qi_book_author or qi_article_author). Expects $args['term'].
 *
 * @package Queer_Ink_Theme
 */

if ( empty( $args['term'] ) || ! ( $args['term'] instanceof WP_Term ) ) {
    return;
}

$qi_author_term = $args['term'];
$qi_author_link = get_term_link( $qi_author_term );

if ( is_wp_error( $qi_author_link ) ) {
    return;
}

$qi_author_taxonomy = get_taxonomy( $qi_author_term->taxonomy );
$qi_author_count    = (int) $qi_author_term->count;
?>
<article class="search-author-card">
    <a class="search-author-card__link" href="<?php echo esc_url( $qi_author_link ); ?>">
        <div class="search-author-card__icon"><?php echo queer_ink_icon( 'users' ); ?></div>
        <div class="search-author-card__body">
            <span class="search-author-card__type"><?php esc_html_e( 'Author', 'queer-ink-theme' ); ?></span>
            <h3 class="search-author-card__title"><?php echo esc_html( $qi_author_term->name ); ?></h3>
            <p class="search-author-card__meta">
                <?php
                if ( $qi_author_taxonomy && 'qi_book_author' === $qi_author_term->taxonomy ) {
                    printf(
                        /* translators: %d: number of books */
                        esc_html( _n( '%d book', '%d books', $qi_author_count, 'queer-ink-theme' ) ),
                        $qi_author_count
                    );
                } else {
                    printf(
                        /* translators: %d: number of articles */
                        esc_html( _n( '%d article', '%d articles', $qi_author_count, 'queer-ink-theme' ) ),
                        $qi_author_count
                    );
                }
                ?>
            </p>
        </div>
    </a>
</article>
