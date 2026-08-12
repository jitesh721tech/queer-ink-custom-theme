<?php
/**
 * Flush rewrite rules once whenever registered post types/taxonomies change.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_maybe_flush_rewrite_rules' ) ) {
    function queer_ink_maybe_flush_rewrite_rules() {
        $version = '4';

        if ( get_option( 'queer_ink_rewrite_version' ) !== $version ) {
            flush_rewrite_rules();
            update_option( 'queer_ink_rewrite_version', $version );
        }
    }
}
add_action( 'init', 'queer_ink_maybe_flush_rewrite_rules', 20 );
