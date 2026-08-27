<?php
/**
 * Customizer controls for the homepage hero section only.
 *
 * template-parts/section-hero.php already reads all of its text content
 * via get_theme_mod() with hardcoded PHP fallbacks, but no Customizer
 * settings/controls were ever registered for those mods — so none of it
 * was actually editable from wp-admin (the hero image wasn't even a mod
 * at all; it was a hardcoded file path). This registers exactly those
 * existing mods, with defaults matching section-hero.php's own fallbacks
 * word-for-word, so nothing currently on the live site changes until an
 * admin actually edits something in Appearance > Customize > Homepage Hero.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_customize_register' ) ) {
    function queer_ink_customize_register( $wp_customize ) {
        $wp_customize->add_panel( 'queer_ink_hero_panel', array(
            'title'       => esc_html__( 'Homepage Hero', 'queer-ink-theme' ),
            'description' => esc_html__( 'Text, buttons and image shown in the first section of the homepage.', 'queer-ink-theme' ),
            'priority'    => 10,
        ) );

        $wp_customize->add_section( 'queer_ink_hero_section', array(
            'title' => esc_html__( 'Hero Content', 'queer-ink-theme' ),
            'panel' => 'queer_ink_hero_panel',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_eyebrow', array(
            'default'           => esc_html__( 'Editorial archive for queer futures', 'queer-ink-theme' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_eyebrow', array(
            'label'   => esc_html__( 'Eyebrow label', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_heading', array(
            'default'           => 'Queer Ink is a publishing platform for <span class="hero__title--accent">archival resistance</span>.',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_heading', array(
            'label'       => esc_html__( 'Heading', 'queer-ink-theme' ),
            'description' => esc_html__( 'Basic HTML is allowed. Wrap text in <span class="hero__title--accent">...</span> to keep the pink accent color.', 'queer-ink-theme' ),
            'section'     => 'queer_ink_hero_section',
            'type'        => 'textarea',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_description', array(
            'default'           => esc_html__( 'Examining protest histories, cultural memory, and queer futures through essays, archives, and publishing.', 'queer-ink-theme' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_description', array(
            'label'   => esc_html__( 'Description', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'textarea',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_primary_label', array(
            'default'           => esc_html__( 'Explore Our Work', 'queer-ink-theme' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_primary_label', array(
            'label'   => esc_html__( 'Primary button label', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_primary_url', array(
            'default'           => home_url( '/publishing' ),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_primary_url', array(
            'label'   => esc_html__( 'Primary button link', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'url',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_secondary_label', array(
            'default'           => esc_html__( 'Learn More About Us', 'queer-ink-theme' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_secondary_label', array(
            'label'   => esc_html__( 'Secondary button label', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'text',
        ) );

        $wp_customize->add_setting( 'queer_ink_hero_secondary_url', array(
            'default'           => home_url( '/about' ),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( 'queer_ink_hero_secondary_url', array(
            'label'   => esc_html__( 'Secondary button link', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
            'type'    => 'url',
        ) );

        // Was a hardcoded file path in template-parts/section-hero.php with
        // no admin control at all — now a real (optional) theme mod, still
        // falling back to the same original image file when unset.
        $wp_customize->add_setting( 'queer_ink_hero_image', array(
            'default'           => get_theme_file_uri( 'assets/images/hero/homepage_hero.png' ),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'queer_ink_hero_image', array(
            'label'   => esc_html__( 'Hero image', 'queer-ink-theme' ),
            'section' => 'queer_ink_hero_section',
        ) ) );
    }
}
add_action( 'customize_register', 'queer_ink_customize_register' );
