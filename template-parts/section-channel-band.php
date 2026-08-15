<?php
/**
 * Channel band section template part — the shared "Stay in the Loop" band
 * reused on the homepage, About and Connect pages. Keep changes here
 * generic (no page-specific copy) so all three stay identical by
 * construction.
 *
 * @package Queer_Ink_Theme
 */

$whatsapp_label = get_theme_mod( 'queer_ink_whatsapp_label', esc_html__( 'Join on WhatsApp', 'queer-ink-theme' ) );
$whatsapp_url   = get_theme_mod( 'queer_ink_whatsapp_url', esc_url( 'https://wa.me/' ) );
$telegram_label = get_theme_mod( 'queer_ink_telegram_label', esc_html__( 'Join on Telegram', 'queer-ink-theme' ) );
$telegram_url   = get_theme_mod( 'queer_ink_telegram_url', esc_url( 'https://t.me/' ) );
?>

<section class="channel-band" aria-labelledby="channel-band-title">
    <div class="channel-band__inner">
        <div class="channel-band__intro">
            <img class="channel-band__plane" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/stay-loop-plane.png' ) ); ?>" alt="" aria-hidden="true" loading="lazy">
            <h2 id="channel-band-title" class="channel-band__title">Stay in the <span>loop</span></h2>
            <span class="channel-band__rule" aria-hidden="true"></span>
            <p class="channel-band__text">Updates on books, archives, events and more.</p>
        </div>

        <div class="channel-band__channels">
            <article class="channel-card channel-card--whatsapp">
                <div class="channel-card__icon-ring">
                    <img class="channel-card__logo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/wp_logo.png' ) ); ?>" alt="" aria-hidden="true">
                </div>
                <h3 class="channel-card__title"><?php esc_html_e( 'WhatsApp Channel', 'queer-ink-theme' ); ?></h3>
                <p class="channel-card__text">Short updates, high signal. Stay connected easily.</p>
                <span class="channel-card__divider" aria-hidden="true"></span>
                <a class="button button--primary channel-card__button" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noreferrer noopener">
                    <img class="channel-card__button-icon" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/wp_logo.png' ) ); ?>" alt="" aria-hidden="true">
                    <?php echo esc_html( $whatsapp_label ); ?>
                </a>
            </article>
            <article class="channel-card channel-card--telegram">
                <div class="channel-card__icon-ring">
                    <img class="channel-card__logo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/telegram_logo.png' ) ); ?>" alt="" aria-hidden="true">
                </div>
                <h3 class="channel-card__title"><?php esc_html_e( 'Telegram Channel', 'queer-ink-theme' ); ?></h3>
                <p class="channel-card__text">In-depth updates, Searchable. For readers and archives.</p>
                <span class="channel-card__divider" aria-hidden="true"></span>
                <a class="button button--primary channel-card__button" href="<?php echo esc_url( $telegram_url ); ?>" target="_blank" rel="noreferrer noopener">
                    <img class="channel-card__button-icon" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/telegram_logo.png' ) ); ?>" alt="" aria-hidden="true">
                    <?php echo esc_html( $telegram_label ); ?>
                </a>
            </article>
        </div>

        <ul class="channel-band__points">
            <li class="channel-band__point">
                <span class="channel-band__point-icon"><?php echo queer_ink_icon( 'mail' ); ?></span>
                <span class="channel-band__point-label">No <span class="channel-band__point-highlight">newsletters.</span></span>
            </li>
            <li class="channel-band__point">
                <span class="channel-band__point-icon"><?php echo queer_ink_icon( 'no-spam' ); ?></span>
                <span class="channel-band__point-label">No <span class="channel-band__point-highlight">spam.</span></span>
            </li>
            <li class="channel-band__point">
                <span class="channel-band__point-icon"><?php echo queer_ink_icon( 'check' ); ?></span>
                <span class="channel-band__point-label">Just what <span class="channel-band__point-highlight">matters.</span></span>
            </li>
        </ul>
    </div>
</section>
