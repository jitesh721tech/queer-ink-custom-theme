<?php
/**
 * Theme functions and definitions.
 *
 * @package Queer_Ink_Theme
 */

require_once get_theme_file_path( 'inc/post-types.php' );
require_once get_theme_file_path( 'inc/taxonomies.php' );
require_once get_theme_file_path( 'inc/rewrite.php' );
require_once get_theme_file_path( 'inc/shortcodes.php' );
require_once get_theme_file_path( 'inc/block-patterns.php' );

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
                'color' => '#4a4a4a',
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

if ( ! function_exists( 'queer_ink_theme_scripts' ) ) {
    function queer_ink_theme_scripts() {
        wp_enqueue_style( 'queer-ink-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-main', get_theme_file_uri( 'assets/css/style.css' ), array(), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-header', get_theme_file_uri( 'assets/css/header.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-hero', get_theme_file_uri( 'assets/css/hero.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-feature-strip', get_theme_file_uri( 'assets/css/feature-strip.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-channel-band', get_theme_file_uri( 'assets/css/channel-band.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-footer', get_theme_file_uri( 'assets/css/footer.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-publishing', get_theme_file_uri( 'assets/css/publishing.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-archiving', get_theme_file_uri( 'assets/css/archiving.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-digital-library', get_theme_file_uri( 'assets/css/digital-library.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );
        wp_enqueue_style( 'queer-ink-qi-journal', get_theme_file_uri( 'assets/css/qi-journal.css' ), array( 'queer-ink-main' ), wp_get_theme()->get( 'Version' ) );

        wp_enqueue_script( 'queer-ink-main', get_theme_file_uri( 'assets/js/main.js' ), array(), wp_get_theme()->get( 'Version' ), true );
    }
}
add_action( 'wp_enqueue_scripts', 'queer_ink_theme_scripts' );
