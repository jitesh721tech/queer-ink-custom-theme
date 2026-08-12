<?php
/**
 * Site-wide search: relevance ranking for the main search query, plus
 * helpers to pull in matching Book/Article authors — a taxonomy term
 * match (e.g. searching an author's name) isn't something WP_Query's
 * native 's' parameter can find, since it only searches post fields.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_search_relevance_clauses' ) ) {
    function queer_ink_search_relevance_clauses( $clauses, $query ) {
        global $wpdb;

        if ( is_admin() || ! $query->is_search() || ! $query->is_main_query() ) {
            return $clauses;
        }

        $term = trim( (string) $query->get( 's' ) );

        if ( '' === $term ) {
            return $clauses;
        }

        $like_exact = $wpdb->esc_like( $term );
        $like_wrap  = '%' . $like_exact . '%';
        $like_start = $like_exact . '%';

        $clauses['fields'] .= $wpdb->prepare(
            ", (CASE
                WHEN {$wpdb->posts}.post_title LIKE %s THEN 4
                WHEN {$wpdb->posts}.post_title LIKE %s THEN 3
                WHEN {$wpdb->posts}.post_excerpt LIKE %s THEN 2
                ELSE 1
            END) AS qi_relevance",
            $like_exact,
            $like_start,
            $like_wrap
        );

        $clauses['orderby'] = 'qi_relevance DESC, ' . $clauses['orderby'];

        return $clauses;
    }
}
add_filter( 'posts_clauses', 'queer_ink_search_relevance_clauses', 10, 2 );

if ( ! function_exists( 'queer_ink_get_matching_authors' ) ) {
    /**
     * Author/writer terms (qi_book_author, qi_article_author) whose name
     * matches the given search term, each annotated with the taxonomy's
     * singular label so callers can show "Author" as the result type.
     *
     * @return WP_Term[]
     */
    function queer_ink_get_matching_authors( $search_term ) {
        $search_term = trim( (string) $search_term );

        if ( '' === $search_term ) {
            return array();
        }

        $terms = get_terms( array(
            'taxonomy'   => array( 'qi_book_author', 'qi_article_author' ),
            'name__like' => $search_term,
            'hide_empty' => true,
        ) );

        if ( is_wp_error( $terms ) ) {
            return array();
        }

        return $terms;
    }
}

if ( ! function_exists( 'queer_ink_search_result_type_label' ) ) {
    /**
     * Human-readable content-type label for a search result card.
     *
     * @param WP_Post|WP_Term $item
     */
    function queer_ink_search_result_type_label( $item ) {
        if ( $item instanceof WP_Term ) {
            return esc_html__( 'Author', 'queer-ink-theme' );
        }

        $post_type = get_post_type_object( get_post_type( $item ) );

        return $post_type ? $post_type->labels->singular_name : esc_html__( 'Result', 'queer-ink-theme' );
    }
}
