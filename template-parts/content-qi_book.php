<?php
/**
 * Book card template part.
 * Reused by the Publishing page teaser grid and, via the existing
 * template-hierarchy dispatch in archive.php/search.php/single.php,
 * by the future Books archive and single views.
 *
 * @package Queer_Ink_Theme
 */
?>
<article id="book-<?php the_ID(); ?>" <?php post_class( 'book-card' ); ?>>
    <a class="book-card__cover-link" href="<?php the_permalink(); ?>">
        <div class="book-card__cover">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'book-card__cover-img' ) ); ?>
            <?php else : ?>
                <span class="book-card__cover-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <div class="book-card__body">
        <h3 class="book-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if ( has_excerpt() ) : ?>
            <p class="book-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
    </div>
</article>
