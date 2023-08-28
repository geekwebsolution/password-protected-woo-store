<?php
// Check if the class 'ppws_admin_product_page_meta_box' doesn't exist to avoid redeclaration.
if (!class_exists('ppws_admin_single_product_page_meta_box')) {

    // Get options from the database.
    $ppws_single_product_options = get_option('ppws_single_product_settings');

    class ppws_admin_single_product_page_meta_box{

        /**
        * Constructor.
        */
        public function __construct()
        {
            if (is_admin()) {
                add_action('add_meta_boxes', array($this, 'ppws_single_product_add_metabox'));
                add_action('save_post',      array($this, 'ppws_single_product_save_metabox'), 10, 2);
            }
        }


        /**
         * Adds the meta box.
        */
        public function ppws_single_product_add_metabox()
        {
            add_meta_box(
                'ppws-single-product-meta-box',
                __('Password Protected Store for WooCommerce', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_render_metabox'),
                'product',
                'advanced',
                'default'
            );
        }


        /**
         * Renders the meta box.
        */
        public function ppws_single_product_render_metabox($post)
        {
            global $ppws_single_product_options;

            $ppws_post_meta_value = array();
            $ppws_single_product_password_setting_radio = 'Public';
            $ppws_single_product_password_setting_text  = '';
            
            // Retrieve previous values from the database if they exist
            $ppws_post_meta_value  = get_post_meta($post->ID, 'ppws_single_product_password_setting', true);
            
             if(isset($ppws_post_meta_value) && !empty($ppws_post_meta_value)){
                 $ppws_single_product_password_setting_radio = $ppws_post_meta_value['ppws_single_product_password_setting_radio'];
                 $ppws_single_product_password_setting_text  = ppws_decrypted_password($ppws_post_meta_value['ppws_single_product_password_setting_textbox']);
             }
            ?>

            <div>
                <label for="ppws_single_product_password_setting_Public">
                    <input type="radio" name="ppws_single_product_password_setting_radio" id="ppws_single_product_password_setting_Public" value="Public" <?php echo (isset($ppws_single_product_password_setting_radio) && $ppws_single_product_password_setting_radio === 'Public')? 'checked' : ''; ?>>
                    <?php _e('Public', 'password-protected-store-for-woocommerce') ?>
                </label>
                <br>
                <label for="ppws_single_product_password_setting_Private">
                    <input type="radio" name="ppws_single_product_password_setting_radio" id="ppws_single_product_password_setting_Private" value="Private" <?php echo (isset($ppws_single_product_password_setting_radio) && $ppws_single_product_password_setting_radio === 'Private')? 'checked' : ''; ?>>
                    <?php _e('Private', 'password-protected-store-for-woocommerce') ?>
                </label>
            </div>
            <div class="ppws_single_protected_password_setting_textbox_field ppws-toggle-textbox" style= "display:<?php echo (isset($ppws_single_product_password_setting_radio) && $ppws_single_product_password_setting_radio === 'Public')?'none': ''; ?>";>
                <label for="ppws_single_product_password_setting_textbox"><?php _e('Set Password:', 'password-protected-store-for-woocommerce') ?></label>
                <input type="text" name="ppws_single_product_password_setting_textbox" id="ppws_single_product_password_setting_textbox"  value="<?php echo (isset($ppws_single_product_password_setting_text) && !empty($ppws_single_product_password_setting_text))? esc_attr($ppws_single_product_password_setting_text) : ''; ?>" placeholder="Enter Password">
                <p><b>Warning:</b> If the password field is left empty, the visibility value will be set to "Public".</p>
            </div>
            <?php
        }


        /**
         * Handles saving the meta box.
         *
         * @param int     $post_id Post ID.
         * @param WP_Post $post    Post object.
         * @return null
        */
        public function ppws_single_product_save_metabox($post_id, $post)
        {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
        
            if (!current_user_can('edit_post', $post_id))
                return;
        
            $ppws_single_product_post_meta              = array();
            $ppws_single_product_password_setting_radio = '';
            $ppws_single_product_password_setting_text  = '';
            
            if (isset($_POST['ppws_single_product_password_setting_radio'])) {

                $ppws_single_product_password_setting_radio = sanitize_text_field($_POST['ppws_single_product_password_setting_radio']);

                if(isset($ppws_single_product_password_setting_radio) && $ppws_single_product_password_setting_radio === 'Private'){

                    if (isset($_POST['ppws_single_product_password_setting_textbox']) && !empty($_POST['ppws_single_product_password_setting_textbox'])) {

                        $encrypt_new_password = ppws_encrypted_password($_POST['ppws_single_product_password_setting_textbox']);

                        $ppws_single_product_password_setting_text = sanitize_text_field($encrypt_new_password);

                        $ppws_single_product_post_meta = array(
                            'ppws_single_product_password_setting_radio'    => $ppws_single_product_password_setting_radio,
                            'ppws_single_product_password_setting_textbox'  => $ppws_single_product_password_setting_text
                        );

                        update_post_meta($post_id, 'ppws_single_product_password_setting', $ppws_single_product_post_meta );

                    }
                }else{
                    $ppws_post_meta_value = get_post_meta($post_id, 'ppws_single_product_password_setting', true);

                    $ppws_single_product_post_meta = array(
                        'ppws_single_product_password_setting_radio' => $ppws_single_product_password_setting_radio,
                    );

                    if(isset($ppws_post_meta_value['ppws_single_product_password_setting_textbox']) && !empty($ppws_post_meta_value['ppws_single_product_password_setting_textbox'])){
                        $ppws_single_product_post_meta['ppws_single_product_password_setting_textbox'] = $ppws_post_meta_value['ppws_single_product_password_setting_textbox'];
                    }

                    update_post_meta($post_id, 'ppws_single_product_password_setting', $ppws_single_product_post_meta );
                }
            }
        
        }
    }
}

// Initialize the custom meta box class.
if (class_exists('ppws_admin_single_product_page_meta_box')) {
    global $ppws_single_product_options;
    if(isset($ppws_single_product_options) && !empty($ppws_single_product_options)){
        if(isset($ppws_single_product_options['ppws_single_product_enable_password_field_checkbox'])){
            if('on' === $ppws_single_product_options['ppws_single_product_enable_password_field_checkbox']){
                new ppws_admin_single_product_page_meta_box();
            }
        } 
    }
}