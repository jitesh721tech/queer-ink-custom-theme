<?php
/**
 * Shortcodes for embedding dynamic content inside block-editor page content.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_latest_books_shortcode' ) ) {
    function queer_ink_latest_books_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count'  => 8,
            // 'grid' (default, unchanged) renders the plain teaser grid used
            // by Digital Library and Archiving. 'carousel' opts a single
            // placement (the Publishing page) into the horizontal scroller
            // card design without touching any other usage of this shortcode.
            'layout' => 'grid',
        ), $atts, 'qi_latest_books' );

        $is_carousel = ( 'carousel' === $atts['layout'] );

        $books = new WP_Query( array(
            'post_type'      => 'qi_book',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        ob_start();

        if ( $books->have_posts() ) {
            echo $is_carousel
                ? '<div class="qi-book-carousel__track" data-scroller>'
                : '<div class="publishing-grid publishing-grid--current-list">';
            while ( $books->have_posts() ) {
                $books->the_post();
                get_template_part( 'template-parts/content', $is_carousel ? 'qi_book-carousel' : 'qi_book' );
            }
            echo '</div>';
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'New titles are on their way — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_shortcode( 'qi_latest_books', 'queer_ink_latest_books_shortcode' );

if ( ! function_exists( 'queer_ink_collections_shortcode' ) ) {
    /**
     * Renders qi_collection posts into the Archiving page's "Our
     * Collections" grid (.qi-connections__grid, styled in archiving.css).
     */
    function queer_ink_collections_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 8,
        ), $atts, 'qi_collections' );

        $collections = new WP_Query( array(
            'post_type'      => 'qi_collection',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        ob_start();

        if ( $collections->have_posts() ) {
            echo '<div class="qi-connections__grid">';
            while ( $collections->have_posts() ) {
                $collections->the_post();
                get_template_part( 'template-parts/content', 'qi_collection' );
            }
            echo '</div>';
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'Collections are being catalogued — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_shortcode( 'qi_collections', 'queer_ink_collections_shortcode' );

if ( ! function_exists( 'queer_ink_timeline_entries_shortcode' ) ) {
    /**
     * Renders qi_timeline posts into the Archiving page's "Our Journey
     * Through Time" horizontal scroller (.qi-timeline__scroller,
     * styled in archiving.css). Outputs the scroller div itself
     * (including the data-scroller attribute the prev/next buttons in
     * the surrounding pattern markup target) so the existing carousel
     * JS in main.js keeps working unchanged. Year/dot/card markup and
     * the alternating pink/purple treatment are unchanged from the
     * previous static version — only the data source is now dynamic.
     */
    function queer_ink_timeline_entries_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 20,
        ), $atts, 'qi_timeline_entries' );

        $entries = new WP_Query( array(
            'post_type'      => 'qi_timeline',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'meta_key'       => '_qi_timeline_year',
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
        ) );

        ob_start();

        echo '<div class="qi-timeline__scroller" data-scroller>';

        if ( $entries->have_posts() ) {
            while ( $entries->have_posts() ) {
                $entries->the_post();

                $year = get_post_meta( get_the_ID(), '_qi_timeline_year', true );
                ?>
                <div class="qi-timeline__item">
                    <span class="qi-timeline__year"><?php echo esc_html( $year ); ?></span>
                    <div class="qi-timeline__dot" aria-hidden="true"></div>
                    <div class="qi-timeline__card">
                        <div class="qi-timeline__image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'alt' => '' ) ); ?>
                            <?php else : ?>
                                <span class="qi-timeline__image-placeholder" aria-hidden="true"></span>
                            <?php endif; ?>
                        </div>
                        <h3><?php the_title(); ?></h3>
                        <?php if ( has_excerpt() ) : ?>
                            <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                        <?php endif; ?>
                        <a class="qi-pathway-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Explore', 'queer-ink-theme' ); ?> →</a>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'Milestones are being added — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        echo '</div>';

        return ob_get_clean();
    }
}
add_shortcode( 'qi_timeline_entries', 'queer_ink_timeline_entries_shortcode' );

if ( ! function_exists( 'queer_ink_latest_articles_shortcode' ) ) {
    function queer_ink_latest_articles_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 8,
        ), $atts, 'qi_latest_articles' );

        $articles = new WP_Query( array(
            'post_type'      => 'qi_article',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        ob_start();

        if ( $articles->have_posts() ) {
            echo '<div class="publishing-grid publishing-grid--current-list">';
            while ( $articles->have_posts() ) {
                $articles->the_post();
                get_template_part( 'template-parts/content', 'qi_article' );
            }
            echo '</div>';
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'New entries are on their way — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}
add_shortcode( 'qi_latest_articles', 'queer_ink_latest_articles_shortcode' );

if ( ! function_exists( 'queer_ink_subjects_shortcode' ) ) {
    /**
     * 'taxonomy' defaults to qi_subject (Digital Library's book subjects,
     * the shortcode's original/only use). QI Journal's "Popular Topics"
     * passes taxonomy="qi_article_topic" instead — a separate taxonomy,
     * not a repurposing of this one — so both keep their own vocabulary.
     *
     * 'popular="1"' (Popular Topics only) shows the admin-curated list
     * from the Topics term list's "Popular" column (see
     * inc/admin-taxonomy-fields.php) instead of the plain latest/all-terms
     * query — falls back to the normal query, capped at 5, if nothing has
     * been curated yet so the section is never empty before an admin
     * picks favourites.
     */
    function queer_ink_subjects_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'style'    => 'grid',
            'count'    => 0,
            'taxonomy' => 'qi_subject',
            'popular'  => 0,
        ), $atts, 'qi_subjects' );

        $taxonomy = in_array( $atts['taxonomy'], array( 'qi_subject', 'qi_article_topic' ), true ) ? $atts['taxonomy'] : 'qi_subject';
        $popular  = 'qi_article_topic' === $taxonomy && ! empty( $atts['popular'] );

        $popular_ids = $popular && function_exists( 'queer_ink_get_popular_article_topic_ids' )
            ? queer_ink_get_popular_article_topic_ids()
            : array();

        $args = array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        );

        if ( $popular && ! empty( $popular_ids ) ) {
            $args['include'] = $popular_ids;
            $args['orderby'] = 'include';
        } elseif ( $popular ) {
            // No curation yet — fall back to the first 5 so the widget
            // still shows something sensible until an admin picks favourites.
            $args['number'] = 5;
        } elseif ( absint( $atts['count'] ) > 0 ) {
            $args['number'] = absint( $atts['count'] );
        }

        $terms = get_terms( $args );

        ob_start();

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if ( 'list' === $atts['style'] ) {
                echo '<ul class="qi-topics-list">';
                foreach ( $terms as $term ) {
                    printf(
                        '<li><a href="%1$s" data-filter-topic="%2$s"><span>%3$s</span><span class="qi-topics-list__arrow" aria-hidden="true">›</span></a></li>',
                        esc_url( get_term_link( $term ) ),
                        esc_attr( $term->slug ),
                        esc_html( $term->name )
                    );
                }
                echo '</ul>';
            } else {
                echo '<div class="qi-subjects-grid" data-scroller>';
                foreach ( $terms as $term ) {
                    printf(
                        '<a class="qi-subject-pill" href="%1$s"><span class="qi-subject-pill__label">%2$s</span></a>',
                        esc_url( get_term_link( $term ) ),
                        esc_html( $term->name )
                    );
                }
                echo '</div>';
            }
        } else {
            echo '<p class="publishing-empty">' . esc_html__( 'Subjects are being catalogued — check back soon.', 'queer-ink-theme' ) . '</p>';
        }

        return ob_get_clean();
    }
}
add_shortcode( 'qi_subjects', 'queer_ink_subjects_shortcode' );

