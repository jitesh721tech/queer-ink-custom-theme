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
        $qi_topics   = get_the_terms( get_the_ID(), 'qi_article_topic' );
        $qi_has_section = $qi_sections && ! is_wp_error( $qi_sections );
        $qi_has_topics  = $qi_topics && ! is_wp_error( $qi_topics );
        if ( $qi_has_section || $qi_has_topics ) :
            ?>
            <p class="article-card__taxonomy">
                <?php if ( $qi_has_section ) : ?>
                    <a class="article-card__section" href="<?php echo esc_url( get_term_link( $qi_sections[0] ) ); ?>"><?php echo esc_html( $qi_sections[0]->name ); ?></a>
                <?php endif; ?>
                <?php if ( $qi_has_topics ) : ?>
                    <?php foreach ( $qi_topics as $qi_topic ) : ?>
                        <a class="article-card__topic" href="<?php echo esc_url( get_term_link( $qi_topic ) ); ?>"><?php echo esc_html( $qi_topic->name ); ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
        <h3 class="article-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="article-card__byline">
            <?php
            $qi_article_authors = get_the_terms( get_the_ID(), 'qi_article_author' );
            if ( $qi_article_authors && ! is_wp_error( $qi_article_authors ) ) :
                $qi_article_author_links = array();
                foreach ( $qi_article_authors as $qi_article_author ) {
                    $qi_article_author_links[] = '<a href="' . esc_url( get_term_link( $qi_article_author ) ) . '">' . esc_html( $qi_article_author->name ) . '</a>';
                }
                echo wp_kses_post( esc_html__( 'By', 'queer-ink-theme' ) . ' ' . implode( ', ', $qi_article_author_links ) );
                ?>
                <span class="article-card__byline-sep" aria-hidden="true">·</span>
            <?php endif; ?>
            <span class="article-card__date"><?php echo esc_html( get_the_date() ); ?></span>
        </p>
        <?php
        $qi_article_excerpt = get_the_excerpt();
        if ( $qi_article_excerpt ) :
            ?>
            <p class="article-card__excerpt"><?php echo esc_html( $qi_article_excerpt ); ?></p>
        <?php endif; ?>
        <a class="article-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'queer-ink-theme' ); ?> →</a>
    </div>
</article>
