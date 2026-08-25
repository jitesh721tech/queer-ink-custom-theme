<?php
/**
 * "Popular Topics" curation control on the Articles → Topics term list,
 * plus a plain-language safety notice on the Articles → Categories
 * term list confirming that deleting a category never deletes articles.
 *
 * Books/Articles' taxonomy fields (Subjects, Languages, Categories,
 * Topics, Authors, Writers) already get a searchable, tick-and-add-new
 * UI for free from the block editor's own taxonomy panels (Gutenberg
 * renders every public, show_in_rest taxonomy as a FormTokenField —
 * type to filter existing terms, click/Enter to select, or type a new
 * name and press Enter to create it on the spot; hierarchical Subjects
 * gets a searchable tick-list plus an "Add New Subject" toggle) — so no
 * custom meta box was added here; that would only duplicate an existing,
 * already-searchable field and risk it being hidden behind the classic
 * back-compat meta box area instead.
 *
 * @package Queer_Ink_Theme
 */

/**
 * ---------------- Popular Topics (Articles → Topics) ----------------
 *
 * A sitewide, curated list of up to 5 qi_article_topic terms controlling
 * the QI Journal page's "Popular Topics" widget (see the
 * [qi_subjects taxonomy="qi_article_topic" popular="1"] usage in
 * inc/block-patterns.php and its handling in inc/shortcodes.php).
 *
 * This is deliberately sitewide rather than per-article: "which topics
 * count as popular" isn't a property of any one article, so it lives on
 * the Topics taxonomy's own admin screen (Journal → Topics) as a single
 * "Popular" tick column, not repeated identically on every article's
 * edit screen. Stored as one option (native wp_options row, not a new
 * table) — a plain array of up to 5 term IDs.
 */

if ( ! function_exists( 'queer_ink_get_popular_article_topic_ids' ) ) {
    function queer_ink_get_popular_article_topic_ids() {
        $ids = get_option( 'qi_popular_article_topics', array() );
        if ( ! is_array( $ids ) ) {
            return array();
        }
        return array_slice( array_map( 'absint', $ids ), 0, 5 );
    }
}

if ( ! function_exists( 'queer_ink_popular_topics_columns' ) ) {
    function queer_ink_popular_topics_columns( $columns ) {
        $columns['qi_popular_topic'] = esc_html__( 'Popular', 'queer-ink-theme' );
        return $columns;
    }
}
add_filter( 'manage_edit-qi_article_topic_columns', 'queer_ink_popular_topics_columns' );

if ( ! function_exists( 'queer_ink_popular_topics_column_content' ) ) {
    function queer_ink_popular_topics_column_content( $content, $column_name, $term_id ) {
        if ( 'qi_popular_topic' !== $column_name ) {
            return $content;
        }

        $popular_ids = queer_ink_get_popular_article_topic_ids();

        return sprintf(
            '<input type="checkbox" class="qi-popular-topic-toggle" data-term-id="%1$d" %2$s>',
            (int) $term_id,
            checked( in_array( (int) $term_id, $popular_ids, true ), true, false )
        );
    }
}
add_filter( 'manage_qi_article_topic_custom_column', 'queer_ink_popular_topics_column_content', 10, 3 );

