<?php
/**
 * Product Category Meta Box class for handling custom meta fields on WooCommerce categories.
 */
if (!class_exists('Product_Category_Meta_Box')) {

    $ppws_single_categories_options = get_option('ppws_single_categories_settings');
    
    class Product_Category_Meta_Box {
        
        public $ppws_error_message = '';
        /**
         * Construct the class and add necessary hooks.
         */
        public function __construct() {
            add_action('product_cat_edit_form_fields', array($this, 'custom_category_meta_box_callback'), 30, 2);
            add_action('product_cat_add_form_fields', array($this, 'custom_category_meta_box_callback'), 30, 2);
            add_action('edited_product_cat', array($this, 'save_custom_category_meta_box'), 10, 2);
            add_action('create_product_cat', array($this, 'save_custom_category_meta_box'), 10, 2);
        }

        /**
         * Callback function for rendering custom category meta box.
         *
         * @param object $term The category term object.
         */
        public function custom_category_meta_box_callback($term) {
            $ppws_term_meta_value = array();

            // if(is_object($term)){

                // Get the existing term meta values, if any.
                $ppws_term_meta_value = get_term_meta($term->term_id, 'ppws_single_categories_password_setting', true);

                // Set default values.
                $ppws_single_categories_password_setting_radio = 'Public';
                $ppws_single_categories_password_setting_text = '';

                if (isset($ppws_term_meta_value) && is_array($ppws_term_meta_value)) {
                    $ppws_single_categories_password_setting_radio = $ppws_term_meta_value['ppws_single_categories_password_setting_radio'];
                    $ppws_single_categories_password_setting_text = isset($ppws_term_meta_value['ppws_single_categories_password_setting_textbox'])? ppws_decrypted_password($ppws_term_meta_value['ppws_single_categories_password_setting_textbox']) : '';
                }?>

                <!-- Render the meta box HTML -->
                <tr class="ppws_form_field ppws_category_title">
                    <td colspan="3">
                        <h2 class="ppws_h2_title"><?php _e('Password Protected Store for WooCommerce', 'password-protected-store-for-woocommerce') ?></h2>
                    </td>
                </tr>
                <tr class="ppws_form_field ppws_category_content">
                    <th scope="row" valign="top"><label><?php _e('Visibility', 'password-protected-store-for-woocommerce') ?></label></th>
                    <td colspan="3"> 
                        <label for="ppws_single_categories_password_setting_Public">
                            <input type="radio" name="ppws_single_categories_password_setting_radio" id="ppws_single_categories_password_setting_Public" value="Public" <?php echo (isset($ppws_single_categories_password_setting_radio) && $ppws_single_categories_password_setting_radio === 'Public')? 'checked' : ''; ?>>
                            <?php _e('Public', 'password-protected-store-for-woocommerce') ?>
                        </label>
                        <br>
                        <label for="ppws_single_categories_password_setting_Private">
                            <input type="radio" name="ppws_single_categories_password_setting_radio" id="ppws_single_categories_password_setting_Private" value="Private" <?php echo (isset($ppws_single_categories_password_setting_radio) && $ppws_single_categories_password_setting_radio === 'Private')? 'checked' : ''; ?>>
                            <?php _e('Private', 'password-protected-store-for-woocommerce') ?>
                        </label>
                    </td>
                </tr>
                <tr class="ppws_single_categories_password_setting_textbox_field ppws-toggle-textbox" style= "display:<?php echo (isset($ppws_single_categories_password_setting_radio) && $ppws_single_categories_password_setting_radio === 'Public')?'none': ''; ?>";>
                    <th scope="row" valign="top"><label><?php _e('Set Password:', 'password-protected-store-for-woocommerce') ?></label></th>
                    <td>
                        <input type="text" name="ppws_single_categories_password_setting_textbox" id="ppws_single_categories_password_setting_textbox"  value="<?php echo (isset($ppws_single_categories_password_setting_text) && !empty($ppws_single_categories_password_setting_text))? esc_attr($ppws_single_categories_password_setting_text) : ''; ?>" placeholder="Enter Password">
                    </td>
                </tr>
                <?php
            // }
        }

        /**
         * Save custom category meta box data when category is edited or created.
         *
         * @param int $term_id The ID of the category term being saved.
         */
        public function save_custom_category_meta_box($term_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
            
            if (!current_user_can('edit_term', $term_id))
            return;
            
            $ppws_single_categories_post_meta              = array();
            $ppws_single_categories_password_setting_radio = '';
            $ppws_single_categories_password_setting_text  = '';
           
            if (isset($_POST['ppws_single_categories_password_setting_radio'])) {
                
                $ppws_single_categories_password_setting_radio = sanitize_text_field($_POST['ppws_single_categories_password_setting_radio']);
                
                if(isset($ppws_single_categories_password_setting_radio) && $ppws_single_categories_password_setting_radio === 'Private'){
                    
                    if (isset($_POST['ppws_single_categories_password_setting_textbox']) && !empty($_POST['ppws_single_categories_password_setting_textbox'])) {
                        
                        $encrypt_new_password = ppws_encrypted_password($_POST['ppws_single_categories_password_setting_textbox']);

                        $ppws_single_categories_password_setting_text = sanitize_text_field($encrypt_new_password);
                        
                        $ppws_single_categories_post_meta = array(
                            'ppws_single_categories_password_setting_radio'    => $ppws_single_categories_password_setting_radio,
                            'ppws_single_categories_password_setting_textbox'  => $ppws_single_categories_password_setting_text
                        );
                        
                        update_term_meta($term_id, 'ppws_single_categories_password_setting', $ppws_single_categories_post_meta );
                    }
                }else{
                    $ppws_term_meta_value = get_term_meta($term_id, 'ppws_single_categories_password_setting', true);

                    $ppws_single_product_post_meta = array(
                        'ppws_single_categories_password_setting_radio' => $ppws_single_categories_password_setting_radio,
                    );

                    if(isset($ppws_term_meta_value['ppws_single_categories_password_setting_textbox']) && !empty($ppws_term_meta_value['ppws_single_categories_password_setting_textbox']))
                    {
                        $ppws_single_product_post_meta['ppws_single_categories_password_setting_textbox'] = $ppws_term_meta_value['ppws_single_categories_password_setting_textbox'];
                    }

                    update_term_meta($term_id, 'ppws_single_categories_password_setting', $ppws_single_product_post_meta );
                }
            }
        }
    }
}

// Check if the class exists and conditionally instantiate it.
if (class_exists('Product_Category_Meta_Box')) {
    global $ppws_single_categories_options;

    if (isset($ppws_single_categories_options) && is_array($ppws_single_categories_options) && isset($ppws_single_categories_options['ppws_single_categories_enable_password_field_checkbox']) && $ppws_single_categories_options['ppws_single_categories_enable_password_field_checkbox'] === 'on') {
        new Product_Category_Meta_Box();
    }
}
