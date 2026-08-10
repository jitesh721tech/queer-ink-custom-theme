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
    }
}
add_action( 'init', 'queer_ink_register_post_types' );
