<?php
/**
 * Timeline entry card template part — used by the /timeline/ archive
 * (the "View Full Timeline" list) via the shared template-hierarchy
 * dispatch in archive.php/search.php/single.php. The homepage-embedded
 * horizontal timeline widget on the Archiving page uses its own card
 * markup (see queer_ink_timeline_entries_shortcode() in
 * inc/shortcodes.php) since that widget's design (connecting line,
 * alternating dot markers) is specific to that scroller, not a plain
 * grid listing.
 *
 * @package Queer_Ink_Theme
 */

$qi_timeline_year = get_post_meta( get_the_ID(), '_qi_timeline_year', true );
?>
<article id="timeline-<?php the_ID(); ?>" <?php post_class( 'timeline-entry-card' ); ?>>
    <a class="timeline-entry-card__media-link" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
        <div class="timeline-entry-card__media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'timeline-entry-card__media-img' ) ); ?>
            <?php else : ?>
                <span class="timeline-entry-card__media-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <div class="timeline-entry-card__body">
        <?php if ( $qi_timeline_year ) : ?>
            <span class="timeline-entry-card__year"><?php echo esc_html( $qi_timeline_year ); ?></span>
        <?php endif; ?>
        <h3 class="timeline-entry-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if ( has_excerpt() ) : ?>
            <p class="timeline-entry-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
        <a class="timeline-entry-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Explore', 'queer-ink-theme' ); ?> →</a>
    </div>
</article>
