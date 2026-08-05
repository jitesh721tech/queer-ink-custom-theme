<?php
/**
 * The main template file.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <section class="page-placeholder">
        <h1><?php esc_html_e( 'Welcome to Queer Ink Theme', 'queer-ink-theme' ); ?></h1>
        <p><?php esc_html_e( 'This is the theme fallback template. Build homepage and archive templates separately.', 'queer-ink-theme' ); ?></p>
    </section>
</main>

<?php get_footer();
