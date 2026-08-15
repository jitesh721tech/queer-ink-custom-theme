<?php
/**
 * Custom post type registrations.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_register_post_types' ) ) {
    function queer_ink_register_post_types() {
        register_post_type( 'qi_book', array(
            'labels'       => array(
                'name'          => esc_html__( 'Books', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Book', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Book', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Book', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Books', 'queer-ink-theme' ),
            ),
            'public'       => true,
            'has_archive'  => 'books',
            'rewrite'      => array( 'slug' => 'books', 'with_front' => false ),
            'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'menu_icon'    => 'dashicons-book-alt',
            'show_in_rest' => true,
        ) );

        register_post_type( 'qi_article', array(
            'labels'       => array(
                'name'          => esc_html__( 'Articles', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Article', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Article', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Article', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Articles', 'queer-ink-theme' ),
            ),
            'public'       => true,
            'has_archive'  => 'journal',
            'rewrite'      => array( 'slug' => 'journal', 'with_front' => false ),
            'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'menu_icon'    => 'dashicons-media-document',
            'show_in_rest' => true,
        ) );

        register_post_type( 'qi_collection', array(
            'labels'       => array(
                'name'          => esc_html__( 'Collections', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Collection', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Collection', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Collection', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Collections', 'queer-ink-theme' ),
            ),
            'public'       => true,
            'has_archive'  => false,
            'rewrite'      => array( 'slug' => 'collections', 'with_front' => false ),
            'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'menu_icon'    => 'dashicons-portfolio',
            'show_in_rest' => true,
        ) );

        register_post_type( 'qi_timeline', array(
            'labels'       => array(
                'name'          => esc_html__( 'Timeline', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Timeline Entry', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Timeline Entry', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Timeline Entry', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Timeline Entries', 'queer-ink-theme' ),
            ),
            'public'       => true,
            'has_archive'  => 'timeline',
            'rewrite'      => array( 'slug' => 'timeline', 'with_front' => false ),
            'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
            'menu_icon'    => 'dashicons-clock',
            'show_in_rest' => true,
        ) );

        register_post_type( 'qi_form_field', array(
            'labels'       => array(
                'name'          => esc_html__( 'Contact Form Fields', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Form Field', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Form Field', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Form Field', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'Contact Form Fields', 'queer-ink-theme' ),
            ),
            'public'             => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'exclude_from_search' => true,
            'rewrite'            => false,
            'query_var'          => false,
            'supports'           => array( 'title', 'page-attributes' ),
            'menu_icon'          => 'dashicons-feedback',
            'menu_position'      => 26,
            'show_in_rest'       => false,
        ) );
    }
}
add_action( 'init', 'queer_ink_register_post_types' );

if ( ! function_exists( 'queer_ink_order_timeline_archive_by_year' ) ) {
    /**
     * The /timeline/ archive ("View Full Timeline") reads as a timeline,
     * so it should list chronologically by the _qi_timeline_year meta
     * value rather than WordPress's default newest-post-first ordering
     * — matching the ordering already used by the qi_timeline_entries
     * shortcode that powers the Archiving page's timeline widget.
     */
    function queer_ink_order_timeline_archive_by_year( $query ) {
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }

        if ( ! $query->is_post_type_archive( 'qi_timeline' ) ) {
            return;
        }

        $query->set( 'meta_key', '_qi_timeline_year' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'queer_ink_order_timeline_archive_by_year' );
