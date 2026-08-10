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
        <h3 class="article-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if ( has_excerpt() ) : ?>
            <p class="article-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
    </div>
</article>
