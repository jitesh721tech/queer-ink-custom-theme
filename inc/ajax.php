<?php
/**
 * QI Journal dynamic article loading — powers both the category/topic
 * filters and "Load More Articles" from a single endpoint, so filtering
 * and pagination share one query shape and the visitor never leaves
 * /qi-journal/. Renders through the same template-parts/content-
 * qi_article.php card partial the initial [qi_latest_articles] output
 * uses, so cards never drift out of sync with the static first page.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_ajax_load_articles' ) ) {
    function queer_ink_ajax_load_articles() {
        check_ajax_referer( 'qi_journal_filter', 'nonce' );

        $per_page = 6; // Matches [qi_latest_articles count="6"] on the QI Journal page.
        $paged    = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;
        $section  = isset( $_POST['section'] ) ? sanitize_title( wp_unslash( $_POST['section'] ) ) : '';
        $topic    = isset( $_POST['topic'] ) ? sanitize_title( wp_unslash( $_POST['topic'] ) ) : '';
        $search   = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';

        $query_args = array(
            'post_type'      => 'qi_article',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        if ( '' !== $search ) {
            $query_args['s'] = $search;
        }

        $tax_query = array();

        if ( '' !== $section ) {
            $tax_query[] = array(
                'taxonomy' => 'qi_article_section',
                'field'    => 'slug',
                'terms'    => $section,
            );
        }

        if ( '' !== $topic ) {
            $tax_query[] = array(
                'taxonomy' => 'qi_article_topic',
                'field'    => 'slug',
                'terms'    => $topic,
            );
        }

        if ( ! empty( $tax_query ) ) {
            $query_args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- small, admin-controlled taxonomy, not user-arbitrary.
        }

        $articles = new WP_Query( $query_args );

        ob_start();

        if ( $articles->have_posts() ) {
            while ( $articles->have_posts() ) {
                $articles->the_post();
                get_template_part( 'template-parts/content', 'qi_article' );
            }
        }

        wp_reset_postdata();

        wp_send_json_success( array(
            'html'      => ob_get_clean(),
            'has_more'  => $paged < $articles->max_num_pages,
            'found'     => $articles->found_posts,
        ) );
    }
}
add_action( 'wp_ajax_qi_load_articles', 'queer_ink_ajax_load_articles' );
add_action( 'wp_ajax_nopriv_qi_load_articles', 'queer_ink_ajax_load_articles' );
