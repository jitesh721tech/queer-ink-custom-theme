<?php
/**
 * Theme functions and definitions.
 *
 * @package Queer_Ink_Theme
 */

require_once get_theme_file_path( 'inc/post-types.php' );
require_once get_theme_file_path( 'inc/meta-boxes.php' );
require_once get_theme_file_path( 'inc/taxonomies.php' );
require_once get_theme_file_path( 'inc/admin-taxonomy-fields.php' );
require_once get_theme_file_path( 'inc/rewrite.php' );
require_once get_theme_file_path( 'inc/shortcodes.php' );
require_once get_theme_file_path( 'inc/search.php' );
require_once get_theme_file_path( 'inc/ajax.php' );
require_once get_theme_file_path( 'inc/block-patterns.php' );
require_once get_theme_file_path( 'inc/customizer.php' );

if ( ! function_exists( 'queer_ink_theme_setup' ) ) {
    function queer_ink_theme_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'menus' );
        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => esc_html__( 'Accent Pink', 'queer-ink-theme' ),
                'slug'  => 'qi-accent',
                'color' => '#c0185b',
            ),
            array(
                'name'  => esc_html__( 'Ink Black', 'queer-ink-theme' ),
                'slug'  => 'qi-ink',
                'color' => '#1a1a1a',
            ),
            array(
                'name'  => esc_html__( 'Body Gray', 'queer-ink-theme' ),
                'slug'  => 'qi-gray',
                'color' => '#000000',
            ),
            array(
                'name'  => esc_html__( 'Soft Pink', 'queer-ink-theme' ),
                'slug'  => 'qi-soft-pink',
                'color' => '#fbdce6',
            ),
            array(
                'name'  => esc_html__( 'Border', 'queer-ink-theme' ),
                'slug'  => 'qi-border',
                'color' => '#e5e2e2',
            ),
            array(
                'name'  => esc_html__( 'Off White', 'queer-ink-theme' ),
                'slug'  => 'qi-offwhite',
                'color' => '#fafafa',
            ),
            array(
                'name'  => esc_html__( 'White', 'queer-ink-theme' ),
                'slug'  => 'qi-white',
                'color' => '#ffffff',
            ),
        ) );

        register_nav_menus( array(
            'primary' => esc_html__( 'Primary Menu', 'queer-ink-theme' ),
            'footer_explore' => esc_html__( 'Footer Explore', 'queer-ink-theme' ),
            'footer_about' => esc_html__( 'Footer About', 'queer-ink-theme' ),
            'footer_connect' => esc_html__( 'Footer Connect', 'queer-ink-theme' ),
            'footer_legal' => esc_html__( 'Footer Legal', 'queer-ink-theme' ),
        ) );
    }
}
add_action( 'after_setup_theme', 'queer_ink_theme_setup' );

if ( ! function_exists( 'queer_ink_asset_version' ) ) {
    /**
     * Cache-busting version string for one theme asset — the file's own
     * last-modified time, instead of every enqueued style/script sharing
     * one static number (the theme's Version header, style.css). With a
     * single shared version, editing any one CSS/JS file never changes
     * that file's requested URL unless someone also remembers to bump the
     * theme version — on a host that caches static assets (browsers, a
     * CDN, TasteWP itself), a visitor who'd already loaded the old file
     * keeps being served that exact byte-for-byte-cached copy indefinitely,
     * with no way for a real code fix to ever reach them. (This is why a
     * previous fix to assets/js/main.js's entrance-animation handling kept
     * failing to resolve reports of intermittently blank sections in
     * production while working every time on localhost — a fresh dev
     * profile has no stale cached copy to be serving in the first place.)
     * Tying each file's version to its own mtime makes every future edit
     * automatically its own cache-bust, for every asset, with no manual
     * step to remember or forget.
     */
    function queer_ink_asset_version( $relative_path ) {
        $path  = get_theme_file_path( $relative_path );
        $mtime = file_exists( $path ) ? filemtime( $path ) : false;
        return $mtime ? (string) $mtime : wp_get_theme()->get( 'Version' );
    }
}

