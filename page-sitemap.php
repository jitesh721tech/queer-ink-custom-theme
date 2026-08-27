<?php
/**
 * Template for the visitor-facing HTML Sitemap page.
 * Matched automatically by the WordPress template hierarchy for the
 * page with slug "sitemap" (already existed, empty, at /sitemap/) — no
 * manual template assignment needed.
 *
 * This is a human-facing navigation aid only. It has nothing to do with
 * Rank Math's XML sitemap (sitemap_index.xml etc.), which is untouched.
 *
 * Content is entirely template-driven rather than the_content()-based,
 * since most of it must reflect live, published data (taxonomy terms,
 * Collections) rather than editable post content. Static entries (Main
 * Pages, and the Publishing/Archiving/QI Journal sub-pages) are the
 * theme's own known, permanent URLs; every dynamic list below is built
 * with get_terms()/WP_Query filtered to publish/hide_empty so drafts,
 * private, trashed or empty-term content can never appear.
 *
 * @package Queer_Ink_Theme
 */

get_header();

/**
 * get_terms() with hide_empty => true already excludes terms with no
 * published posts attached, so an empty result here means "nothing to
 * link yet" rather than "drafts exist" — the section is simply omitted.
 */
$queer_ink_sitemap_book_authors   = get_terms( array( 'taxonomy' => 'qi_book_author', 'hide_empty' => true ) );
$queer_ink_sitemap_article_authors = get_terms( array( 'taxonomy' => 'qi_article_author', 'hide_empty' => true ) );
$queer_ink_sitemap_sections       = get_terms( array( 'taxonomy' => 'qi_article_section', 'hide_empty' => true ) );
$queer_ink_sitemap_topics         = get_terms( array( 'taxonomy' => 'qi_article_topic', 'hide_empty' => true ) );

$queer_ink_sitemap_collections = get_posts( array(
    'post_type'      => 'qi_collection',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
) );

/**
 * Renders one <ul> of term links, or nothing at all if the list is empty
 * (is_wp_error() also short-circuits to nothing rather than a PHP notice).
 */
if ( ! function_exists( 'queer_ink_sitemap_term_list' ) ) {
    function queer_ink_sitemap_term_list( $terms ) {
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return;
        }
        echo '<ul>';
        foreach ( $terms as $term ) {
            printf(
                '<li><a href="%1$s">%2$s</a></li>',
                esc_url( get_term_link( $term ) ),
                esc_html( $term->name )
            );
        }
        echo '</ul>';
    }
}
?>

<main id="site-content" class="site-content container qi-sitemap" role="main">

    <p class="qi-page-back">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" data-qi-smart-back>&larr; <?php esc_html_e( 'Back', 'queer-ink-theme' ); ?></a>
    </p>

    <header class="entry-header qi-sitemap__header">
        <h1 class="entry-title"><?php esc_html_e( 'Sitemap', 'queer-ink-theme' ); ?></h1>
        <p class="qi-sitemap__intro">
            <?php esc_html_e( 'A complete overview of Queer Ink\'s public pages — organised by section, and updated automatically as new content is published.', 'queer-ink-theme' ); ?>
        </p>
    </header>

    <nav class="qi-sitemap__grid" aria-label="<?php esc_attr_e( 'Sitemap', 'queer-ink-theme' ); ?>">

        <div class="qi-sitemap__column">
            <h2><?php esc_html_e( 'Main Pages', 'queer-ink-theme' ); ?></h2>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/publishing/' ) ); ?>"><?php esc_html_e( 'Publishing', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/archiving/' ) ); ?>"><?php esc_html_e( 'Archiving', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/digital-library/' ) ); ?>"><?php esc_html_e( 'Digital Library', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/qi-journal/' ) ); ?>"><?php esc_html_e( 'QI Journal', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/connect/' ) ); ?>"><?php esc_html_e( 'Connect', 'queer-ink-theme' ); ?></a></li>
            </ul>
        </div>

        <div class="qi-sitemap__column">
            <h2><?php esc_html_e( 'Digital Library & Publishing', 'queer-ink-theme' ); ?></h2>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/books/' ) ); ?>"><?php esc_html_e( 'Books', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/subjects/' ) ); ?>"><?php esc_html_e( 'Browse by Subjects', 'queer-ink-theme' ); ?></a></li>
            </ul>
            <?php if ( ! empty( $queer_ink_sitemap_book_authors ) && ! is_wp_error( $queer_ink_sitemap_book_authors ) ) : ?>
                <h3><?php esc_html_e( 'Authors', 'queer-ink-theme' ); ?></h3>
                <?php queer_ink_sitemap_term_list( $queer_ink_sitemap_book_authors ); ?>
            <?php endif; ?>
        </div>

        <div class="qi-sitemap__column">
            <h2><?php esc_html_e( 'Archiving', 'queer-ink-theme' ); ?></h2>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/timeline/' ) ); ?>"><?php esc_html_e( 'Timeline', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/our-principles/' ) ); ?>"><?php esc_html_e( 'Our Principles', 'queer-ink-theme' ); ?></a></li>
            </ul>
            <?php if ( ! empty( $queer_ink_sitemap_collections ) ) : ?>
                <h3><?php esc_html_e( 'Collections', 'queer-ink-theme' ); ?></h3>
                <ul>
                    <?php foreach ( $queer_ink_sitemap_collections as $queer_ink_collection ) : ?>
                        <li><a href="<?php echo esc_url( get_permalink( $queer_ink_collection ) ); ?>"><?php echo esc_html( get_the_title( $queer_ink_collection ) ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="qi-sitemap__column">
            <h2><?php esc_html_e( 'QI Journal', 'queer-ink-theme' ); ?></h2>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Articles', 'queer-ink-theme' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/about-qi-journal/' ) ); ?>"><?php esc_html_e( 'About QI Journal', 'queer-ink-theme' ); ?></a></li>
            </ul>
            <?php if ( ! empty( $queer_ink_sitemap_sections ) && ! is_wp_error( $queer_ink_sitemap_sections ) ) : ?>
                <h3><?php esc_html_e( 'Categories', 'queer-ink-theme' ); ?></h3>
                <?php queer_ink_sitemap_term_list( $queer_ink_sitemap_sections ); ?>
            <?php endif; ?>
            <?php if ( ! empty( $queer_ink_sitemap_topics ) && ! is_wp_error( $queer_ink_sitemap_topics ) ) : ?>
                <h3><?php esc_html_e( 'Topics', 'queer-ink-theme' ); ?></h3>
                <?php queer_ink_sitemap_term_list( $queer_ink_sitemap_topics ); ?>
            <?php endif; ?>
            <?php if ( ! empty( $queer_ink_sitemap_article_authors ) && ! is_wp_error( $queer_ink_sitemap_article_authors ) ) : ?>
                <h3><?php esc_html_e( 'Writers', 'queer-ink-theme' ); ?></h3>
                <?php queer_ink_sitemap_term_list( $queer_ink_sitemap_article_authors ); ?>
            <?php endif; ?>
        </div>

    </nav>

</main>

<?php get_footer();
