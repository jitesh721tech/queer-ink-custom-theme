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
