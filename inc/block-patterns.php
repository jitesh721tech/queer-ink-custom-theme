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
            'book'       => '<path d="M4 4.5A1.5 1.5 0 0 1 5.5 3H12v18H5.5A1.5 1.5 0 0 1 4 19.5v-15Z"/><path d="M20 4.5A1.5 1.5 0 0 0 18.5 3H12v18h6.5a1.5 1.5 0 0 0 1.5-1.5v-15Z"/>',
            'sun'        => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8 6 18M18 6l1.8-1.8"/>',
            'clock'      => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7v5l3.5 2"/>',
            'search'     => '<circle cx="10.5" cy="10.5" r="6.5"/><path d="m20 20-4.35-4.35"/>',
            'globe'      => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5c2.5 2.4 3.8 5.4 3.8 8.5s-1.3 6.1-3.8 8.5c-2.5-2.4-3.8-5.4-3.8-8.5S9.5 5.9 12 3.5Z"/>',
            'infinity'   => '<path d="M7 9.5a3.3 3.3 0 1 0 0 5c1.2 0 2-.6 3-1.7l1-1.1 1-1.1c1-1.1 1.8-1.7 3-1.7a3.3 3.3 0 1 1 0 5c-1.2 0-2-.6-3-1.7l-1-1.1-1-1.1c-1-1.1-1.8-1.7-3-1.7Z"/>',
            'bookmark'   => '<path d="M6 3.5h12a1 1 0 0 1 1 1V21l-7-4-7 4V4.5a1 1 0 0 1 1-1Z"/>',
            'download'   => '<path d="M12 3.5v11M8 11l4 4 4-4"/><path d="M4.5 17v2.5a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1V17"/>',
            'message'    => '<path d="M4 5.5h16a1 1 0 0 1 1 1V16a1 1 0 0 1-1 1H9l-4.5 4V17H4a1 1 0 0 1-1-1V6.5a1 1 0 0 1 1-1Z"/>',
            'chart'      => '<path d="M4 20V10M10 20V4M16 20v-7M3 20h18"/>',
            'paper-plane' => '<path d="M21 3 3 10.5l7 2.5m11-10L13.5 21l-3-8m0 0 10.5-10Z"/>',
            'quote'      => '<path d="M7 8.5c-2 1-3 2.7-3 5.2 0 1.9 1.2 3.3 3 3.3s3-1.3 3-3.1c0-1.6-1-2.7-2.4-2.9.2-1.3 1.2-2.6 2.9-3.3L7 8.5Zm10 0c-2 1-3 2.7-3 5.2 0 1.9 1.2 3.3 3 3.3s3-1.3 3-3.1c0-1.6-1-2.7-2.4-2.9.2-1.3 1.2-2.6 2.9-3.3L17 8.5Z"/>',
            'mail'       => '<rect x="3.5" y="5.5" width="17" height="13" rx="1.5"/><path d="m4 6.5 8 6 8-6"/>',
            'location'   => '<path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/>',
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
        $publishing_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/publishing_hero.png' ) );
        $archiving_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/archiving_hero.png' ) );
        $digital_library_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/digital_library_hero.png' ) );
        $qi_journal_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/qi_journal_hero.png' ) );
        $about_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/about_hero.png' ) );
        $about_founder_image = esc_url( get_theme_file_uri( 'assets/images/sections/about_admin_img.jfif' ) );
        $connect_hero_image = esc_url( get_theme_file_uri( 'assets/images/hero/connect_hero.png' ) );

        // Site-relative destination URLs, resolved through home_url() so links
        // still work when WordPress is installed in a subdirectory (e.g. /queer-ink/).
        $url_books           = esc_url( home_url( '/books/' ) );
        $url_connect         = esc_url( home_url( '/connect/' ) );
        $url_journal         = esc_url( home_url( '/journal/' ) );
        $url_qi_journal      = esc_url( home_url( '/qi-journal/' ) );
        $url_about           = esc_url( home_url( '/about/' ) );
        $url_publishing      = esc_url( home_url( '/publishing/' ) );
        $url_archiving       = esc_url( home_url( '/archiving/' ) );
        $url_digital_library = esc_url( home_url( '/digital-library/' ) );
        $url_home            = esc_url( home_url( '/' ) );

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
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="{$url_books}">Explore Publications</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#pathways">Our Publishing Approach</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image"><img src="{$publishing_hero_image}" alt="Queer Ink published books"/></figure>
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
        <a class="qi-pathway-card__link" href="' . $url_books . '">Explore Archive Publications →</a>
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
<p class="qi-current-list__view-all"><a href="' . $url_books . '">View all books →</a></p>
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
            <a class="button button--primary" href="' . $url_books . '">Explore Our Books</a>
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

        register_block_pattern(
            'queer-ink/archiving-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: Archiving Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero qi-arc-hero"} -->
<div class="wp-block-group qi-pub-hero qi-arc-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">ARCHIVING PATHWAY</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Preserve your story. Protect your history. <span style="color:#c0185b">Build our collective memory.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The Archiving Pathway helps individuals, families, organisations and communities preserve the stories, records and memories that shape our collective history. Through ethical, relationship-centred archiving, we ensure today's lives remain discoverable for future generations.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"qi-arc-hero__note"} -->
<p class="qi-arc-hero__note"><em>Established 2023. Oral histories, photographs, correspondence, organisational records, zines, newsletters, ephemera, legal documents, and creative work — held in trust for the future.</em></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#connections">Explore the Archive</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="{$url_connect}">Contribute to the Archive</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image"><img src="{$archiving_hero_image}" alt="Queer India Archives"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/archiving-timeline',
            array(
                'title'      => esc_html__( 'Queer Ink: Journey Through Time', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-timeline">
    <div class="qi-timeline__header">
        <div>
            <h2>Our Journey Through Time</h2>
            <p class="qi-timeline__intro">' . queer_ink_icon( 'clock' ) . ' Milestones of queer lives, movements and memories in India.</p>
        </div>
        <a class="button button--outline" href="' . $url_journal . '">View Full Timeline →</a>
    </div>
    <div class="qi-timeline__track">
        <button type="button" class="qi-timeline__nav qi-timeline__nav--prev" data-scroll-prev aria-label="Scroll to earlier milestones">‹</button>
        <div class="qi-timeline__scroller" data-scroller>
            <div class="qi-timeline__item">
                <span class="qi-timeline__year">1994</span>
                <div class="qi-timeline__dot" aria-hidden="true"></div>
                <div class="qi-timeline__card">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'book' ) . '</div>
                    <h3>Bombay Dost is launched</h3>
                    <p>India\'s first queer magazine creates a space where people discover they are not alone.</p>
                    <a class="qi-pathway-card__link" href="' . $url_journal . '">Explore →</a>
                </div>
            </div>
            <div class="qi-timeline__item">
                <span class="qi-timeline__year">2001</span>
                <div class="qi-timeline__dot" aria-hidden="true"></div>
                <div class="qi-timeline__card">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
                    <h3>Humsafar Trust is formed</h3>
                    <p>Community-led organisation advances health, rights and dignity for LGBTQIA+ people.</p>
                    <a class="qi-pathway-card__link" href="' . $url_journal . '">Explore →</a>
                </div>
            </div>
            <div class="qi-timeline__item">
                <span class="qi-timeline__year">2003</span>
                <div class="qi-timeline__dot" aria-hidden="true"></div>
                <div class="qi-timeline__card">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'heart' ) . '</div>
                    <h3>Sangini begins peer support meetings</h3>
                    <p>A safe space for queer women to share experiences and support one another.</p>
                    <a class="qi-pathway-card__link" href="' . $url_journal . '">Explore →</a>
                </div>
            </div>
            <div class="qi-timeline__item">
                <span class="qi-timeline__year">2009</span>
                <div class="qi-timeline__dot" aria-hidden="true"></div>
                <div class="qi-timeline__card">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'shield' ) . '</div>
                    <h3>Delhi High Court reads down Section 377</h3>
                    <p>A landmark moment in the legal fight for equality and human rights.</p>
                    <a class="qi-pathway-card__link" href="' . $url_journal . '">Explore →</a>
                </div>
            </div>
            <div class="qi-timeline__item">
                <span class="qi-timeline__year">2014</span>
                <div class="qi-timeline__dot" aria-hidden="true"></div>
                <div class="qi-timeline__card">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'star' ) . '</div>
                    <h3>Delhi Queer Pride begins</h3>
                    <p>A powerful celebration of visibility, community and collective pride.</p>
                    <a class="qi-pathway-card__link" href="' . $url_journal . '">Explore →</a>
                </div>
            </div>
        </div>
        <button type="button" class="qi-timeline__nav qi-timeline__nav--next" data-scroll-next aria-label="Scroll to later milestones">›</button>
    </div>
    <p class="qi-timeline__footer">' . queer_ink_icon( 'heart' ) . ' Many more stories. Many more connections. Our journey continues.</p>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/archiving-why',
            array(
                'title'      => esc_html__( 'Queer Ink: Why Archive', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-why-archive">
    <div class="qi-why-archive__intro">
        <h2>Why Archive?</h2>
        <p>Stories disappear every day. Photographs fade. Letters are discarded. Digital files become inaccessible. Memories are lost.</p>
        <p class="qi-why-archive__callout">Archiving is how we honour our lives, our relationships, our movements—and make sure future generations can understand where they came from.</p>
    </div>
    <div class="qi-why-archive__grid">
        <div class="qi-why-archive__card">
            <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
            <h3>Lives are lived.</h3>
            <p>Every life holds memories worth preserving.</p>
        </div>
        <div class="qi-why-archive__card">
            <div class="qi-icon-circle">' . queer_ink_icon( 'book' ) . '</div>
            <h3>Histories are made.</h3>
            <p>Communities create knowledge, culture and change.</p>
        </div>
        <div class="qi-why-archive__card">
            <div class="qi-icon-circle">' . queer_ink_icon( 'archive' ) . '</div>
            <h3>Records are fragile.</h3>
            <p>Without care, they can be lost forever.</p>
        </div>
        <div class="qi-why-archive__card">
            <div class="qi-icon-circle">' . queer_ink_icon( 'sun' ) . '</div>
            <h3>Futures are possible.</h3>
            <p>Archives connect us to those who come next.</p>
        </div>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/archiving-connections',
            array(
                'title'      => esc_html__( 'Queer Ink: Our Connections', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:group {"className":"qi-current-list qi-connections","anchor":"connections"} -->
<div class="wp-block-group qi-current-list qi-connections" id="connections"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"66%"} -->
<div class="wp-block-column" style="flex-basis:66%"><!-- wp:heading -->
<h2 class="wp-block-heading">Our Connections</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Collections are built in relationship with individuals and communities. As archival material is processed and consent is confirmed, the books and articles that grow out of it appear here.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"34%"} -->
<div class="wp-block-column qi-connections__request" style="flex-basis:34%"><!-- wp:html -->
<div class="qi-connections__request-card">
    <h3>Request to View a Collection</h3>
    <p>Some collections are sensitive or restricted. You can request access by filling out a short form. We will respond as soon as possible.</p>
    <a class="button button--primary" href="' . $url_connect . '">Request Access</a>
</div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:heading {"level":3,"className":"qi-connections__subhead"} -->
<h3 class="wp-block-heading qi-connections__subhead">Books from the Archive</h3>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[qi_latest_books count="4"]
<!-- /wp:shortcode -->

<!-- wp:heading {"level":3,"className":"qi-connections__subhead"} -->
<h3 class="wp-block-heading qi-connections__subhead">Articles from the Archive</h3>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[qi_latest_articles count="4"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
            )
        );

        register_block_pattern(
            'queer-ink/archiving-model',
            array(
                'title'      => esc_html__( 'Queer Ink: Relationship-Centred Archiving', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-model">
    <div class="qi-model__intro">
        <h2>Relationship-Centred Archiving</h2>
        <p>Archives are not built from collections. They are built from relationships.</p>
        <p>Every item in our archive carries relationships—between individuals, families, communities, organisations, movements and moments in time.</p>
        <p>We work collaboratively with contributors to ensure that context, consent, identity and future access remain connected to every story.</p>
        <a class="qi-pathway-card__link" href="' . $url_connect . '">Our Principles →</a>
    </div>
    <div class="qi-model__diagram">
        <p class="qi-model__diagram-lead">Instead of asking &ldquo;What should we collect?&rdquo; we begin by asking, &ldquo;Whose relationships are we preserving, and for whom?&rdquo;</p>
        <div class="qi-model__steps">
            <div class="qi-model__step">
                <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
                <h4>1. Relationship</h4>
                <p class="qi-model__step-caption">The human context.</p>
                <ul>
                    <li>People</li>
                    <li>Communities</li>
                    <li>Families</li>
                    <li>Organisations</li>
                    <li>Places</li>
                    <li>Moments in time</li>
                </ul>
            </div>
            <div class="qi-model__arrow" aria-hidden="true">→</div>
            <div class="qi-model__step">
                <div class="qi-icon-circle">' . queer_ink_icon( 'archive' ) . '</div>
                <h4>2. Evidence</h4>
                <p class="qi-model__step-caption">The tangible record.</p>
                <ul>
                    <li>Documents &amp; letters</li>
                    <li>Diaries</li>
                    <li>Photographs</li>
                    <li>Publications</li>
                    <li>Audio &amp; video</li>
                    <li>Digital files &amp; records</li>
                    <li>Ephemera</li>
                </ul>
            </div>
            <div class="qi-model__arrow" aria-hidden="true">→</div>
            <div class="qi-model__step">
                <div class="qi-icon-circle">' . queer_ink_icon( 'search' ) . '</div>
                <h4>3. Discovery</h4>
                <p class="qi-model__step-caption">The future.</p>
                <ul>
                    <li>Metadata &amp; search</li>
                    <li>Research &amp; education</li>
                    <li>Digital preservation</li>
                    <li>Ethical access</li>
                </ul>
            </div>
        </div>
        <p class="qi-model__diagram-footer">When evidence is preserved within relationships—and made discoverable for the future—archives become living sources of knowledge, connection and change.</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/archiving-cta-band',
            array(
                'title'      => esc_html__( 'Queer Ink: Archiving Ready CTA', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-cta-band">
    <div class="qi-cta-band__decor qi-cta-band__decor--left" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>
    <div class="qi-cta-band__body">
        <h2>Ready to preserve your story?</h2>
        <p>Whether you hold a single letter or a lifetime of records, your story helps build our collective memory.</p>
        <div class="qi-cta-band__actions">
            <a class="button button--primary" href="' . $url_connect . '">Contribute to the Archive</a>
            <a class="button button--outline" href="#connections">Explore the Collections</a>
        </div>
    </div>
    <div class="qi-cta-band__decor qi-cta-band__decor--right" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: Digital Library Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero"} -->
<div class="wp-block-group qi-pub-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">DIGITAL LIBRARY</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Queer knowledge. Open access. <span style="color:#c0185b">Shared futures.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The Queer Ink Digital Library (QIDL) is a curated space for queer Indian writings, histories, art, and ideas. Read, research, learn and be inspired — anytime, anywhere.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#featured-books">Browse the Library</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="{$url_about}">About the Library</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image"><img src="{$digital_library_hero_image}" alt="Queer Ink Digital Library"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-pillars',
            array(
                'title'      => esc_html__( 'Queer Ink: Digital Library Pillars', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-dl-pillars">
    <div class="qi-dl-pillar">
        <div class="qi-icon-circle">' . queer_ink_icon( 'book' ) . '</div>
        <h3>Curated with Care</h3>
        <p>Thoughtfully curated content from archives, publishers, researchers and communities.</p>
    </div>
    <div class="qi-dl-pillar">
        <div class="qi-icon-circle">' . queer_ink_icon( 'shield' ) . '</div>
        <h3>Ethical &amp; Inclusive</h3>
        <p>We uphold consent, privacy and community ownership in every resource we share.</p>
    </div>
    <div class="qi-dl-pillar">
        <div class="qi-icon-circle">' . queer_ink_icon( 'globe' ) . '</div>
        <h3>Accessible for All</h3>
        <p>Multi-format, multi-language resources that you can access from anywhere.</p>
    </div>
    <div class="qi-dl-pillar">
        <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
        <h3>Community Powered</h3>
        <p>Built through collaborations and contributions from across our communities.</p>
    </div>
    <div class="qi-dl-pillar">
        <div class="qi-icon-circle">' . queer_ink_icon( 'star' ) . '</div>
        <h3>For Today, For Tomorrow</h3>
        <p>Preserving our past and creating knowledge for future generations.</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-featured-books',
            array(
                'title'      => esc_html__( 'Queer Ink: Featured Books', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:group {"className":"qi-current-list","anchor":"featured-books"} -->
<div class="wp-block-group qi-current-list" id="featured-books"><!-- wp:group {"className":"qi-current-list__header"} -->
<div class="wp-block-group qi-current-list__header"><!-- wp:heading -->
<h2 class="wp-block-heading">Featured Books</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"qi-current-list__view-all"} -->
<p class="qi-current-list__view-all"><a href="' . $url_books . '">View all books →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="qi-dl-scroller-track">
    <button type="button" class="qi-timeline__nav qi-timeline__nav--prev" data-scroll-prev aria-label="Scroll to previous books">‹</button>
    <div class="qi-dl-books-scroller" data-scroller>
    <!-- /wp:html -->

<!-- wp:shortcode -->
[qi_latest_books count="8"]
<!-- /wp:shortcode -->

<!-- wp:html -->
    </div>
    <button type="button" class="qi-timeline__nav qi-timeline__nav--next" data-scroll-next aria-label="Scroll to more books">›</button>
</div>
<!-- /wp:html --></div>
<!-- /wp:group -->',
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-subjects',
            array(
                'title'      => esc_html__( 'Queer Ink: Browse by Subjects', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:group {"className":"qi-current-list"} -->
<div class="wp-block-group qi-current-list"><!-- wp:group {"className":"qi-current-list__header"} -->
<div class="wp-block-group qi-current-list__header"><!-- wp:heading -->
<h2 class="wp-block-heading">Browse by Subjects</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"qi-current-list__view-all"} -->
<p class="qi-current-list__view-all"><a href="' . $url_books . '">View all books →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[qi_subjects]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-reading-room',
            array(
                'title'      => esc_html__( 'Queer Ink: Join the Reading Room', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-reading-room">
    <div class="qi-reading-room__media" aria-hidden="true">
        <div class="qi-reading-room__media-circle"></div>
        <div class="qi-reading-room__media-books">
            <span></span><span></span><span></span>
        </div>
    </div>
    <div class="qi-reading-room__body">
        <p class="hero__eyebrow">READ WITHOUT BARRIERS</p>
        <h2>Join the <span style="color:#c0185b">Reading Room</span></h2>
        <p>Unlock unlimited access to the Digital Library, exclusive content, early releases and members-only resources.</p>
        <div class="qi-reading-room__features">
            <div class="qi-reading-room__feature"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'infinity' ) . '</div><span>Unlimited access to the library</span></div>
            <div class="qi-reading-room__feature"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'bookmark' ) . '</div><span>Save, bookmark and organise</span></div>
            <div class="qi-reading-room__feature"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'download' ) . '</div><span>Download to read offline</span></div>
            <div class="qi-reading-room__feature"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'star' ) . '</div><span>New content added regularly</span></div>
        </div>
        <div class="qi-reading-room__actions">
            <a class="button button--primary" href="' . $url_connect . '">Choose a Plan</a>
            <a class="button button--outline" href="' . $url_about . '">Learn More</a>
        </div>
    </div>
    <div class="qi-reading-room__quote">
        <p>&ldquo;The archive is not just where we keep our history — it is where we shape our futures.&rdquo;</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/digital-library-tagline',
            array(
                'title'      => esc_html__( 'Queer Ink: Digital Library Tagline', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-dl-tagline">
    <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'heart' ) . '</div>
    <div>
        <h2>Your stories. Our archive. Our future.</h2>
        <p>Every resource, every contribution, every read — keeps our history alive.</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/qi-journal-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: QI Journal Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero"} -->
<div class="wp-block-group qi-pub-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">QI JOURNAL</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Stories. Ideas. Voices that <span style="color:#c0185b">move us.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Reflections, research, conversations and resources from the Queer Ink community and beyond.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="{$url_connect}">Share Your Story</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image"><img src="{$qi_journal_hero_image}" alt="Queer Ink Journal"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/qi-journal-filter-bar',
            array(
                'title'      => esc_html__( 'Queer Ink: Journal Filter Bar', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-filter-bar">
    <div class="qi-filter-bar__tabs">[qi_article_sections]</div>
    <div class="qi-filter-bar__controls">
        [qi_subjects_dropdown]
        <form class="qi-search-form" role="search" method="get" action="' . $url_home . '">
            <input type="hidden" name="post_type" value="qi_article" />
            <label class="screen-reader-text" for="qi-journal-search">' . esc_html__( 'Search articles', 'queer-ink-theme' ) . '</label>
            <input id="qi-journal-search" type="search" name="s" placeholder="' . esc_attr__( 'Search articles...', 'queer-ink-theme' ) . '" />
            <button type="submit" aria-label="' . esc_attr__( 'Search', 'queer-ink-theme' ) . '">' . queer_ink_icon( 'search' ) . '</button>
        </form>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/qi-journal-content',
            array(
                'title'      => esc_html__( 'Queer Ink: Journal Articles + Sidebar', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:columns {"className":"qi-journal-layout"} -->
<div class="wp-block-columns qi-journal-layout"><!-- wp:column {"width":"68%","className":"qi-journal-main"} -->
<div class="wp-block-column qi-journal-main" style="flex-basis:68%"><!-- wp:shortcode -->
[qi_latest_articles count="6"]
<!-- /wp:shortcode -->

<!-- wp:html -->
<p class="qi-journal-load-more"><a class="button button--outline" href="' . $url_journal . '">Load More Articles</a></p>
<!-- /wp:html --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"32%","className":"qi-journal-sidebar"} -->
<div class="wp-block-column qi-journal-sidebar" style="flex-basis:32%"><!-- wp:html -->
<div class="qi-journal-widget">
    <h3>About QI Journal</h3>
    <p>QI Journal is a space for queer perspectives, research, community voices and resources that deepen our understanding of our pasts and imagine our futures.</p>
    <a class="qi-pathway-card__link" href="' . $url_about . '">Learn more about our work →</a>
</div>
<div class="qi-journal-widget">
    <h3>Popular Topics</h3>
    [qi_subjects style="list" count="6"]
</div>
<div class="qi-journal-widget">
    <h3>Stay in the Loop</h3>
    <p>Get updates on books, archives, events and more.</p>
    <div class="qi-journal-channel">
        <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'message' ) . '</div>
        <div>
            <strong>WhatsApp Channel</strong>
            <p>Short updates. High signal. Stay connected easily.</p>
            <a class="qi-journal-channel__link" href="' . $url_connect . '">Join on WhatsApp ↗</a>
        </div>
    </div>
    <div class="qi-journal-channel">
        <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'message' ) . '</div>
        <div>
            <strong>Telegram Channel</strong>
            <p>In-depth updates. Searchable. For readers and archives.</p>
            <a class="qi-journal-channel__link" href="' . $url_connect . '">Join on Telegram ↗</a>
        </div>
    </div>
    <p class="qi-journal-widget__note">No newsletters. No spam. Just what matters.</p>
</div>
<!-- /wp:html --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
            )
        );

        register_block_pattern(
            'queer-ink/qi-journal-cta-band',
            array(
                'title'      => esc_html__( 'Queer Ink: Journal CTA', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-journal-cta">
    <div class="qi-journal-cta__body">
        <h2>Your experiences strengthen our archive.</h2>
        <p>Share your story, research or reflections with a community that listens, learns and builds together.</p>
        <a class="button button--primary" href="' . $url_connect . '">Write for QI Journal</a>
    </div>
    <div class="qi-journal-cta__icons">
        <div class="qi-journal-cta__icon-item"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'pencil' ) . '</div><span>Share your story</span></div>
        <div class="qi-journal-cta__icon-item"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'book' ) . '</div><span>Expand our knowledge</span></div>
        <div class="qi-journal-cta__icon-item"><div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'users' ) . '</div><span>Build our future</span></div>
    </div>
</div>
<!-- /wp:html -->',
            )
        );
        register_block_pattern(
            'queer-ink/about-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: About Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero qi-about-hero"} -->
<div class="wp-block-group qi-pub-hero qi-about-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">ABOUT QUEER INK</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">An independent publisher, archive, and library, in Mumbai, <span style="color:#c0185b">since 2010.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Founded by Shobhna S Kumar in 2010 as India's first online queer bookstore. Today, a five-part ecosystem holding queer Indian lives in print, on record, in conversation, and in the writing happening now.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image qi-about-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image qi-about-hero__image"><img src="{$about_hero_image}" alt="Queer Ink — publisher, archive and library since 2010"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/about-what-we-do',
            array(
                'title'      => esc_html__( 'Queer Ink: What We Do', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-about-wwd">
    <div class="qi-about-wwd__intro">
        <h2>What we do.</h2>
        <p>We hold queer Indian lives — through publishing, archives, a digital library, a public knowledge exchange, and editorial writing.</p>
    </div>
    <div class="qi-about-wwd__grid">
        <a class="qi-about-wwd__col" href="' . $url_publishing . '">
            <div class="qi-icon-circle">' . queer_ink_icon( 'book' ) . '</div>
            <h3>The Publishing Imprint</h3>
            <p>Issues books drawn from the Queer India Archives — anthologies, edited collections, and oral histories shaped into book form. A self-publishing accelerator, the Storytellers Studio, also supports independent authors to publish their own work through mentorship and crowdfund-led publication.</p>
        </a>
        <a class="qi-about-wwd__col" href="' . $url_archiving . '">
            <div class="qi-icon-circle">' . queer_ink_icon( 'archive' ) . '</div>
            <h3>The Queer India Archives</h3>
            <p>Preserves oral histories, photographs, correspondence, organisational records, zines, ephemera and material culture from queer Indian lives and movements — held in trust, on terms set by contributors.</p>
        </a>
        <a class="qi-about-wwd__col" href="' . $url_digital_library . '">
            <div class="qi-icon-circle">' . queer_ink_icon( 'globe' ) . '</div>
            <h3>The Queer Ink Digital Library</h3>
            <p>Makes queer Indian literature and history searchable, public-facing and openly accessible — books, documents, oral histories, films and curated collections, for readers, researchers, students and community members anywhere.</p>
        </a>
        <a class="qi-about-wwd__col" href="' . $url_qi_journal . '">
            <div class="qi-icon-circle">' . queer_ink_icon( 'message' ) . '</div>
            <h3>Qblog</h3>
            <p>Is the editorial writing space — Shobhna\'s reflections, essays, and notes from inside the work.</p>
        </a>
        <a class="qi-about-wwd__col" href="' . $url_connect . '">
            <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
            <h3>QConversations</h3>
            <p>Is the public knowledge exchange — a sustained practice of public posts, free engagement on social platforms, and paid private consultations for focused thinking.</p>
        </a>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/about-why',
            array(
                'title'      => esc_html__( 'Queer Ink: Why We Work This Way', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-about-why">
    <div class="qi-about-why__body">
        <h2>Why we work this way.</h2>
        <p>Queer Indian lives have been documented sporadically, preserved occasionally, and included in the country\'s official record almost never. What has been kept has often been kept by chance.</p>
        <p>Queer Ink exists to change that — not through any single act, but through sustained, considered, long-horizon work. Books that take years to produce. Archives built on terms set by the communities they record. A library designed to be findable in a world that is narrowing access. A blog that adds the missing perspective. Conversations that keep getting asked.</p>
        <p>The work is small, slow, and independent by choice. It is funded, in part, by readers, patrons, and reciprocity — never by advertising, never by sources that would compromise contributor trust. It is produced by one person, for now, with collaborators when the work calls for them.</p>
        <p>It is, deliberately, the kind of cultural work that serves a generation rather than a season.</p>
    </div>
    <div class="qi-about-why__quote">
        <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'quote' ) . '</div>
        <p>Our voices shatter the silence we inherited, so the future must never know the choice of the closet.</p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/about-founder',
            array(
                'title'      => esc_html__( 'Queer Ink: Founder', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-about-founder">
    <div class="qi-about-founder__media">
        <img src="' . $about_founder_image . '" alt="Shobhna S Kumar, founder of Queer Ink"/>
    </div>
    <div class="qi-about-founder__body">
        <h2>Shobhna S Kumar — founder.</h2>
        <p>Shobhna S Kumar founded Queer Ink in 2010 as India\'s first online queer bookstore. In 2012 she published <em>Out! Stories from the New Queer India</em>, edited by Minal Hajratwala — Queer Ink\'s first book, the foundational anthology of contemporary queer Indian writing.</p>
        <p>Born in Fiji and raised partly in Australia, she settled in India in 2002. She is a publisher, archivist, and editor whose work over fifteen years has held queer Indian lives in print, on record, and in conversation.</p>
        <p>She lives and works in Mumbai. Contact: <a href="mailto:shobhna@queer-ink.com">shobhna@queer-ink.com</a></p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/about-info-row',
            array(
                'title'      => esc_html__( 'Queer Ink: Team, Press & Annual Report', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-about-info-row">
    <div class="qi-about-info-col">
        <div class="qi-icon-circle">' . queer_ink_icon( 'users' ) . '</div>
        <h3>Team.</h3>
        <p>Queer Ink is a sole-trader practice — Shobhna at its centre, with collaborators brought in for specific work. Editors, designers, translators, researchers, and archival specialists work with the imprint and the Archives on a project basis. The work is small by design.</p>
        <p>If you would like to work with Queer Ink in a specialist capacity — editorial, archival, design, translation, research — write to <a href="mailto:shobhna@queer-ink.com">shobhna@queer-ink.com</a> with a brief note about your work and what calls you to ours.</p>
    </div>
    <div class="qi-about-info-col">
        <div class="qi-icon-circle">' . queer_ink_icon( 'megaphone' ) . '</div>
        <h3>Press and media.</h3>
        <p>Press inquiries, interview requests, photograph requests, and media partnerships: please write to <a href="mailto:shobhna@queer-ink.com">shobhna@queer-ink.com</a> with the subject line PRESS — (your publication).</p>
        <p>A press kit, including high-resolution photographs of Shobhna, the Queer Ink logo files, and brief organisational descriptions in a range of lengths, is available on request.</p>
        <p>For book reviews, please contact us for review copies of any titles in the catalogue.</p>
    </div>
    <div class="qi-about-info-col">
        <div class="qi-icon-circle">' . queer_ink_icon( 'chart' ) . '</div>
        <h3>Annual report.</h3>
        <p>Queer Ink publishes an annual report each April, marking the imprint\'s founding date. The report covers the year\'s work — books published, archive collections expanded, library growth, QConversations engagement, and finances at a level appropriate to a small independent organisation.</p>
        <p class="qi-about-info-col__reports">Read the annual reports: <a href="mailto:shobhna@queer-ink.com">2025 (PDF)</a> &middot; <a href="mailto:shobhna@queer-ink.com">2024 (PDF)</a> &middot; <a href="mailto:shobhna@queer-ink.com">2023 (PDF)</a></p>
        <p><a href="mailto:shobhna@queer-ink.com">Earlier reports on request</a></p>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/about-stay-loop',
            array(
                'title'      => esc_html__( 'Queer Ink: Stay in the Loop', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-stay-loop">
    <div class="qi-stay-loop__intro">
        <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'paper-plane' ) . '</div>
        <div>
            <h3>Stay in the loop</h3>
            <p>Updates on books, archives, events and more.</p>
        </div>
    </div>
    <div class="qi-stay-loop__channels">
        <div class="qi-stay-loop__channel">
            <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'message' ) . '</div>
            <div>
                <strong>WhatsApp Channel</strong>
                <p>Short updates. High signal. Stay connected easily.</p>
                <a class="button button--primary qi-stay-loop__join" href="' . $url_connect . '">Join on WhatsApp ↗</a>
            </div>
        </div>
        <div class="qi-stay-loop__channel">
            <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'message' ) . '</div>
            <div>
                <strong>Telegram Channel</strong>
                <p>In-depth updates. Searchable. For readers and archives.</p>
                <a class="button button--primary qi-stay-loop__join" href="' . $url_connect . '">Join on Telegram ↗</a>
            </div>
        </div>
    </div>
    <div class="qi-stay-loop__note">
        <p>No newsletters.<br>No spam.<br>Just what matters.</p>
        <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'heart' ) . '</div>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/connect-hero',
            array(
                'title'      => esc_html__( 'Queer Ink: Connect Hero', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => <<<HTML
<!-- wp:group {"className":"qi-pub-hero qi-connect-hero"} -->
<div class="wp-block-group qi-pub-hero qi-connect-hero"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"hero__eyebrow"} -->
<p class="hero__eyebrow">CONNECT WITH QUEER INK</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Let's connect. Let's create <span style="color:#c0185b">change.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Queer Ink is a relationship-centred initiative. We welcome conversations, collaborations, contributions and community.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"className":"qi-pub-hero__image qi-connect-hero__image"} -->
<figure class="wp-block-image qi-pub-hero__image qi-connect-hero__image"><img src="{$connect_hero_image}" alt="People connecting with Queer Ink"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
HTML
                ,
            )
        );

        register_block_pattern(
            'queer-ink/connect-contact',
            array(
                'title'      => esc_html__( 'Queer Ink: Connect Contact', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-connect-contact">
    <div class="qi-connect-card qi-connect-form">
        <h2>Send us a message</h2>
        <p>We read every message. We\'ll get back to you as soon as we can.</p>
        <form class="qi-connect-form__form" method="post" action="">
            <div class="qi-connect-form__row">
                <div class="qi-connect-form__field">
                    <label class="screen-reader-text" for="qi-connect-name">Your Name</label>
                    <input type="text" id="qi-connect-name" name="your-name" placeholder="Your Name" autocomplete="name" required>
                </div>
                <div class="qi-connect-form__field">
                    <label class="screen-reader-text" for="qi-connect-email">Your Email</label>
                    <input type="email" id="qi-connect-email" name="your-email" placeholder="Your Email" autocomplete="email" required>
                </div>
            </div>
            <div class="qi-connect-form__field">
                <label class="screen-reader-text" for="qi-connect-subject">What is this regarding?</label>
                <select id="qi-connect-subject" name="subject">
                    <option value="">What is this regarding?</option>
                    <option value="general">General inquiry</option>
                    <option value="collaboration">Collaboration</option>
                    <option value="archive">Archive contribution</option>
                    <option value="press">Press &amp; media</option>
                    <option value="other">Something else</option>
                </select>
            </div>
            <div class="qi-connect-form__field">
                <label class="screen-reader-text" for="qi-connect-message">Your Message</label>
                <textarea id="qi-connect-message" name="message" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <label class="qi-connect-form__consent">
                <input type="checkbox" name="consent" required>
                <span>I agree to the <a href="#">Privacy Policy</a></span>
            </label>
            <button type="submit" class="button button--primary">Send Message</button>
        </form>
    </div>
    <div class="qi-connect-card qi-connect-info">
        <h2>Other ways to reach us</h2>
        <div class="qi-connect-info__grid">
            <div class="qi-connect-info__col">
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'mail' ) . '</div>
                    <div>
                        <strong>Email</strong>
                        <p><a href="mailto:info@queer-ink.com">info@queer-ink.com</a></p>
                    </div>
                </div>
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle"><img src="' . esc_url( get_theme_file_uri( 'assets/images/social/instagram.png' ) ) . '" alt="" aria-hidden="true"></div>
                    <div>
                        <strong>Instagram</strong>
                        <p><a href="https://instagram.com/queer.ink" target="_blank" rel="noreferrer noopener">@queer.ink</a></p>
                    </div>
                </div>
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle"><img src="' . esc_url( get_theme_file_uri( 'assets/images/social/facebook.png' ) ) . '" alt="" aria-hidden="true"></div>
                    <div>
                        <strong>Facebook</strong>
                        <p><a href="https://facebook.com/queerinkbooks" target="_blank" rel="noreferrer noopener">@queerinkbooks</a></p>
                    </div>
                </div>
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle">' . queer_ink_icon( 'location' ) . '</div>
                    <div>
                        <strong>Based in Mumbai, India</strong>
                        <p>Working with communities across India and beyond.</p>
                    </div>
                </div>
            </div>
            <div class="qi-connect-info__col">
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'clock' ) . '</div>
                    <div>
                        <strong>Our response time</strong>
                        <p>We usually respond within 2–3 working days.</p>
                    </div>
                </div>
                <div class="qi-connect-info__item">
                    <div class="qi-icon-circle qi-icon-circle--accent">' . queer_ink_icon( 'globe' ) . '</div>
                    <div>
                        <strong>Languages</strong>
                        <p>We communicate in English and Hindi. Some resources are available in other Indian languages.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wp:html -->',
            )
        );

        register_block_pattern(
            'queer-ink/connect-together-cta',
            array(
                'title'      => esc_html__( 'Queer Ink: Let\'s Build This Together CTA', 'queer-ink-theme' ),
                'categories' => array( 'queer-ink' ),
                'content'    => '<!-- wp:html -->
<div class="qi-cta-band">
    <div class="qi-cta-band__decor qi-cta-band__decor--left" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>
    <div class="qi-cta-band__body">
        <h2>Let\'s build this <span style="color:#c0185b">together.</span></h2>
        <p>Queer Ink exists because of a community that believes in the power of stories, archives and knowledge to transform lives. Whether you have a story to share, a resource to offer, or an idea to explore — we\'d love to hear from you.</p>
        <div class="qi-cta-band__actions">
            <a class="button button--primary" href="mailto:info@queer-ink.com?subject=Share%20Your%20Story">Share Your Story</a>
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
