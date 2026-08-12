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
