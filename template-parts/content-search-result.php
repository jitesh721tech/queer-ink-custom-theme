<?php
/**
 * Unified search-result card. Works for any public post type (Book,
 * Article, Page, native Post) so search.php doesn't have to dispatch to
 * each post type's own card design — every result reads consistently
 * regardless of content type.
 *
 * @package Queer_Ink_Theme
 */

$qi_result_type = queer_ink_search_result_type_label( get_post() );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-card' ); ?>>
    <a class="search-result-card__media-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <div class="search-result-card__media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'search-result-card__media-img' ) ); ?>
            <?php else : ?>
                <span class="search-result-card__media-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <div class="search-result-card__body">
        <span class="search-result-card__type"><?php echo esc_html( $qi_result_type ); ?></span>
        <h3 class="search-result-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="search-result-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
        <a class="search-result-card__link" href="<?php the_permalink(); ?>">
            <?php esc_html_e( 'View', 'queer-ink-theme' ); ?> <?php echo esc_html( $qi_result_type ); ?> →
        </a>
    </div>
</article>
