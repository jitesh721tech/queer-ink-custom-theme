<?php
/**
 * Hero section template part.
 *
 * @package Queer_Ink_Theme
 */

$hero_eyebrow    = get_theme_mod( 'queer_ink_hero_eyebrow', esc_html__( 'Editorial archive for queer futures', 'queer-ink-theme' ) );
$hero_heading    = get_theme_mod( 'queer_ink_hero_heading', wp_kses_post( __( 'Queer Ink is a publishing platform for <span class="hero__title--accent">archival resistance</span>.', 'queer-ink-theme' ) ) );
$hero_description = get_theme_mod( 'queer_ink_hero_description', esc_html__( 'Examining protest histories, cultural memory, and queer futures through essays, archives, and publishing.', 'queer-ink-theme' ) );
$primary_label   = get_theme_mod( 'queer_ink_hero_primary_label', esc_html__( 'Explore Our Work', 'queer-ink-theme' ) );
$primary_url     = get_theme_mod( 'queer_ink_hero_primary_url', esc_url( home_url( '/publishing' ) ) );
$secondary_label = get_theme_mod( 'queer_ink_hero_secondary_label', esc_html__( 'Learn More About Us', 'queer-ink-theme' ) );
$secondary_url   = get_theme_mod( 'queer_ink_hero_secondary_url', esc_url( home_url( '/about' ) ) );
?>

<section class="hero" aria-labelledby="hero-title">
    <div class="container">
        <div class="hero__inner">
            <div class="hero__copy">
                <p class="hero__eyebrow"><?php echo esc_html( $hero_eyebrow ); ?></p>
                <h1 id="hero-title" class="hero__title"><?php echo wp_kses_post( $hero_heading ); ?></h1>
                <p class="hero__description"><?php echo esc_html( $hero_description ); ?></p>
                <div class="hero__actions">
                    <a class="button button--primary hero__button" href="<?php echo esc_url( $primary_url ); ?>"><?php echo esc_html( $primary_label ); ?></a>
                    <a class="button button--outline hero__button" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo esc_html( $secondary_label ); ?></a>
                </div>
            </div>
            <div class="hero__media" aria-hidden="true">
                <figure class="hero__image-container">
                    <img
                        class="hero__image"
                        src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero/homepage_hero.jpeg' ) ); ?>"
                        alt="Queer Ink collage image"
                    />
                </figure>
            </div>
        </div>
    </div>
</section>
