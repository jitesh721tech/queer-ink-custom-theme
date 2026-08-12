<?php
/**
 * Article card template part.
 * Reused by the Publishing page teaser grid and, via the existing
 * template-hierarchy dispatch in archive.php/search.php/single.php,
 * by the future Journal archive and single views.
 *
 * @package Queer_Ink_Theme
 */
?>
<article id="article-<?php the_ID(); ?>" <?php post_class( 'article-card' ); ?>>
    <a class="article-card__media-link" href="<?php the_permalink(); ?>">
        <div class="article-card__media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium_large', array( 'class' => 'article-card__media-img' ) ); ?>
            <?php else : ?>
                <span class="article-card__media-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <div class="article-card__body">
        <?php
        $qi_sections = get_the_terms( get_the_ID(), 'qi_article_section' );
        if ( $qi_sections && ! is_wp_error( $qi_sections ) ) :
            ?>
            <p class="article-card__meta">
                <span class="article-card__section"><?php echo esc_html( $qi_sections[0]->name ); ?></span>
                <span class="article-card__date"><?php echo esc_html( get_the_date() ); ?></span>
            </p>
        <?php else : ?>
            <p class="article-card__meta">
                <span class="article-card__date"><?php echo esc_html( get_the_date() ); ?></span>
            </p>
        <?php endif; ?>
        <h3 class="article-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php
        $qi_article_authors = get_the_terms( get_the_ID(), 'qi_article_author' );
        if ( $qi_article_authors && ! is_wp_error( $qi_article_authors ) ) :
            ?>
            <p class="article-card__author">
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
        <?php if ( has_excerpt() ) : ?>
            <p class="article-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
        <a class="article-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'queer-ink-theme' ); ?> →</a>
    </div>
</article>
