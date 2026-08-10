<?php
/**
 * Shortcodes for embedding dynamic content inside block-editor page content.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_latest_books_shortcode' ) ) {
    function queer_ink_latest_books_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 8,
        ), $atts, 'qi_latest_books' );

        $books = new WP_Query( array(
            'post_type'      => 'qi_book',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        ob_start();

        if ( $books->have_posts() ) {
            echo '<div class="publishing-grid publishing-grid--current-list">';
            while ( $books->have_posts() ) {
                $books->the_post();
                get_template_part( 'template-parts/content', 'qi_book' );
            }
            echo '</div>';
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'New titles are on their way — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_shortcode( 'qi_latest_books', 'queer_ink_latest_books_shortcode' );
