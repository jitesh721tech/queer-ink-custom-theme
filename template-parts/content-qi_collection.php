<?php
/**
 * Collection card template part.
 * Reused by the Archiving page's "Our Collections" section (via the
 * [qi_collections] shortcode) and, via the existing template-hierarchy
 * dispatch in archive.php/search.php/single.php, by any other future
 * listing of qi_collection posts.
 *
 * @package Queer_Ink_Theme
 */
?>
<article id="collection-<?php the_ID(); ?>" <?php post_class( 'qi-collection-card' ); ?>>
    <a class="qi-collection-card__media-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <div class="qi-collection-card__media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'qi-collection-card__media-img' ) ); ?>
            <?php else : ?>
                <span class="qi-collection-card__media-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <h3 class="qi-collection-card__title">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <?php if ( has_excerpt() ) : ?>
        <p class="qi-collection-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
    <a class="qi-collection-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Explore', 'queer-ink-theme' ); ?> →</a>
</article>
