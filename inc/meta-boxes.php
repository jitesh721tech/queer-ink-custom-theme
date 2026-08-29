<?php
/**
 * Admin meta box for qi_form_field — lets an editor define the Connect
 * page's "Send us a message" fields (type, required, options, layout
 * width) entirely from wp-admin. Reordering uses the native Page
 * Attributes "Order" box (see the 'page-attributes' support declared in
 * inc/post-types.php) instead of custom drag-and-drop, so no admin JS
 * dependency is introduced.
 *
 * @package Queer_Ink_Theme
 */

if ( ! function_exists( 'queer_ink_form_field_types' ) ) {
    function queer_ink_form_field_types() {
        return array(
            'text'     => esc_html__( 'Text', 'queer-ink-theme' ),
            'email'    => esc_html__( 'Email', 'queer-ink-theme' ),
            'tel'      => esc_html__( 'Phone', 'queer-ink-theme' ),
            'textarea' => esc_html__( 'Textarea', 'queer-ink-theme' ),
            'select'   => esc_html__( 'Select (dropdown)', 'queer-ink-theme' ),
        );
    }
}

if ( ! function_exists( 'queer_ink_register_form_field_meta_box' ) ) {
    function queer_ink_register_form_field_meta_box() {
        add_meta_box(
            'qi_form_field_settings',
            esc_html__( 'Field Settings', 'queer-ink-theme' ),
            'queer_ink_render_form_field_meta_box',
            'qi_form_field',
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'queer_ink_register_form_field_meta_box' );

if ( ! function_exists( 'queer_ink_render_form_field_meta_box' ) ) {
    function queer_ink_render_form_field_meta_box( $post ) {
        wp_nonce_field( 'queer_ink_save_form_field', 'queer_ink_form_field_nonce' );

        $type        = get_post_meta( $post->ID, '_qi_field_type', true ) ?: 'text';
        $required    = (bool) get_post_meta( $post->ID, '_qi_field_required', true );
        $placeholder = get_post_meta( $post->ID, '_qi_field_placeholder', true );
        $width       = get_post_meta( $post->ID, '_qi_field_width', true ) ?: 'full';
        $options     = get_post_meta( $post->ID, '_qi_field_options', true );
        ?>
        <p>
            <label for="qi_field_type"><strong><?php esc_html_e( 'Field Type', 'queer-ink-theme' ); ?></strong></label><br>
            <select id="qi_field_type" name="qi_field_type">
                <?php foreach ( queer_ink_form_field_types() as $value => $label ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $type, $value ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="qi_field_placeholder"><strong><?php esc_html_e( 'Placeholder / Prompt Text', 'queer-ink-theme' ); ?></strong></label><br>
            <input type="text" id="qi_field_placeholder" name="qi_field_placeholder" class="widefat" value="<?php echo esc_attr( $placeholder ); ?>" placeholder="<?php esc_attr_e( 'e.g. Your Name — shown as placeholder text, and as the first option for Select fields', 'queer-ink-theme' ); ?>">
        </p>
        <p>
            <label for="qi_field_options"><strong><?php esc_html_e( 'Select Options', 'queer-ink-theme' ); ?></strong></label><br>
            <textarea id="qi_field_options" name="qi_field_options" class="widefat" rows="5" placeholder="<?php esc_attr_e( 'One option per line. Only used when Field Type is Select.', 'queer-ink-theme' ); ?>"><?php echo esc_textarea( $options ); ?></textarea>
        </p>
        <p>
            <label for="qi_field_width"><strong><?php esc_html_e( 'Field Width', 'queer-ink-theme' ); ?></strong></label><br>
            <select id="qi_field_width" name="qi_field_width">
                <option value="full" <?php selected( $width, 'full' ); ?>><?php esc_html_e( 'Full width', 'queer-ink-theme' ); ?></option>
                <option value="half" <?php selected( $width, 'half' ); ?>><?php esc_html_e( 'Half width (pairs with the next half-width field)', 'queer-ink-theme' ); ?></option>
            </select>
        </p>
        <p>
            <label>
                <input type="checkbox" name="qi_field_required" value="1" <?php checked( $required ); ?>>
                <?php esc_html_e( 'Required', 'queer-ink-theme' ); ?>
            </label>
        </p>
        <p class="description">
            <?php esc_html_e( 'The field label is the post title. To reorder fields, use the Order box below (lower numbers appear first).', 'queer-ink-theme' ); ?>
        </p>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_save_form_field_meta' ) ) {
    function queer_ink_save_form_field_meta( $post_id ) {
        if ( ! isset( $_POST['queer_ink_form_field_nonce'] ) || ! wp_verify_nonce( $_POST['queer_ink_form_field_nonce'], 'queer_ink_save_form_field' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $types = array_keys( queer_ink_form_field_types() );
        $type  = isset( $_POST['qi_field_type'] ) && in_array( $_POST['qi_field_type'], $types, true ) ? $_POST['qi_field_type'] : 'text';
        update_post_meta( $post_id, '_qi_field_type', $type );

        update_post_meta( $post_id, '_qi_field_required', isset( $_POST['qi_field_required'] ) ? 1 : 0 );

        $width = isset( $_POST['qi_field_width'] ) && 'half' === $_POST['qi_field_width'] ? 'half' : 'full';
        update_post_meta( $post_id, '_qi_field_width', $width );

        if ( isset( $_POST['qi_field_placeholder'] ) ) {
            update_post_meta( $post_id, '_qi_field_placeholder', sanitize_text_field( wp_unslash( $_POST['qi_field_placeholder'] ) ) );
        }

        if ( isset( $_POST['qi_field_options'] ) ) {
            update_post_meta( $post_id, '_qi_field_options', sanitize_textarea_field( wp_unslash( $_POST['qi_field_options'] ) ) );
        }
    }
}
add_action( 'save_post_qi_form_field', 'queer_ink_save_form_field_meta' );

if ( ! function_exists( 'queer_ink_enqueue_book_media_uploader' ) ) {
    /**
     * Loads the WP media library JS only on the qi_book edit screen, so the
     * PDF meta box's "Select PDF" button can open the native uploader.
     */
    function queer_ink_enqueue_book_media_uploader( $hook ) {
        if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
            return;
        }

        $screen = get_current_screen();
        if ( ! $screen || 'qi_book' !== $screen->post_type ) {
            return;
        }

        wp_enqueue_media();

        // Depend on 'media-editor' explicitly (not just 'jquery') so
        // WordPress's dependency graph *guarantees* wp.media is loaded
        // before this script runs, instead of relying on wp_enqueue_media()
        // happening to have queued it first — the latter is not a real
        // ordering guarantee and is exactly the kind of thing that can
        // start failing intermittently under a different WP core version,
        // hook priority, or once another plugin also touches this screen.
        wp_enqueue_script( 'queer-ink-book-meta', get_theme_file_uri( 'assets/js/admin-book-meta.js' ), array( 'jquery', 'media-editor' ), wp_get_theme()->get( 'Version' ), true );
    }
}
add_action( 'admin_enqueue_scripts', 'queer_ink_enqueue_book_media_uploader' );

if ( ! function_exists( 'queer_ink_register_book_meta_box' ) ) {
    function queer_ink_register_book_meta_box( $post_type ) {
        add_meta_box(
            'qi_book_pdf',
            esc_html__( 'Book PDF', 'queer-ink-theme' ),
            'queer_ink_render_book_meta_box',
            'qi_book',
            'side',
            'default'
        );
    }
}
// Scoped to add_meta_boxes_qi_book (not the generic add_meta_boxes hook)
// so this only ever runs on the Book screen, not on every post/page/CPT
// edit screen in the admin.
add_action( 'add_meta_boxes_qi_book', 'queer_ink_register_book_meta_box' );

if ( ! function_exists( 'queer_ink_render_book_meta_box' ) ) {
    function queer_ink_render_book_meta_box( $post ) {
        wp_nonce_field( 'queer_ink_save_book_meta', 'queer_ink_book_meta_nonce' );

        $pdf_id  = absint( get_post_meta( $post->ID, '_qi_book_pdf_id', true ) );
        $pdf_url = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';
        ?>
        <p class="description"><?php esc_html_e( 'The PDF is stored publicly (same as the site\'s book downloads) and linked directly on the book\'s page.', 'queer-ink-theme' ); ?></p>
        <p>
            <input type="hidden" id="qi_book_pdf_id" name="qi_book_pdf_id" value="<?php echo esc_attr( $pdf_id ); ?>">
            <span id="qi_book_pdf_filename"><?php echo $pdf_url ? esc_html( basename( $pdf_url ) ) : esc_html__( 'No PDF selected.', 'queer-ink-theme' ); ?></span>
        </p>
        <p>
            <button type="button" class="button" id="qi_book_pdf_select"><?php esc_html_e( 'Select PDF', 'queer-ink-theme' ); ?></button>
            <button type="button" class="button" id="qi_book_pdf_remove" <?php echo $pdf_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'queer-ink-theme' ); ?></button>
        </p>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_save_book_meta' ) ) {
    function queer_ink_save_book_meta( $post_id ) {
        if ( ! isset( $_POST['queer_ink_book_meta_nonce'] ) || ! wp_verify_nonce( $_POST['queer_ink_book_meta_nonce'], 'queer_ink_save_book_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['qi_book_pdf_id'] ) ) {
            update_post_meta( $post_id, '_qi_book_pdf_id', absint( $_POST['qi_book_pdf_id'] ) );
        }
    }
}
add_action( 'save_post_qi_book', 'queer_ink_save_book_meta' );

if ( ! function_exists( 'queer_ink_book_admin_columns' ) ) {
    function queer_ink_book_admin_columns( $columns ) {
        $columns['qi_book_pdf'] = esc_html__( 'PDF', 'queer-ink-theme' );
        return $columns;
    }
}
add_filter( 'manage_qi_book_posts_columns', 'queer_ink_book_admin_columns' );

if ( ! function_exists( 'queer_ink_book_admin_column_content' ) ) {
    function queer_ink_book_admin_column_content( $column, $post_id ) {
        if ( 'qi_book_pdf' !== $column ) {
            return;
        }

        $pdf_id = absint( get_post_meta( $post_id, '_qi_book_pdf_id', true ) );
        if ( ! $pdf_id ) {
            esc_html_e( '—', 'queer-ink-theme' );
            return;
        }

        $pdf_url = wp_get_attachment_url( $pdf_id );
        if ( $pdf_url ) {
            printf( '<a href="%1$s" target="_blank" rel="noopener">%2$s</a>', esc_url( $pdf_url ), esc_html__( 'View', 'queer-ink-theme' ) );
        } else {
            esc_html_e( '—', 'queer-ink-theme' );
        }
    }
}
add_action( 'manage_qi_book_posts_custom_column', 'queer_ink_book_admin_column_content', 10, 2 );

/**
 * Timeline entry "Year" meta box — the one field the qi_timeline CPT
 * needs that isn't already covered by title/editor/excerpt/thumbnail.
 * Mirrors the qi_book PDF meta box's nonce/capability/save shape above.
 */

if ( ! function_exists( 'queer_ink_register_timeline_meta_box' ) ) {
    function queer_ink_register_timeline_meta_box( $post_type ) {
        add_meta_box(
            'qi_timeline_year',
            esc_html__( 'Year', 'queer-ink-theme' ),
            'queer_ink_render_timeline_meta_box',
            'qi_timeline',
            'side',
            'default'
        );
    }
}
// Scoped to add_meta_boxes_qi_timeline (not the generic add_meta_boxes
// hook) so this only ever runs on the Timeline Entry screen.
add_action( 'add_meta_boxes_qi_timeline', 'queer_ink_register_timeline_meta_box' );

if ( ! function_exists( 'queer_ink_render_timeline_meta_box' ) ) {
    function queer_ink_render_timeline_meta_box( $post ) {
        wp_nonce_field( 'queer_ink_save_timeline_meta', 'queer_ink_timeline_meta_nonce' );

        $year = get_post_meta( $post->ID, '_qi_timeline_year', true );
        ?>
        <p>
            <label for="qi_timeline_year"><strong><?php esc_html_e( 'Year', 'queer-ink-theme' ); ?></strong></label><br>
            <input type="number" id="qi_timeline_year" name="qi_timeline_year" class="widefat" value="<?php echo esc_attr( $year ); ?>" placeholder="<?php esc_attr_e( 'e.g. 1994', 'queer-ink-theme' ); ?>">
        </p>
        <p class="description"><?php esc_html_e( 'Shown as the year marker on the timeline. Entries are ordered by this value.', 'queer-ink-theme' ); ?></p>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_save_timeline_meta' ) ) {
    function queer_ink_save_timeline_meta( $post_id ) {
        if ( ! isset( $_POST['queer_ink_timeline_meta_nonce'] ) || ! wp_verify_nonce( $_POST['queer_ink_timeline_meta_nonce'], 'queer_ink_save_timeline_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['qi_timeline_year'] ) ) {
            update_post_meta( $post_id, '_qi_timeline_year', absint( $_POST['qi_timeline_year'] ) );
        }
    }
}
add_action( 'save_post_qi_timeline', 'queer_ink_save_timeline_meta' );

if ( ! function_exists( 'queer_ink_timeline_admin_columns' ) ) {
    function queer_ink_timeline_admin_columns( $columns ) {
        $columns['qi_timeline_year'] = esc_html__( 'Year', 'queer-ink-theme' );
        return $columns;
    }
}
add_filter( 'manage_qi_timeline_posts_columns', 'queer_ink_timeline_admin_columns' );

if ( ! function_exists( 'queer_ink_timeline_admin_column_content' ) ) {
    function queer_ink_timeline_admin_column_content( $column, $post_id ) {
        if ( 'qi_timeline_year' !== $column ) {
            return;
        }

        $year = get_post_meta( $post_id, '_qi_timeline_year', true );
        echo $year ? esc_html( $year ) : esc_html__( '—', 'queer-ink-theme' );
    }
}
add_action( 'manage_qi_timeline_posts_custom_column', 'queer_ink_timeline_admin_column_content', 10, 2 );

/**
 * Annual Report "Year" + "PDF" meta box — the two fields an admin needs
 * to publish a report (see [qi_annual_reports], inc/shortcodes.php, for
 * how they're rendered on the About page). Mirrors the qi_book PDF meta
 * box's media-library pattern and the qi_timeline Year meta box's
 * nonce/capability/save shape above, combined into one box since both
 * fields are this CPT's only content.
 */

if ( ! function_exists( 'queer_ink_enqueue_annual_report_media_uploader' ) ) {
    /**
     * Loads the WP media library JS only on the qi_annual_report edit
     * screen, so the PDF meta box's "Select PDF" button can open the
     * native uploader.
     */
    function queer_ink_enqueue_annual_report_media_uploader( $hook ) {
        if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
            return;
        }

        $screen = get_current_screen();
        if ( ! $screen || 'qi_annual_report' !== $screen->post_type ) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_script( 'queer-ink-annual-report-meta', get_theme_file_uri( 'assets/js/admin-annual-report-meta.js' ), array( 'jquery', 'media-editor' ), wp_get_theme()->get( 'Version' ), true );
    }
}
add_action( 'admin_enqueue_scripts', 'queer_ink_enqueue_annual_report_media_uploader' );

if ( ! function_exists( 'queer_ink_register_annual_report_meta_box' ) ) {
    function queer_ink_register_annual_report_meta_box( $post_type ) {
        add_meta_box(
            'qi_annual_report_details',
            esc_html__( 'Report Details', 'queer-ink-theme' ),
            'queer_ink_render_annual_report_meta_box',
            'qi_annual_report',
            'normal',
            'high'
        );
    }
}
// Scoped to add_meta_boxes_qi_annual_report (not the generic add_meta_boxes
// hook) so this only ever runs on the Annual Report screen.
add_action( 'add_meta_boxes_qi_annual_report', 'queer_ink_register_annual_report_meta_box' );

if ( ! function_exists( 'queer_ink_render_annual_report_meta_box' ) ) {
    function queer_ink_render_annual_report_meta_box( $post ) {
        wp_nonce_field( 'queer_ink_save_annual_report_meta', 'queer_ink_annual_report_meta_nonce' );

        $year    = get_post_meta( $post->ID, '_qi_annual_report_year', true );
        $pdf_id  = absint( get_post_meta( $post->ID, '_qi_annual_report_pdf_id', true ) );
        $pdf_url = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';
        ?>
        <p>
            <label for="qi_annual_report_year"><strong><?php esc_html_e( 'Year', 'queer-ink-theme' ); ?></strong></label><br>
            <input type="number" id="qi_annual_report_year" name="qi_annual_report_year" value="<?php echo esc_attr( $year ); ?>" placeholder="<?php esc_attr_e( 'e.g. 2025', 'queer-ink-theme' ); ?>">
        </p>
        <p class="description"><?php esc_html_e( 'Reports are listed on the About page newest year first.', 'queer-ink-theme' ); ?></p>
        <p>
            <label><strong><?php esc_html_e( 'PDF', 'queer-ink-theme' ); ?></strong></label><br>
            <input type="hidden" id="qi_report_pdf_id" name="qi_report_pdf_id" value="<?php echo esc_attr( $pdf_id ); ?>">
            <span id="qi_report_pdf_filename"><?php echo $pdf_url ? esc_html( basename( $pdf_url ) ) : esc_html__( 'No PDF selected.', 'queer-ink-theme' ); ?></span>
        </p>
        <p>
            <button type="button" class="button" id="qi_report_pdf_select"><?php esc_html_e( 'Select PDF', 'queer-ink-theme' ); ?></button>
            <button type="button" class="button" id="qi_report_pdf_remove" <?php echo $pdf_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'queer-ink-theme' ); ?></button>
        </p>
        <p class="description"><?php esc_html_e( 'A report with no PDF selected is never shown on the About page.', 'queer-ink-theme' ); ?></p>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_save_annual_report_meta' ) ) {
    function queer_ink_save_annual_report_meta( $post_id ) {
        if ( ! isset( $_POST['queer_ink_annual_report_meta_nonce'] ) || ! wp_verify_nonce( $_POST['queer_ink_annual_report_meta_nonce'], 'queer_ink_save_annual_report_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['qi_annual_report_year'] ) ) {
            update_post_meta( $post_id, '_qi_annual_report_year', absint( $_POST['qi_annual_report_year'] ) );
        }

        if ( isset( $_POST['qi_report_pdf_id'] ) ) {
            update_post_meta( $post_id, '_qi_annual_report_pdf_id', absint( $_POST['qi_report_pdf_id'] ) );
        }
    }
}
add_action( 'save_post_qi_annual_report', 'queer_ink_save_annual_report_meta' );

if ( ! function_exists( 'queer_ink_annual_report_admin_columns' ) ) {
    function queer_ink_annual_report_admin_columns( $columns ) {
        $columns['qi_annual_report_year'] = esc_html__( 'Year', 'queer-ink-theme' );
        $columns['qi_annual_report_pdf']  = esc_html__( 'PDF', 'queer-ink-theme' );
        return $columns;
    }
}
add_filter( 'manage_qi_annual_report_posts_columns', 'queer_ink_annual_report_admin_columns' );

if ( ! function_exists( 'queer_ink_annual_report_admin_column_content' ) ) {
    function queer_ink_annual_report_admin_column_content( $column, $post_id ) {
        if ( 'qi_annual_report_year' === $column ) {
            $year = get_post_meta( $post_id, '_qi_annual_report_year', true );
            echo $year ? esc_html( $year ) : esc_html__( '—', 'queer-ink-theme' );
            return;
        }

        if ( 'qi_annual_report_pdf' === $column ) {
            $pdf_id  = absint( get_post_meta( $post_id, '_qi_annual_report_pdf_id', true ) );
            $pdf_url = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';

            if ( $pdf_url ) {
                printf( '<a href="%1$s" target="_blank" rel="noopener">%2$s</a>', esc_url( $pdf_url ), esc_html__( 'View', 'queer-ink-theme' ) );
            } else {
                esc_html_e( '—', 'queer-ink-theme' );
            }
        }
    }
}
add_action( 'manage_qi_annual_report_posts_custom_column', 'queer_ink_annual_report_admin_column_content', 10, 2 );

/**
 * Collection "Featured on Archiving page" toggle — caps how many
 * qi_collection posts can appear in the frontend "Our Collections"
 * section (archiving.css / [qi_collections]) at 4, regardless of how
 * many Collections exist in wp-admin overall. Mirrors the qi_book PDF
 * meta box's nonce/capability/save shape above.
 */

define( 'QI_COLLECTIONS_FEATURED_MAX', 4 );

if ( ! function_exists( 'queer_ink_count_featured_collections' ) ) {
    /**
     * Counts Collections currently flagged as featured, optionally
     * excluding one post (the one being saved/rendered), across every
     * non-trashed status — the cap applies to the act of selecting a
     * Collection, independent of whether it's published yet.
     */
    function queer_ink_count_featured_collections( $exclude_post_id = 0 ) {
        $args = array(
            'post_type'      => 'qi_collection',
            'post_status'    => array( 'publish', 'draft', 'pending', 'future', 'private' ),
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'meta_key'       => '_qi_collection_featured',
            'meta_value'     => '1',
        );

        if ( $exclude_post_id ) {
            $args['post__not_in'] = array( $exclude_post_id );
        }

        return count( get_posts( $args ) );
    }
}

if ( ! function_exists( 'queer_ink_register_collection_meta_box' ) ) {
    function queer_ink_register_collection_meta_box( $post_type ) {
        add_meta_box(
            'qi_collection_featured',
            esc_html__( 'Frontend Visibility', 'queer-ink-theme' ),
            'queer_ink_render_collection_meta_box',
            'qi_collection',
            'side',
            'default'
        );
    }
}
// Scoped to add_meta_boxes_qi_collection (not the generic add_meta_boxes
// hook) so this only ever runs on the Collection screen.
add_action( 'add_meta_boxes_qi_collection', 'queer_ink_register_collection_meta_box' );

if ( ! function_exists( 'queer_ink_render_collection_meta_box' ) ) {
    function queer_ink_render_collection_meta_box( $post ) {
        wp_nonce_field( 'queer_ink_save_collection_meta', 'queer_ink_collection_meta_nonce' );

        $is_featured    = (bool) get_post_meta( $post->ID, '_qi_collection_featured', true );
        $other_featured = queer_ink_count_featured_collections( $post->ID );
        $limit_reached  = ! $is_featured && $other_featured >= QI_COLLECTIONS_FEATURED_MAX;
        ?>
        <p>
            <label>
                <input type="checkbox" name="qi_collection_featured" value="1" <?php checked( $is_featured ); ?> <?php disabled( $limit_reached ); ?>>
                <?php esc_html_e( 'Show in "Our Collections" on the Archiving page', 'queer-ink-theme' ); ?>
            </label>
        </p>
        <?php if ( $limit_reached ) : ?>
            <p class="description" style="color:#b32d2e;">
                <?php
                printf(
                    /* translators: %d: maximum number of featured collections. */
                    esc_html__( 'Maximum of %d featured Collections already selected. Deselect another Collection first, then try again.', 'queer-ink-theme' ),
                    (int) QI_COLLECTIONS_FEATURED_MAX
                );
                ?>
            </p>
        <?php else : ?>
            <p class="description">
                <?php
                printf(
                    /* translators: 1: number currently featured, 2: maximum allowed. */
                    esc_html__( '%1$d of %2$d selected.', 'queer-ink-theme' ),
                    (int) ( $other_featured + ( $is_featured ? 1 : 0 ) ),
                    (int) QI_COLLECTIONS_FEATURED_MAX
                );
                ?>
            </p>
        <?php endif; ?>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_save_collection_meta' ) ) {
    function queer_ink_save_collection_meta( $post_id ) {
        if ( ! isset( $_POST['queer_ink_collection_meta_nonce'] ) || ! wp_verify_nonce( $_POST['queer_ink_collection_meta_nonce'], 'queer_ink_save_collection_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $currently_featured = (bool) get_post_meta( $post_id, '_qi_collection_featured', true );
        $requested_featured = isset( $_POST['qi_collection_featured'] );

        // Only re-check the cap when newly selecting — unchecking, or
        // re-saving an already-featured Collection, never needs it.
        if ( $requested_featured && ! $currently_featured ) {
            $other_featured = queer_ink_count_featured_collections( $post_id );

            if ( $other_featured >= QI_COLLECTIONS_FEATURED_MAX ) {
                set_transient( 'qi_collection_limit_notice_' . get_current_user_id(), 1, MINUTE_IN_SECONDS );
                return; // Leave the existing (unfeatured) value in place.
            }
        }

        update_post_meta( $post_id, '_qi_collection_featured', $requested_featured ? 1 : 0 );
    }
}
add_action( 'save_post_qi_collection', 'queer_ink_save_collection_meta' );

if ( ! function_exists( 'queer_ink_collection_limit_notice' ) ) {
    function queer_ink_collection_limit_notice() {
        $screen = get_current_screen();
        if ( ! $screen || 'qi_collection' !== $screen->post_type ) {
            return;
        }

        $key = 'qi_collection_limit_notice_' . get_current_user_id();
        if ( ! get_transient( $key ) ) {
            return;
        }

        delete_transient( $key );
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <?php
                printf(
                    /* translators: %d: maximum number of featured collections. */
                    esc_html__( 'This Collection was not marked as featured — the maximum of %d has already been selected. Deselect another Collection first, then try again.', 'queer-ink-theme' ),
                    (int) QI_COLLECTIONS_FEATURED_MAX
                );
                ?>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'queer_ink_collection_limit_notice' );

if ( ! function_exists( 'queer_ink_collection_admin_columns' ) ) {
    function queer_ink_collection_admin_columns( $columns ) {
        $columns['qi_collection_featured'] = esc_html__( 'Featured', 'queer-ink-theme' );
        return $columns;
    }
}
add_filter( 'manage_qi_collection_posts_columns', 'queer_ink_collection_admin_columns' );

if ( ! function_exists( 'queer_ink_collection_admin_column_content' ) ) {
    function queer_ink_collection_admin_column_content( $column, $post_id ) {
        if ( 'qi_collection_featured' !== $column ) {
            return;
        }

        echo get_post_meta( $post_id, '_qi_collection_featured', true )
            ? esc_html__( 'Yes', 'queer-ink-theme' )
            : esc_html__( '—', 'queer-ink-theme' );
    }
}
add_action( 'manage_qi_collection_posts_custom_column', 'queer_ink_collection_admin_column_content', 10, 2 );

if ( ! function_exists( 'queer_ink_migrate_featured_collections' ) ) {
    /**
     * One-time migration: this feature replaces "show every published
     * Collection" with "show only the ones an admin has featured", so
     * without this, every existing Collection would silently disappear
     * from the Archiving page the moment this ships. Featuring the first
     * QI_COLLECTIONS_FEATURED_MAX (existing display order — newest
     * first) preserves what's currently visible on the frontend; the
     * 'qi_collections_featured_migrated' option ensures this only ever
     * runs once, so it never overrides an admin's later selections.
     */
    function queer_ink_migrate_featured_collections() {
        if ( get_option( 'qi_collections_featured_migrated' ) ) {
            return;
        }

        $collections = get_posts( array(
            'post_type'      => 'qi_collection',
            'post_status'    => 'publish',
            'posts_per_page' => QI_COLLECTIONS_FEATURED_MAX,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'fields'         => 'ids',
        ) );

        foreach ( $collections as $collection_id ) {
            update_post_meta( $collection_id, '_qi_collection_featured', 1 );
        }

        update_option( 'qi_collections_featured_migrated', 1 );
    }
}
add_action( 'init', 'queer_ink_migrate_featured_collections' );

/**
 * Read-only admin view for qi_inquiry posts (inc/post-types.php)
 * — every field the Connect page's contact form collects (see
 * queer_ink_handle_contact_form_submission(), inc/shortcodes.php), plain
 * text only. There's nothing here to edit or save: submissions are
 * created exclusively by the form handler, so no nonce/save hook exists
 * for this meta box on purpose. The default Publish box's Trash/Delete
 * action is left as-is, so an admin can still remove a submission.
 */

if ( ! function_exists( 'queer_ink_register_contact_submission_meta_box' ) ) {
    function queer_ink_register_contact_submission_meta_box( $post_type ) {
        add_meta_box(
            'qi_inquiry_details',
            esc_html__( 'Inquiry Details', 'queer-ink-theme' ),
            'queer_ink_render_contact_submission_meta_box',
            'qi_inquiry',
            'normal',
            'high'
        );
    }
}
// Scoped to add_meta_boxes_qi_inquiry (not the generic
// add_meta_boxes hook) so this only ever runs on the Inquiry screen.
add_action( 'add_meta_boxes_qi_inquiry', 'queer_ink_register_contact_submission_meta_box' );

if ( ! function_exists( 'queer_ink_render_contact_submission_meta_box' ) ) {
    function queer_ink_render_contact_submission_meta_box( $post ) {
        $name         = get_post_meta( $post->ID, '_qi_submission_name', true );
        $email        = get_post_meta( $post->ID, '_qi_submission_email', true );
        $country_code = get_post_meta( $post->ID, '_qi_submission_country_code', true );
        $mobile       = get_post_meta( $post->ID, '_qi_submission_mobile', true );
        $regarding    = get_post_meta( $post->ID, '_qi_submission_regarding', true );
        $message      = get_post_meta( $post->ID, '_qi_submission_message', true );

        $rows = array(
            esc_html__( 'Name', 'queer-ink-theme' )      => $name,
            esc_html__( 'Email', 'queer-ink-theme' )     => $email,
            esc_html__( 'Mobile', 'queer-ink-theme' )    => trim( $country_code . ' ' . $mobile ),
            esc_html__( 'Regarding', 'queer-ink-theme' ) => $regarding,
        );
        ?>
        <table class="form-table" role="presentation">
            <tbody>
                <?php foreach ( $rows as $field_label => $value ) : ?>
                    <tr>
                        <th scope="row"><?php echo esc_html( $field_label ); ?></th>
                        <td><?php echo $value ? esc_html( $value ) : '—'; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th scope="row"><?php esc_html_e( 'Message', 'queer-ink-theme' ); ?></th>
                    <td><?php echo $message ? nl2br( esc_html( $message ) ) : '—'; ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e( 'Submitted', 'queer-ink-theme' ); ?></th>
                    <td><?php echo esc_html( get_the_date( 'F j, Y \a\t g:i a', $post ) ); ?></td>
                </tr>
            </tbody>
        </table>
        <?php
    }
}

if ( ! function_exists( 'queer_ink_contact_submission_admin_columns' ) ) {
    function queer_ink_contact_submission_admin_columns( $columns ) {
        // Replaces the default Title column — submissions have no
        // meaningful title of their own beyond the visitor's name.
        $columns = array(
            'cb'                     => $columns['cb'],
            'qi_submission_name'     => esc_html__( 'Name', 'queer-ink-theme' ),
            'qi_submission_email'    => esc_html__( 'Email', 'queer-ink-theme' ),
            'qi_submission_mobile'   => esc_html__( 'Mobile', 'queer-ink-theme' ),
            'qi_submission_regarding' => esc_html__( 'Regarding', 'queer-ink-theme' ),
            'date'                   => esc_html__( 'Submitted', 'queer-ink-theme' ),
        );
        return $columns;
    }
}
add_filter( 'manage_qi_inquiry_posts_columns', 'queer_ink_contact_submission_admin_columns' );

if ( ! function_exists( 'queer_ink_contact_submission_admin_column_content' ) ) {
    function queer_ink_contact_submission_admin_column_content( $column, $post_id ) {
        switch ( $column ) {
            case 'qi_submission_name':
                $name = get_post_meta( $post_id, '_qi_submission_name', true );
                printf(
                    '<a href="%1$s"><strong>%2$s</strong></a>',
                    esc_url( get_edit_post_link( $post_id ) ),
                    $name ? esc_html( $name ) : esc_html__( '(no name)', 'queer-ink-theme' )
                );
                break;
            case 'qi_submission_email':
                $email = get_post_meta( $post_id, '_qi_submission_email', true );
                echo $email ? esc_html( $email ) : '—';
                break;
            case 'qi_submission_mobile':
                $country_code = get_post_meta( $post_id, '_qi_submission_country_code', true );
                $mobile       = get_post_meta( $post_id, '_qi_submission_mobile', true );
                echo $mobile ? esc_html( trim( $country_code . ' ' . $mobile ) ) : '—';
                break;
            case 'qi_submission_regarding':
                $regarding = get_post_meta( $post_id, '_qi_submission_regarding', true );
                echo $regarding ? esc_html( $regarding ) : '—';
                break;
        }
    }
}
add_action( 'manage_qi_inquiry_posts_custom_column', 'queer_ink_contact_submission_admin_column_content', 10, 2 );