if ( ! function_exists( 'queer_ink_popular_topics_screen_notice' ) ) {
    function queer_ink_popular_topics_screen_notice() {
        $screen = get_current_screen();
        if ( ! $screen || 'edit-qi_article_topic' !== $screen->id ) {
            return;
        }
        ?>
        <div class="notice notice-info">
            <p><?php esc_html_e( 'Tick "Popular" on up to 5 Topics below to control the Popular Topics list on the QI Journal page.', 'queer-ink-theme' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'queer_ink_popular_topics_screen_notice' );

if ( ! function_exists( 'queer_ink_enqueue_popular_topics_assets' ) ) {
    function queer_ink_enqueue_popular_topics_assets( $hook ) {
        if ( 'edit-tags.php' !== $hook && 'term.php' !== $hook ) {
            return;
        }

        $screen = get_current_screen();
        if ( ! $screen || 'qi_article_topic' !== $screen->taxonomy ) {
            return;
        }

        wp_enqueue_script( 'queer-ink-admin-popular-topics', get_theme_file_uri( 'assets/js/admin-popular-topics.js' ), array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

        wp_localize_script( 'queer-ink-admin-popular-topics', 'qiPopularTopics', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'qi_toggle_popular_topic' ),
            'max'     => 5,
            'i18n'    => array(
                'max' => esc_html__( 'You can only feature up to 5 Popular Topics. Untick one first.', 'queer-ink-theme' ),
            ),
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'queer_ink_enqueue_popular_topics_assets' );

/**
 * ---------------- Categories screen reassurance ----------------
 *
 * qi_article_section's "Delete" action (edit-tags.php) is plain
 * WordPress core behavior already — deleting a term only removes that
 * taxonomy relationship (wp_delete_term()), it never deletes the posts
 * that carried it. No custom code changes that. This just makes that
 * explicit on the screen, since an admin cleaning up incorrectly
 * created categories has no other way to know it's safe.
 */

if ( ! function_exists( 'queer_ink_categories_screen_notice' ) ) {
    function queer_ink_categories_screen_notice() {
        $screen = get_current_screen();
        if ( ! $screen || 'edit-qi_article_section' !== $screen->id ) {
            return;
        }
        ?>
        <div class="notice notice-info">
            <p><?php esc_html_e( 'Deleting a category here only removes the category itself — it will not delete any articles. Articles that had it simply lose that one category label; all their other categories, topics and content are unaffected.', 'queer-ink-theme' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'queer_ink_categories_screen_notice' );

/**
 * ---------------- "Manage Categories" link on Add/Edit Article ----------------
 *
 * The block editor's Categories panel (used for the Category field on
 * this screen) can tick existing categories and add new ones, but has no
 * delete action — that's a Gutenberg limitation on every hierarchical
 * taxonomy, not something specific to this one. Deleting a category is
 * already fully supported by the native Articles → Categories screen
 * (edit-tags.php, see queer_ink_categories_screen_notice() above); this
 * just links to it directly from the Add/Edit Article screen so an
 * admin cleaning up a wrong category doesn't have to go hunting for it
 * in the admin menu.
 */

if ( ! function_exists( 'queer_ink_article_manage_categories_notice' ) ) {
    function queer_ink_article_manage_categories_notice() {
        $screen = get_current_screen();
        if ( ! $screen || 'qi_article' !== $screen->post_type || ! in_array( $screen->base, array( 'post', 'post-new' ), true ) ) {
            return;
        }
        ?>
        <div class="notice notice-info">
            <p>
                <?php esc_html_e( 'To remove an incorrect or unwanted Category entirely (not just for this article), use', 'queer-ink-theme' ); ?>
                <a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=qi_article_section&post_type=qi_article' ) ); ?>"><?php esc_html_e( 'Manage Categories', 'queer-ink-theme' ); ?></a>.
                <?php esc_html_e( 'Removing a category there never deletes any articles.', 'queer-ink-theme' ); ?>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'queer_ink_article_manage_categories_notice' );

if ( ! function_exists( 'queer_ink_ajax_toggle_popular_topic' ) ) {
    function queer_ink_ajax_toggle_popular_topic() {
        check_ajax_referer( 'qi_toggle_popular_topic', 'nonce' );

        $tax_obj = get_taxonomy( 'qi_article_topic' );
        if ( ! $tax_obj || ! current_user_can( $tax_obj->cap->manage_terms ) ) {
            wp_send_json_error( array( 'message' => __( 'You are not allowed to do this.', 'queer-ink-theme' ) ) );
        }

        $term_id  = isset( $_POST['term_id'] ) ? absint( $_POST['term_id'] ) : 0;
        $selected = ! empty( $_POST['selected'] );

        $term = $term_id ? get_term( $term_id, 'qi_article_topic' ) : null;
        if ( ! $term || is_wp_error( $term ) ) {
            wp_send_json_error( array( 'message' => __( 'Unknown topic.', 'queer-ink-theme' ) ) );
        }

        $popular_ids = queer_ink_get_popular_article_topic_ids();

        if ( $selected ) {
            if ( ! in_array( $term_id, $popular_ids, true ) ) {
                if ( count( $popular_ids ) >= 5 ) {
                    wp_send_json_error( array( 'message' => __( 'You can only feature up to 5 Popular Topics. Untick one first.', 'queer-ink-theme' ) ) );
                }
                $popular_ids[] = $term_id;
            }
        } else {
            $popular_ids = array_values( array_diff( $popular_ids, array( $term_id ) ) );
        }

        update_option( 'qi_popular_article_topics', $popular_ids );

        wp_send_json_success( array( 'popular_ids' => $popular_ids ) );
    }
}
add_action( 'wp_ajax_qi_toggle_popular_topic', 'queer_ink_ajax_toggle_popular_topic' );
