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

        // Not public — there's no single/archive page for a report, only
        // its uploaded PDF (linked directly from the About page's Annual
        // Report card via the [qi_annual_reports] shortcode, inc/shortcodes.php).
        // show_ui/show_in_menu keep it manageable from wp-admin like any
        // other content type; rewrite/query_var are off since no frontend
        // route is needed, so this never requires a rewrite-rules flush.
        register_post_type( 'qi_annual_report', array(
            'labels'              => array(
                'name'          => esc_html__( 'Annual Reports', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Annual Report', 'queer-ink-theme' ),
                'add_new_item'  => esc_html__( 'Add New Annual Report', 'queer-ink-theme' ),
                'edit_item'     => esc_html__( 'Edit Annual Report', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'Annual Reports', 'queer-ink-theme' ),
            ),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'exclude_from_search' => true,
            'rewrite'             => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'menu_icon'           => 'dashicons-media-spreadsheet',
            'menu_position'       => 27,
            'show_in_rest'        => false,
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

        // Private inquiry storage for the Connect page's contact form (see
        // queer_ink_handle_contact_form_submission(), inc/shortcodes.php).
        // Never public — a custom capability_type (granted to Administrators
        // only, see queer_ink_grant_contact_submission_caps() below) keeps
        // these out of reach of any lower role, and every submission is
        // additionally saved with post_status 'private' as a second,
        // independent guarantee it can never appear on the public site.
        register_post_type( 'qi_inquiry', array(
            'labels'              => array(
                'name'          => esc_html__( 'Inquiries', 'queer-ink-theme' ),
                'singular_name' => esc_html__( 'Inquiry', 'queer-ink-theme' ),
                'all_items'     => esc_html__( 'Inquiries', 'queer-ink-theme' ),
                'view_item'     => esc_html__( 'View Inquiry', 'queer-ink-theme' ),
                'search_items'  => esc_html__( 'Search Inquiries', 'queer-ink-theme' ),
                'not_found'     => esc_html__( 'No inquiries yet.', 'queer-ink-theme' ),
            ),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'exclude_from_search' => true,
            'rewrite'             => false,
            'query_var'           => false,
            'capability_type'     => array( 'qi_inquiry', 'qi_inquiries' ),
            'map_meta_cap'        => true,
            'capabilities'        => array(
                'create_posts' => 'do_not_allow', // Submissions are only ever created by the form handler, never manually.
            ),
            'supports'            => array( 'title' ),
            'menu_icon'           => 'dashicons-email-alt',
            'menu_position'       => 28,
            'show_in_rest'        => false,
        ) );
    }
}
add_action( 'init', 'queer_ink_register_post_types' );

if ( ! function_exists( 'queer_ink_grant_contact_submission_caps' ) ) {
    /**
     * One-time grant of the qi_inquiry custom capabilities to
     * the Administrator role only — mirrors the one-time-option-flag
     * pattern used by queer_ink_migrate_featured_collections() below, so
     * this reliably runs once regardless of whether the theme was just
     * activated or was already active when this shipped (after_switch_theme
     * alone would miss the latter case).
     */
    function queer_ink_grant_contact_submission_caps() {
        if ( get_option( 'qi_inquiry_caps_granted' ) ) {
            return;
        }

        $administrator = get_role( 'administrator' );
        if ( $administrator ) {
            foreach ( array( 'edit_qi_inquiry', 'read_qi_inquiry', 'delete_qi_inquiry', 'edit_qi_inquiries', 'edit_others_qi_inquiries', 'publish_qi_inquiries', 'read_private_qi_inquiries', 'delete_qi_inquiries', 'delete_private_qi_inquiries', 'delete_others_qi_inquiries', 'edit_private_qi_inquiries' ) as $cap ) {
                $administrator->add_cap( $cap );
            }
        }

        update_option( 'qi_inquiry_caps_granted', 1 );
    }
}
add_action( 'init', 'queer_ink_grant_contact_submission_caps' );

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

if ( ! function_exists( 'queer_ink_title_case_dynamic_titles' ) ) {
    /**
     * Books, Articles, Timeline entries and Collections are titled freely
     * by admins (any casing). Displaying them in Title Case is a frontend
     * presentation choice only — the stored post_title is never touched,
     * so wp-admin's post list/editor keeps showing exactly what was typed.
     */
    function queer_ink_title_case_dynamic_titles( $title, $post_id = 0 ) {
        if ( is_admin() || ! $post_id ) {
            return $title;
        }

        $qi_title_case_post_types = array( 'qi_book', 'qi_article', 'qi_timeline', 'qi_collection' );

        if ( ! in_array( get_post_type( $post_id ), $qi_title_case_post_types, true ) ) {
            return $title;
        }

        return mb_convert_case( $title, MB_CASE_TITLE, 'UTF-8' );
    }
}
add_filter( 'the_title', 'queer_ink_title_case_dynamic_titles', 10, 2 );