if ( ! function_exists( 'queer_ink_theme_scripts' ) ) {
    function queer_ink_theme_scripts() {
        wp_enqueue_style( 'queer-ink-style', get_stylesheet_uri(), array(), queer_ink_asset_version( 'style.css' ) );
        wp_enqueue_style( 'queer-ink-main', get_theme_file_uri( 'assets/css/style.css' ), array(), queer_ink_asset_version( 'assets/css/style.css' ) );
        wp_enqueue_style( 'queer-ink-header', get_theme_file_uri( 'assets/css/header.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/header.css' ) );
        wp_enqueue_style( 'queer-ink-hero', get_theme_file_uri( 'assets/css/hero.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/hero.css' ) );
        wp_enqueue_style( 'queer-ink-feature-strip', get_theme_file_uri( 'assets/css/feature-strip.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/feature-strip.css' ) );
        wp_enqueue_style( 'queer-ink-channel-band', get_theme_file_uri( 'assets/css/channel-band.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/channel-band.css' ) );
        wp_enqueue_style( 'queer-ink-footer', get_theme_file_uri( 'assets/css/footer.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/footer.css' ) );
        wp_enqueue_style( 'queer-ink-publishing', get_theme_file_uri( 'assets/css/publishing.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/publishing.css' ) );
        wp_enqueue_style( 'queer-ink-archiving', get_theme_file_uri( 'assets/css/archiving.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/archiving.css' ) );
        wp_enqueue_style( 'queer-ink-digital-library', get_theme_file_uri( 'assets/css/digital-library.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/digital-library.css' ) );
        wp_enqueue_style( 'queer-ink-qi-journal', get_theme_file_uri( 'assets/css/qi-journal.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/qi-journal.css' ) );
        wp_enqueue_style( 'queer-ink-about', get_theme_file_uri( 'assets/css/about.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/about.css' ) );
        wp_enqueue_style( 'queer-ink-connect', get_theme_file_uri( 'assets/css/connect.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/connect.css' ) );
        wp_enqueue_style( 'queer-ink-search', get_theme_file_uri( 'assets/css/search.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/search.css' ) );
        wp_enqueue_style( 'queer-ink-single-content', get_theme_file_uri( 'assets/css/single-content.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/single-content.css' ) );
        wp_enqueue_style( 'queer-ink-animations', get_theme_file_uri( 'assets/css/animations.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/animations.css' ) );
        wp_enqueue_style( 'queer-ink-sitemap', get_theme_file_uri( 'assets/css/sitemap.css' ), array( 'queer-ink-main' ), queer_ink_asset_version( 'assets/css/sitemap.css' ) );

        wp_enqueue_script( 'queer-ink-main', get_theme_file_uri( 'assets/js/main.js' ), array(), queer_ink_asset_version( 'assets/js/main.js' ), true );
        wp_localize_script( 'queer-ink-main', 'qiJournalAjax', array(
            'url'   => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'qi_journal_filter' ),
        ) );

        // Same country -> expected-digit-count map the server validates
        // against (queer_ink_contact_country_codes(), inc/shortcodes.php)
        // — the Connect form's Mobile Number field reads this to enforce
        // each country's length live as the visitor types, never letting
        // the client and server rules drift apart.
        if ( function_exists( 'queer_ink_contact_country_codes' ) ) {
            $qi_contact_digit_lengths = array();
            foreach ( queer_ink_contact_country_codes() as $qi_country_key => $qi_country ) {
                $qi_contact_digit_lengths[ $qi_country_key ] = (int) $qi_country['digits'];
            }
            wp_localize_script( 'queer-ink-main', 'qiContactCountryDigits', $qi_contact_digit_lengths );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'queer_ink_theme_scripts' );
