<?php
/**
 * Generic page content, boxed: a centered, white content card (title +
 * body share the same width/centering) with a single "Back" link above
 * it, on the page's normal background. Shared by page-about-qi-journal.php
 * and page-our-principles.php so both stay identical by construction.
 *
 * Expects $args: 'back_url', 'back_label'.
 *
 * @package Queer_Ink_Theme
 */

$back_url   = isset( $args['back_url'] ) ? $args['back_url'] : '';
$back_label = isset( $args['back_label'] ) ? $args['back_label'] : '';
?>
<?php if ( $back_url && $back_label ) : ?>
    <p class="qi-page-back"><a href="<?php echo esc_url( $back_url ); ?>">&larr; <?php echo esc_html( $back_label ); ?></a></p>
<?php endif; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'qi-page-boxed' ); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