if ( ! function_exists( 'queer_ink_article_sections_shortcode' ) ) {
    /**
     * "Latest" + one tab per qi_article_section term. Each tab keeps a
     * real href to its taxonomy archive (works with JS disabled); the
     * data-filter-section slug lets main.js intercept clicks and filter
     * the article list in place via the qi_load_articles AJAX action
     * instead of leaving /qi-journal/. "is-active" only ever marks
     * "Latest" server-side (the page always loads fresh at that state);
     * JS moves it after that.
     */
    function queer_ink_article_sections_shortcode( $atts ) {
        $terms = get_terms( array(
            'taxonomy'   => 'qi_article_section',
            'hide_empty' => false,
        ) );

        ob_start();

        echo '<div class="qi-section-tabs">';
        printf(
            '<a class="qi-section-tab is-active" href="%1$s" data-filter-section="">%2$s</a>',
            esc_url( home_url( '/journal/' ) ),
            esc_html__( 'Latest', 'queer-ink-theme' )
        );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf(
                    '<a class="qi-section-tab" href="%1$s" data-filter-section="%2$s">%3$s</a>',
                    esc_url( get_term_link( $term ) ),
                    esc_attr( $term->slug ),
                    esc_html( $term->name )
                );
            }
        }
        echo '</div>';

        return ob_get_clean();
    }
}
add_shortcode( 'qi_article_sections', 'queer_ink_article_sections_shortcode' );

