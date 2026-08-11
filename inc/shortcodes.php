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
