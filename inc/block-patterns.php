<?php
/**
 * Block pattern registrations for editorial landing pages (e.g. Publishing).
 * Patterns are built from core blocks plus Custom HTML blocks for the more
 * bespoke card layouts — everything remains editable from the block editor,
 * no plugin or custom meta box required.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_icon' ) ) {
    function queer_ink_icon( $name ) {
        $icons = array(
            'lightbulb'  => '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3 11.2V17h6v-2.8A6 6 0 0 0 12 3Z"/>',
            'pencil'     => '<path d="M4 20h4l10.5-10.5a2.1 2.1 0 0 0-3-3L5 17v3Z"/><path d="M13 6l3 3"/>',
            'shield'     => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/><path d="m9.5 12 2 2 3.5-4"/>',
            'rupee'      => '<path d="M7 5h10M7 9h10M7 5c4 0 6 1.2 6 3.5S11 12 7 12h6l3.5 6"/>',
            'megaphone'  => '<path d="M3 10v4l4 1 8 4V5L7 9l-4 1Z"/><path d="M15 8.5a3 3 0 0 1 0 7"/>',
            'archive'    => '<rect x="4" y="4" width="16" height="4" rx="1"/><path d="M5 8v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><path d="M10 12h4"/>',
            'heart'      => '<path d="M12 20s-7-4.4-9.3-9A5 5 0 0 1 12 6a5 5 0 0 1 9.3 5c-2.3 4.6-9.3 9-9.3 9Z"/>',
            'star'       => '<path d="M12 3l2.6 5.6 6.1.6-4.6 4.1 1.3 6-5.4-3.2-5.4 3.2 1.3-6-4.6-4.1 6.1-.6L12 3Z"/>',
            'users'      => '<circle cx="9" cy="8" r="3"/><path d="M2.5 19c0-3 3-5 6.5-5s6.5 2 6.5 5"/><circle cx="17" cy="9" r="2.5"/><path d="M16 14c2.6.3 4.5 2 4.5 4.5"/>',
        );

        if ( ! isset( $icons[ $name ] ) ) {
            return '';
        }

        return '<svg class="qi-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
    }
}

if ( ! function_exists( 'queer_ink_register_block_pattern_category' ) ) {
    function queer_ink_register_block_pattern_category() {
        register_block_pattern_category( 'queer-ink', array(
            'label' => esc_html__( 'Queer Ink', 'queer-ink-theme' ),
        ) );
    }
}
add_action( 'init', 'queer_ink_register_block_pattern_category' );

if ( ! function_exists( 'queer_ink_register_block_patterns' ) ) {
    function queer_ink_register_block_patterns() {

        $placeholder_image = esc_url( get_theme_file_uri( 'assets/images/hero/hero_page_image.jpeg' ) );

        register_block_pattern(
            'queer-ink/publishing-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: Publishing Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero"} -->
<div class="wp-block-group qi-pub-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">PUBLISHING</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Writing the future we <span style="color:#c0185b">deserve.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Stories have the power to change lives. At Queer Ink, publishing is more than producing books. It is about ensuring that important stories are written, shared, discovered, and remembered.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Through our publishing programme, we bring archival collections to life in book form and help independent authors publish professionally—creating books that contribute to public knowledge today and become part of the historical record tomorrow.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/books/">Explore Publications</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#pathways">Our Publishing Approach</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image"><img src="{$placeholder_image}" alt="Placeholder — replace with a photo of Queer Ink published books"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/publishing-pathways',
            array(
                'title'      => esc_html__( 'Queer Ink: Two Pathways', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:heading {"textAlign":"center","anchor":"pathways"} -->
<h2 id="pathways" class="wp-block-heading has-text-align-center">Two pathways, <span style="color:#c0185b">One purpose.</span></h2>
<!-- /wp:heading -->

<!-- wp:html -->
<div class="qi-pathway-row">
    <div class="qi-pathway-card qi-pathway-card--archives">
        <div class="qi-icon-circle">' . queer_ink_icon( 'archive' ) . '</div>
        <p class="hero__eyebrow">PUBLISHING</p>
        <h3>From the Archives</h3>
        <p>We transform carefully curated archival collections into books that preserve and share the histories of queer lives, communities, and movements in India.</p>
        <p>These publications draw on oral histories, manuscripts, photographs, correspondence, organisational records, and other archival materials—making them accessible to readers, educators, researchers, and future generations.</p>
        <a class="qi-pathway-card__link" href="/books/">Explore Archive Publications →</a>
        <div class="qi-pathway-card__media"><img src="' . $placeholder_image . '" alt="Placeholder — replace with a photo of archival material"/></div>
    </div>
    <div class="qi-pathway-card qi-pathway-card--process">
        <div class="qi-pathway-card__head">
            <div>
                <p class="hero__eyebrow">PUBLISHING PATHWAY</p>
                <h3>Creative Autonomy <em>through</em> Financial Independence</h3>
                <p>You write. We walk with you. You remain in charge.</p>
            </div>
            <a class="button button--outline qi-pathway-card__cta" href="#">Start Your Publishing Journey →</a>
        </div>
        <div class="qi-process-steps">
            <div class="qi-process-step"><div class="qi-icon-circle">' . queer_ink_icon( 'lightbulb' ) . '</div><h4>Your Story Matters</h4><p>Every story holds value and deserves to be seen.</p></div>
            <div class="qi-process-step__arrow" aria-hidden="true">→</div>
            <div class="qi-process-step"><div class="qi-icon-circle">' . queer_ink_icon( 'pencil' ) . '</div><h4>We Shape Your Book</h4><p>Professional editing, design and production that reflect your voice and vision.</p></div>
            <div class="qi-process-step__arrow" aria-hidden="true">→</div>
            <div class="qi-process-step"><div class="qi-icon-circle">' . queer_ink_icon( 'shield' ) . '</div><h4>You Own Your Rights</h4><p>You retain full rights to your work. Always.</p></div>
            <div class="qi-process-step__arrow" aria-hidden="true">→</div>
            <div class="qi-process-step"><div class="qi-icon-circle">' . queer_ink_icon( 'rupee' ) . '</div><h4>You Earn Your Royalties</h4><p>Transparent royalties, fair terms and financial independence.</p></div>
            <div class="qi-process-step__arrow" aria-hidden="true">→</div>
            <div class="qi-process-step"><div class="qi-icon-circle">' . queer_ink_icon( 'megaphone' ) . '</div><h4>You Sustain Your Voice</h4><p>We support your journey so your voice reaches further.</p></div>
        </div>
        <div class="qi-pathway-card__tagline">
            <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'heart' ) . '</div>
            <p>Your work.<br>Your legacy.<br>Your future.<br><span>On your terms.</span></p>
        </div>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/publishing-current-list',
            array(
                'title'      => esc_html__( 'Queer Ink: Our Current List', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:group {"className":"qi-current-list"} -->
<div class="wp-block-group qi-current-list"><!-- wp:group {"className":"qi-current-list__header"} -->
<div class="wp-block-group qi-current-list__header"><!-- wp:heading -->
<h2 class="wp-block-heading">Our Current List</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"qi-current-list__view-all"} -->
<p class="qi-current-list__view-all"><a href="/books/">View all books →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[qi_latest_books]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
            )
        );

        register_block_pattern(
            'queer-ink/publishing-info-columns',
            array(
                'title'      => esc_html__( 'Queer Ink: Info Columns', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-info-columns">
    <div class="qi-info-card">
        <div class="qi-icon-circle">' . queer_ink_icon( 'star' ) . '</div>
        <h3>Beyond the Book</h3>
        <p>A book is an intellectual asset that continues to create value.</p>
        <ul>
            <li>Reach readers across the world</li>
            <li>Generate royalties</li>
            <li>Support reading, workshops and consulting</li>
            <li>Become an educational resource</li>
            <li>Create a lasting legacy</li>
        </ul>
    </div>
    <div class="qi-info-card">
        <div class="qi-icon-circle">' . queer_ink_icon( 'archive' ) . '</div>
        <h3>From Book to Archive</h3>
        <p>Today\'s books become tomorrow\'s history.</p>
        <p>Authors may choose to contribute materials such as drafts, photographs, correspondence, research notes, or interviews to the Queer India Archives.</p>
        <p>Participation is voluntary and based on informed consent.</p>
    </div>
    <div class="qi-info-card">
        <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
        <h3>Why Queer Ink?</h3>
        <ul>
            <li>Documenting queer lives and histories</li>
            <li>Upholding ethical and inclusive publishing</li>
            <li>Supporting independent authors</li>
            <li>Preserving stories for future generations</li>
            <li>Creating books that inform, inspire, and spark change</li>
        </ul>
        <p>Every book we create contributes to writing the future we deserve.</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/publishing-cta-band',
            array(
                'title'      => esc_html__( 'Queer Ink: Ready to Begin CTA', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-cta-band">
    <div class="qi-cta-band__decor qi-cta-band__decor--left" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>
    <div class="qi-cta-band__body">
        <h2>Ready to begin?</h2>
        <p>Whether you are an author or a reader, your story and your books help us preserve the past and imagine a better future.</p>
        <div class="qi-cta-band__actions">
            <a class="button button--primary" href="/books/">Explore Our Books</a>
            <a class="button button--outline" href="#pathways">Start Your Publishing Journey</a>
        </div>
    </div>
    <div class="qi-cta-band__decor qi-cta-band__decor--right" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>
</div>
<!-- /wp:html -->',
            )
        );
    }
}
add_action( 'init', 'queer_ink_register_block_patterns' );
