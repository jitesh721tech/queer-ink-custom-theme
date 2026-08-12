<?php
/**
 * Shortcodes for embedding dynamic content inside block-editor page content.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_latest_books_shortcode' ) ) {
    function queer_ink_latest_books_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'count' => 8,
        ), $atts, 'qi_latest_books' );

        $books = new WP_Query( array(
            'post_type'      => 'qi_book',
            'post_status'    => 'publish',
            'posts_per_page' => absint( $atts['count'] ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ) );

        ob_start();

        if ( $books->have_posts() ) {
            echo '<div class="publishing-grid publishing-grid--current-list">';
            while ( $books->have_posts() ) {
                $books->the_post();
                get_template_part( 'template-parts/content', 'qi_book' );
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
    function queer_ink_subjects_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'style' => 'grid',
            'count' => 0,
        ), $atts, 'qi_subjects' );

        $args = array(
            'taxonomy'   => 'qi_subject',
            'hide_empty' => false,
        );

        if ( absint( $atts['count'] ) > 0 ) {
            $args['number'] = absint( $atts['count'] );
        }

        $terms = get_terms( $args );

        ob_start();

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if ( 'list' === $atts['style'] ) {
                echo '<ul class="qi-topics-list">';
                foreach ( $terms as $term ) {
                    printf(
                        '<li><a href="%1$s"><span>%2$s</span><span class="qi-topics-list__arrow" aria-hidden="true">›</span></a></li>',
                        esc_url( get_term_link( $term ) ),
                        esc_html( $term->name )
                    );
                }
                echo '</ul>';
            } else {
                echo '<div class="qi-subjects-grid">';
                foreach ( $terms as $term ) {
                    printf(
                        '<a class="qi-subject-pill" href="%1$s"><span class="qi-icon-circle">%2$s</span><span class="qi-subject-pill__label">%3$s</span></a>',
                        esc_url( get_term_link( $term ) ),
                        queer_ink_icon( 'book' ),
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
    function queer_ink_article_sections_shortcode( $atts ) {
        $terms = get_terms( array(
            'taxonomy'   => 'qi_article_section',
            'hide_empty' => false,
        ) );

        ob_start();

        echo '<div class="qi-section-tabs">';
        printf(
            '<a class="qi-section-tab is-active" href="%1$s">%2$s %3$s</a>',
            esc_url( home_url( '/journal/' ) ),
            queer_ink_icon( 'pencil' ),
            esc_html__( 'Latest', 'queer-ink-theme' )
        );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf(
                    '<a class="qi-section-tab" href="%1$s">%2$s %3$s</a>',
                    esc_url( get_term_link( $term ) ),
                    queer_ink_icon( 'pencil' ),
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
        $terms = get_terms( array(
            'taxonomy'   => 'qi_subject',
            'hide_empty' => false,
        ) );

        ob_start();
        ?>
        <select class="qi-topics-select" data-nav-select aria-label="<?php esc_attr_e( 'Filter articles by topic', 'queer-ink-theme' ); ?>">
            <option value=""><?php esc_html_e( 'All Topics', 'queer-ink-theme' ); ?></option>
            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
                <?php foreach ( $terms as $term ) : ?>
                    <option value="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'qi_subjects_dropdown', 'queer_ink_subjects_dropdown_shortcode' );

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
                <input type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" <?php echo $required ? 'required aria-required="true"' : ''; ?>>
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
     */
    function queer_ink_contact_form_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'action' => '',
        ), $atts, 'qi_contact_form' );

        $fields = get_posts( array(
            'post_type'      => 'qi_form_field',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ) );

        ob_start();
        ?>
        <form class="qi-connect-form__form" method="post" action="<?php echo esc_url( $atts['action'] ); ?>">
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