if ( ! function_exists( 'queer_ink_subjects_dropdown_shortcode' ) ) {
    function queer_ink_subjects_dropdown_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'taxonomy' => 'qi_subject',
        ), $atts, 'qi_subjects_dropdown' );

        $taxonomy = in_array( $atts['taxonomy'], array( 'qi_subject', 'qi_article_topic' ), true ) ? $atts['taxonomy'] : 'qi_subject';

        $terms = get_terms( array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ) );

        ob_start();
        ?>
        <select class="qi-topics-select" data-nav-select aria-label="<?php esc_attr_e( 'Filter articles by topic', 'queer-ink-theme' ); ?>">
            <option value=""><?php esc_html_e( 'All Topics', 'queer-ink-theme' ); ?></option>
            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                <?php foreach ( $terms as $term ) : ?>
                    <option value="<?php echo esc_url( get_term_link( $term ) ); ?>" data-filter-topic="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'qi_subjects_dropdown', 'queer_ink_subjects_dropdown_shortcode' );

if ( ! function_exists( 'queer_ink_form_field_validation_attrs' ) ) {
    /**
     * HTML5 pattern/inputmode/data-qi-validate attributes for the 3 field
     * types this form validates beyond plain "required" — kept in one
     * place so the client-side JS (main.js) and this markup always agree
     * on what "valid" means for a given type. Actual enforcement is
     * server-side too (queer_ink_handle_contact_form_submission()); this
     * is the client-side half of the same rule set.
     */
    function queer_ink_form_field_validation_attrs( $type ) {
        switch ( $type ) {
            case 'name':
                // Letters (incl. accents), spaces, apostrophes, hyphens,
                // periods — not digits-only or symbol-only input.
                return ' pattern="[A-Za-zÀ-ÖØ-öø-ÿ][A-Za-zÀ-ÖØ-öø-ÿ\s\'\.\-]*" data-qi-validate="name" autocomplete="name"';
            case 'email':
                return ' data-qi-validate="email" autocomplete="email"';
            case 'tel':
                return ' pattern="[0-9]{10,12}" inputmode="numeric" data-qi-validate="tel" autocomplete="tel"';
            default:
                return '';
        }
    }
}

