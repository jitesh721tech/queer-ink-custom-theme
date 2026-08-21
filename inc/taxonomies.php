<?php
/**
 * Shared taxonomy registrations.
 *
 * qi_subject and qi_language are registered against qi_book (qi_subject
 * used to also cover qi_article, but the Journal now uses its own
 * qi_article_topic vocabulary as the article-side equivalent instead —
 * see below — so qi_article was removed from qi_subject's object types.
 * This doesn't touch qi_book's use of qi_subject at all.
 *
 * qi_article_section is article-only — it groups posts by editorial
 * category (Reflections, Research, Voices...) for the QI Journal page.
 * Each article should carry exactly one section term (a content
 * convention, not enforced by WordPress) so it reads as a category —
 * labelled "Category"/"Categories" in wp-admin for that reason, though
 * the taxonomy key and rewrite slug (qi_article_section, /section/)
 * are unchanged so existing URLs keep working.
 *
 * qi_article_topic is a second, separate article-only taxonomy for
 * cross-cutting topics (Archives & Memory, Queer Histories...) —
 * articles can carry several. It now doubles as the "Subjects"
 * equivalent for articles now that qi_subject is book-only.
 *
 * qi_book_author and qi_article_author are deliberately separate
 * taxonomies rather than one shared "author" taxonomy or the native
 * post_author field — a book author and an article writer are treated
 * as distinct entities, and neither requires a WordPress user account.
 * Each term gets its own browsable archive automatically via archive.php.
 *
 * qi_language, qi_article_section, qi_article_topic, qi_book_author and
 * qi_article_author are all registered 'hierarchical' => true purely to
 * get wp-admin/the block editor's searchable-checkbox term UI (the same
 * one qi_subject already used) instead of the tag/chip-style input
 * non-hierarchical taxonomies get — none of them actually use parent
 * terms, so this has no effect on term data, frontend URLs or filtering.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_register_taxonomies' ) ) {
    function queer_ink_register_taxonomies() {
        register_taxonomy( 'qi_subject', array( 'qi_book' ), array(
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
            // Hierarchical purely for the wp-admin/block-editor UI it
            // triggers — a searchable checkbox list + "+ Add New Language"
            // (matching Subjects), instead of the tag/chip-style input
            // non-hierarchical taxonomies get. No term here has (or is
            // meant to have) a parent, so frontend URLs, term archives and
            // tax_query filtering are all unaffected.
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'language', 'with_front' => false ),
        ) );

        register_taxonomy( 'qi_article_section', array( 'qi_article' ), array(
            'labels'       => array(
                'name'          => esc_html__( 'Categories', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Category', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Category', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Category', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'All Categories', 'queer-ink-theme' ),
            ),
            'public'            => true,
            // See qi_language above — hierarchical only for the checkbox
            // admin UI; no term here has a parent.
            'hierarchical'      => true,
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
            // See qi_language above — hierarchical only for the checkbox
            // admin UI; no term here has a parent.
            'hierarchical'      => true,
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
            // See qi_language above — hierarchical only for the checkbox
            // admin UI; no term here has a parent.
            'hierarchical'      => true,
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
            // See qi_language above — hierarchical only for the checkbox
            // admin UI; no term here has a parent.
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'writer', 'with_front' => false ),
        ) );
    }
}
add_action( 'init', 'queer_ink_register_taxonomies' );
