<?php
/**
 * Header template.
 *
 * @package Queer_Ink_Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header" role="banner">
    <div class="site-header__inner container">
        <div class="site-branding">
            <?php if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo/logo.jpeg' ) ); ?>"
                        alt="<?php bloginfo( 'name' ); ?>"
                        width="120" height="120">
                </a>
            <?php endif; ?>
        </div>
        <nav class="primary-navigation" role="navigation" aria-label="Primary menu">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu',
                    'menu_id'        => 'primary-menu-list',
                    'container'      => false,
                ) );
                ?>
            <?php else : ?>
                <ul class="primary-menu" id="primary-menu-list">
                    <li><a href="<?php echo esc_url( home_url( '/publishing' ) ); ?>"><?php esc_html_e( 'Publishing', 'queer-ink-theme' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/archiving' ) ); ?>"><?php esc_html_e( 'Archiving', 'queer-ink-theme' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/digital-library' ) ); ?>"><?php esc_html_e( 'Digital Library', 'queer-ink-theme' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/qi-journal' ) ); ?>"><?php esc_html_e( 'QI Journal', 'queer-ink-theme' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'queer-ink-theme' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/connect' ) ); ?>"><?php esc_html_e( 'Connect', 'queer-ink-theme' ); ?></a></li>
                </ul>
            <?php endif; ?>
            <div class="header-search-wrap">
                <button type="button" class="header-search" aria-expanded="false" aria-controls="header-search-panel" aria-label="<?php esc_attr_e( 'Search', 'queer-ink-theme' ); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <circle cx="10" cy="10" r="6" stroke="#1A1A1A" stroke-width="2" fill="none" />
                        <line x1="15" y1="15" x2="21" y2="21" stroke="#1A1A1A" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <div class="header-search-panel" id="header-search-panel" hidden>
                    <form class="qi-search-form header-search-panel__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label class="screen-reader-text" for="header-search-input"><?php esc_html_e( 'Search the site', 'queer-ink-theme' ); ?></label>
                        <input id="header-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Search books, articles, authors…', 'queer-ink-theme' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" />
                        <button type="submit" aria-label="<?php esc_attr_e( 'Submit search', 'queer-ink-theme' ); ?>">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <circle cx="10" cy="10" r="6" stroke="currentColor" stroke-width="2" fill="none" />
                                <line x1="15" y1="15" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <button type="button" class="menu-toggle" aria-expanded="false" aria-controls="primary-menu-list" aria-label="<?php esc_attr_e( 'Toggle menu', 'queer-ink-theme' ); ?>">
                <span class="menu-toggle__bar"></span>
                <span class="menu-toggle__bar"></span>
                <span class="menu-toggle__bar"></span>
            </button>
        </nav>
    </div>
</header>
