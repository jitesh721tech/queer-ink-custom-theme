<?php
/**
 * 404 page template.
 *
 * @package Queer_Ink_Theme
 */

get_header(); ?>

<main id="site-content" class="site-content container" role="main">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Page not found', 'queer-ink-theme' ); ?></h1>
        </header>
        <div class="page-content">
            <p><?php esc_html_e( 'Sorry, but the page you were trying to view does not exist.', 'queer-ink-theme' ); ?></p>
        </div>
    </section>
</main>

<?php get_footer();