if ( ! function_exists( 'queer_ink_render_form_field' ) ) {
    /**
     * Renders a single qi_form_field post as its configured input.
     */
    function queer_ink_render_form_field( $field_post ) {
        $type        = get_post_meta( $field_post->ID, '_qi_field_type', true ) ?: 'text';
        $required    = (bool) get_post_meta( $field_post->ID, '_qi_field_required', true );
        $placeholder = get_post_meta( $field_post->ID, '_qi_field_placeholder', true );
        $options_raw = get_post_meta( $field_post->ID, '_qi_field_options', true );

        $label       = get_the_title( $field_post );
        $placeholder = '' !== $placeholder ? $placeholder : $label;
        $field_name  = $field_post->post_name ? $field_post->post_name : 'field-' . $field_post->ID;
        $field_id    = 'qi-field-' . $field_name;

        // "name" is a plain text input — its own type value only exists
        // to pick out which field gets the letters-only validation below.
        $input_type = 'name' === $type ? 'text' : $type;

        ob_start();
        ?>
        <div class="qi-connect-form__field">
            <label class="screen-reader-text" for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $label ); ?></label>
            <?php if ( 'textarea' === $type ) : ?>
                <textarea id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" rows="5" placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php echo $required ? 'required aria-required="true"' : ''; ?>></textarea>
            <?php elseif ( 'select' === $type ) : ?>
                <select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" <?php echo $required ? 'required aria-required="true"' : ''; ?>>
                    <option value=""><?php echo esc_html( $placeholder ); ?></option>
                    <?php
                    $options = preg_split( '/\r\n|\r|\n/', (string) $options_raw );
                    foreach ( $options as $option ) {
                        $option = trim( $option );
                        if ( '' === $option ) {
                            continue;
                        }
                        printf( '<option value="%1$s">%2$s</option>', esc_attr( sanitize_title( $option ) ), esc_html( $option ) );
                    }
                    ?>
                </select>
            <?php else : ?>
                <input type="<?php echo esc_attr( $input_type ); ?>" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php echo $required ? 'required aria-required="true"' : ''; ?><?php echo queer_ink_form_field_validation_attrs( $type ); // phpcs:ignore -- fixed, trusted attribute string, not user input. ?>>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'queer_ink_contact_form_shortcode' ) ) {
    /**
     * Renders the "Send us a message" form from qi_form_field posts, so
     * fields (type, label, required, select options, order, half/full
     * width) are entirely admin-editable from wp-admin → Contact Form
     * Fields, with no field structure hard-coded in the template.
     *
     * Submits to admin-post.php (WordPress's own native form-handling
     * entry point — see queer_ink_handle_contact_form_submission()
     * below), not a plugin. The 'action' shortcode attribute is kept for
     * backwards compatibility but no longer needed for the form to work.
     */
    function queer_ink_contact_form_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'action' => admin_url( 'admin-post.php' ),
        ), $atts, 'qi_contact_form' );

        $fields = get_posts( array(
            'post_type'      => 'qi_form_field',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        // Read-only, used purely to pick which (already-fixed) message to
        // display below — sanitize_key() reduces it to [a-z0-9_-] first,
        // so an unexpected value just matches nothing rather than being
        // used unsafely.
        $status = isset( $_GET['qi_contact'] ) ? sanitize_key( wp_unslash( $_GET['qi_contact'] ) ) : '';

        $status_messages = array(
            'success'          => array( 'type' => 'success', 'text' => esc_html__( "Thanks — your message has been sent. We'll get back to you soon.", 'queer-ink-theme' ) ),
            'validation_error' => array( 'type' => 'error', 'text' => esc_html__( 'Please fill in all required fields before sending.', 'queer-ink-theme' ) ),
            'invalid_name'     => array( 'type' => 'error', 'text' => esc_html__( 'Please enter a valid name (letters only).', 'queer-ink-theme' ) ),
            'invalid_email'    => array( 'type' => 'error', 'text' => esc_html__( 'Please enter a valid email address.', 'queer-ink-theme' ) ),
            'invalid_mobile'   => array( 'type' => 'error', 'text' => esc_html__( 'Please enter a valid mobile number (10-12 digits only).', 'queer-ink-theme' ) ),
            'mail_error'       => array( 'type' => 'error', 'text' => esc_html__( "Sorry, your message couldn't be sent right now. Please try again shortly or email us directly.", 'queer-ink-theme' ) ),
            'error'            => array( 'type' => 'error', 'text' => esc_html__( 'Your session expired before sending — please try again.', 'queer-ink-theme' ) ),
        );

        ob_start();

        if ( isset( $status_messages[ $status ] ) ) {
            printf(
                '<p class="qi-connect-form__message qi-connect-form__message--%1$s" role="status">%2$s</p>',
                esc_attr( $status_messages[ $status ]['type'] ),
                $status_messages[ $status ]['text']
            );
        }
        ?>
        <form class="qi-connect-form__form" method="post" action="<?php echo esc_url( $atts['action'] ); ?>">
            <input type="hidden" name="action" value="qi_contact_form_submit">
            <input type="hidden" name="qi_contact_redirect" value="<?php echo esc_url( get_permalink() ); ?>">
            <?php wp_nonce_field( 'qi_contact_form_submit', 'qi_contact_form_nonce' ); ?>
            <?php
            if ( empty( $fields ) ) {
                if ( current_user_can( 'edit_theme_options' ) || current_user_can( 'manage_options' ) ) {
                    echo '<p class="qi-connect-form__admin-notice">' . esc_html__( 'No form fields configured yet. Add some under Contact Form Fields in wp-admin.', 'queer-ink-theme' ) . '</p>';
                }
            }

            $pending_half = null;

            foreach ( $fields as $field_post ) {
                $width = get_post_meta( $field_post->ID, '_qi_field_width', true ) ?: 'full';

                if ( 'half' === $width ) {
                    if ( null === $pending_half ) {
                        $pending_half = $field_post;
                        continue;
                    }

                    echo '<div class="qi-connect-form__row">';
                    echo queer_ink_render_form_field( $pending_half ); // phpcs:ignore -- escaped in queer_ink_render_form_field().
                    echo queer_ink_render_form_field( $field_post ); // phpcs:ignore -- escaped in queer_ink_render_form_field().
                    echo '</div>';
                    $pending_half = null;
                    continue;
                }

                if ( null !== $pending_half ) {
                    echo queer_ink_render_form_field( $pending_half ); // phpcs:ignore -- escaped in queer_ink_render_form_field().
                    $pending_half = null;
                }

                echo queer_ink_render_form_field( $field_post ); // phpcs:ignore -- escaped in queer_ink_render_form_field().
            }

            if ( null !== $pending_half ) {
                echo queer_ink_render_form_field( $pending_half ); // phpcs:ignore -- escaped in queer_ink_render_form_field().
            }
            ?>
            <label class="qi-connect-form__consent">
                <input type="checkbox" name="consent" required aria-required="true">
                <span><?php esc_html_e( 'I agree to the', 'queer-ink-theme' ); ?> <a href="#"><?php esc_html_e( 'Privacy Policy', 'queer-ink-theme' ); ?></a></span>
            </label>
            <button type="submit" class="button button--primary"><?php esc_html_e( 'Send Message', 'queer-ink-theme' ); ?></button>
        </form>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'qi_contact_form', 'queer_ink_contact_form_shortcode' );

if ( ! function_exists( 'queer_ink_handle_contact_form_submission' ) ) {
    /**
     * Handles the Connect page's "Send us a message" form (see
     * queer_ink_contact_form_shortcode() above) via admin-post.php —
     * WordPress's own native, plugin-free entry point for handling a
     * plain form POST. Registered for both logged-in and logged-out
     * visitors since anyone can submit this form.
     *
     * Destination: info@queer-ink.com — the only contact address this
     * theme's own content presents anywhere (Connect page, "Other ways
     * to reach us" → Email; see inc/block-patterns.php), so it's reused
     * here rather than guessing at one.
     *
     * Field list/types/required-ness come from the same qi_form_field
     * posts the shortcode itself renders from, so validation always
     * matches whatever an admin has currently configured under Contact
     * Form Fields — nothing about the field set is hard-coded here.
     */
    function queer_ink_handle_contact_form_submission() {
        $redirect_url = isset( $_POST['qi_contact_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['qi_contact_redirect'] ) ) : '';
        if ( ! $redirect_url ) {
            $redirect_url = wp_get_referer();
        }
        if ( ! $redirect_url ) {
            $redirect_url = home_url( '/connect/' );
        }

        $nonce_ok = isset( $_POST['qi_contact_form_nonce'] )
            && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qi_contact_form_nonce'] ) ), 'qi_contact_form_submit' );

        if ( ! $nonce_ok ) {
            wp_safe_redirect( add_query_arg( 'qi_contact', 'error', $redirect_url ) . '#contact-form' );
            exit;
        }

        $fields = get_posts( array(
            'post_type'      => 'qi_form_field',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        $valid        = true;
        // Set only by the specific name/email/tel format checks below, so
        // the redirect can show the exact wording for whichever field
        // actually failed format-wise, rather than one generic message —
        // first field to fail wins (later fields don't overwrite it).
        // Empty-required-field failures never set this, so that case
        // falls through to the generic "please fill in..." message.
        $format_error = '';
        $email_value  = '';
        $lines        = array();

        foreach ( $fields as $field_post ) {
            $type       = get_post_meta( $field_post->ID, '_qi_field_type', true ) ?: 'text';
            $required   = (bool) get_post_meta( $field_post->ID, '_qi_field_required', true );
            $label      = get_the_title( $field_post );
            $field_name = $field_post->post_name ? $field_post->post_name : 'field-' . $field_post->ID;

            $raw = isset( $_POST[ $field_name ] ) ? wp_unslash( $_POST[ $field_name ] ) : '';

            if ( 'email' === $type ) {
                // sanitize_email() itself returns '' for *any* malformed
                // address (missing @, no domain, etc.) — not just a
                // genuinely empty field — so that alone can't tell "left
                // blank" apart from "typed something invalid". Checking
                // the raw trimmed input first keeps those two cases
                // reporting the right message (required vs. invalid_email).
                $was_entered = '' !== trim( $raw );
                $value       = sanitize_email( $raw );
                if ( $was_entered && ( '' === $value || ! is_email( $value ) ) ) {
                    $valid = false;
                    $value = ''; // Reject the malformed address rather than mailing it.
                    if ( ! $format_error ) {
                        $format_error = 'invalid_email';
                    }
                } elseif ( '' !== $value ) {
                    $email_value = $value;
                }
            } elseif ( 'tel' === $type ) {
                // sanitize_text_field() first (strips tags/extra
                // whitespace), then the digits-only, 10-12-length check —
                // letters, symbols (+, -, spaces, etc.) and wrong lengths
                // are all rejected, matching the "10-12 digits only" rule.
                $value = sanitize_text_field( $raw );
                if ( '' !== $value && ! preg_match( '/^[0-9]{10,12}$/', $value ) ) {
                    $valid = false;
                    if ( ! $format_error ) {
                        $format_error = 'invalid_mobile';
                    }
                }
            } elseif ( 'name' === $type ) {
                $value = sanitize_text_field( $raw );
                if ( '' !== $value && ! preg_match( '/^[A-Za-z\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{00FF}][A-Za-z\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{00FF}\s\'.-]*$/u', $value ) ) {
                    $valid = false;
                    if ( ! $format_error ) {
                        $format_error = 'invalid_name';
                    }
                }
            } elseif ( 'textarea' === $type ) {
                $value = sanitize_textarea_field( $raw );
            } else {
                $value = sanitize_text_field( $raw );
            }

            if ( $required && '' === $value ) {
                $valid = false;
            }

            if ( '' !== $value ) {
                $lines[] = $label . ': ' . $value;
            }
        }

        // The consent checkbox isn't a qi_form_field post — it's a fixed
        // part of the form markup — so it's required separately here.
        if ( empty( $_POST['consent'] ) ) {
            $valid = false;
        }

        if ( ! $valid ) {
            wp_safe_redirect( add_query_arg( 'qi_contact', $format_error ? $format_error : 'validation_error', $redirect_url ) . '#contact-form' );
            exit;
        }

        $to      = 'info@queer-ink.com';
        $subject = sprintf(
            /* translators: %s: site name. */
            esc_html__( '[%s] New contact form submission', 'queer-ink-theme' ),
            wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES )
        );
        $body = implode( "\n\n", $lines );

        // From is explicitly the site's own admin_email (a real, already-
        // configured address), not the visitor's — WordPress's own
        // wp_mail() default of wordpress@{host} fails PHPMailer's address
        // validation outright on a bare "localhost" install (confirmed
        // via the wp_mail_failed hook while diagnosing this: "Invalid
        // address: (From): wordpress@localhost"), and even on a real
        // domain, letting a visitor-supplied address control From/
        // Envelope-From would let a forged submission spoof outgoing
        // mail. The visitor's own (already is_email()-validated) address
        // only ever goes in Reply-To, so hitting "Reply" goes straight
        // to them.
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            sprintf( 'From: %1$s <%2$s>', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), get_option( 'admin_email' ) ),
        );
        if ( $email_value ) {
            $headers[] = 'Reply-To: ' . $email_value;
        }

        $sent = wp_mail( $to, $subject, $body, $headers );

        wp_safe_redirect( add_query_arg( 'qi_contact', $sent ? 'success' : 'mail_error', $redirect_url ) . '#contact-form' );
        exit;
    }
}
add_action( 'admin_post_nopriv_qi_contact_form_submit', 'queer_ink_handle_contact_form_submission' );
add_action( 'admin_post_qi_contact_form_submit', 'queer_ink_handle_contact_form_submission' );
