<?php
/**
 * Channel band section template part.
 *
 * @package Queer_Ink_Theme
 */

$band_title        = get_theme_mod( 'queer_ink_channel_band_title', esc_html__( 'Join the conversation', 'queer-ink-theme' ) );
$band_description  = get_theme_mod( 'queer_ink_channel_band_description', esc_html__( 'Sign up for updates, research dispatches, and conversations from our archive communities.', 'queer-ink-theme' ) );
$whatsapp_label    = get_theme_mod( 'queer_ink_whatsapp_label', esc_html__( 'Join on WhatsApp', 'queer-ink-theme' ) );
$whatsapp_url      = get_theme_mod( 'queer_ink_whatsapp_url', esc_url( 'https://wa.me/' ) );
$telegram_label    = get_theme_mod( 'queer_ink_telegram_label', esc_html__( 'Join on Telegram', 'queer-ink-theme' ) );
$telegram_url      = get_theme_mod( 'queer_ink_telegram_url', esc_url( 'https://t.me/' ) );
$reassurance_text  = get_theme_mod( 'queer_ink_channel_band_reassurance', esc_html__( 'We share respectful, archive-first dispatches. No spam, only inclusive community notices.', 'queer-ink-theme' ) );
?>

<section class="channel-band" aria-labelledby="channel-band-title">
    <div class="channel-band__inner">
        <div class="channel-band__cards">
            <article class="channel-card channel-card--stay-loop">
                <div class="channel-card__media">
                    <img class="channel-card__media-img" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/messages.png' ) ); ?>" alt="" aria-hidden="true" />
                </div>
                <div class="channel-card__body">
                    <h3 class="channel-card__title">Stay in the loop</h3>
                    <p class="channel-card__text channel-card__text--black">Updates on books, archives, events and more.</p>
                </div>
            </article>
            <article class="channel-card channel-card--whatsapp">
                <div class="channel-card__media">
                    <img class="channel-card__media-img" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/wp_logo.png' ) ); ?>" alt="" aria-hidden="true" />
                </div>
                <div class="channel-card__body channel-card__body--inline">
                    <h3 class="channel-card__title"><?php esc_html_e( 'WhatsApp Channel', 'queer-ink-theme' ); ?></h3>
                    <p class="channel-card__text">Short updates, high signal. Stay connected easily.</p>
                </div>
                <div class="channel-card__cta channel-card__cta--full">
                    <a class="button button--primary channel-card__button" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( $whatsapp_label ); ?></a>
                </div>
            </article>
            <article class="channel-card channel-card--telegram">
                <div class="channel-card__media">
                    <img class="channel-card__media-img" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/telegram_logo.png' ) ); ?>" alt="" aria-hidden="true" />
                </div>
                <div class="channel-card__body channel-card__body--inline">
                    <h3 class="channel-card__title"><?php esc_html_e( 'Telegram Channel', 'queer-ink-theme' ); ?></h3>
                    <p class="channel-card__text">In-depth updates, Searchable. For readers and archives.</p>
                </div>
                <div class="channel-card__cta channel-card__cta--full">
                    <a class="button button--primary channel-card__button" href="<?php echo esc_url( $telegram_url ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( $telegram_label ); ?></a>
                </div>
            </article>
            <article class="channel-card channel-card--email-updates">
                <div class="channel-card__body channel-card__body--inline channel-card__body--email">
                    <p class="channel-card__text channel-card__text--black channel-card__text--multiline">No newsletters.<br>No spam.<br>Just What matters.</p>
                </div>
                <div class="channel-card__media channel-card__media--email">
                    <img class="channel-card__media-img" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sections/love.png' ) ); ?>" alt="" aria-hidden="true" />
                </div>
            </article>
        </div>
    </div>
</section>
