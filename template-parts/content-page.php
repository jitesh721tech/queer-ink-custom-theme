<?php
/**
 * Template part for displaying page content.
 *
 * @package Queer_Ink_Theme
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
