<?php
/**
 * Shared taxonomy registrations.
 *
 * qi_subject and qi_language are registered against both qi_book and
 * qi_article so the Digital Library can browse/filter across both post
 * types instead of needing a post type of its own.
 *
 * qi_article_section is article-only — it groups posts by editorial
 * section (Reflections, Research, Voices...) for the QI Journal page.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_register_taxonomies' ) ) {
    function queer_ink_register_taxonomies() {
        register_taxonomy( 'qi_subject', array( 'qi_book', 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Subjects', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Subject', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Subject', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Subject', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Subjects', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'subject', 'with_front' => false ),
        ) );

        register_taxonomy( 'qi_language', array( 'qi_book', 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Languages', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Language', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Language', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Language', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Languages', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'language', 'with_front' => false ),
        ) );

        register_taxonomy( 'qi_article_section', array( 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Sections', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Section', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Section', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Section', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Sections', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'section', 'with_front' => false ),
        ) );
    }
}
add_action( 'init', 'queer_ink_register_taxonomies' );
