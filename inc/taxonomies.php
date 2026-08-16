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
 * Each article should carry exactly one section term (a content
 * convention, not enforced by WordPress) so it reads as a category.
 *
 * qi_article_topic is a second, separate article-only taxonomy for
 * cross-cutting topics (Archives & Memory, Publishing & Books...) —
 * articles can carry several. Deliberately its own taxonomy rather than
 * reusing qi_subject (shared with qi_book): Book subjects and Journal
 * topics are different vocabularies that happen to sound similar.
 *
 * qi_book_author and qi_article_author are deliberately separate,
 * non-hierarchical (tag-style) taxonomies rather than one shared
 * "author" taxonomy or the native post_author field — a book author and
 * an article writer are treated as distinct entities, and neither
 * requires a WordPress user account. Each term gets its own browsable
 * archive automatically via archive.php.
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

        register_taxonomy( 'qi_article_topic', array( 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Topics', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Topic', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Topic', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Topic', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Topics', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'topic', 'with_front' => false ),
        ) );

        register_taxonomy( 'qi_book_author', array( 'qi_book' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Authors', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Author', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Author', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Author', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Authors', 'queer-ink-theme' ),
                'search_items'  => esc_html__( 'Search Authors', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'book-author', 'with_front' => false ),
        ) );

        register_taxonomy( 'qi_article_author', array( 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Writers', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Writer', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Writer', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Writer', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Writers', 'queer-ink-theme' ),
                'search_items'  => esc_html__( 'Search Writers', 'queer-ink-theme' ),
            ),
            'public'            => true,
            'hierarchical'      => false,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'writer', 'with_front' => false ),
        ) );
    }
}
add_action( 'init', 'queer_ink_register_taxonomies' );
