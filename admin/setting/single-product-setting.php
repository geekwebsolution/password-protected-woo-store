<?php
// Check if the class 'ppws_single_product_setting' doesn't exist to avoid redeclaration.
if (!class_exists('ppws_single_product_setting')) {

    // Get options from the database.
    $ppws_single_product_options = get_option('ppws_single_product_settings');
    $ppws_whole_site_options = get_option('ppws_general_settings');

    // Define the class 'ppws_single_product_setting'.
    class ppws_single_product_setting{

        // Constructor to initialize the class and hook into WordPress actions.
        public function __construct(){
            add_action('admin_init', array($this, 'ppws_single_product_register_settings_init'));
        }

        // Callback function to display the single product settings form in the admin panel.
        function ppws_single_product_callback() {
            global $ppws_whole_site_options;
            global $ppws_single_product_options;?>
            <form action="options.php?tab=single-product-setting" class="ppws-single-product-setting-form" method="post">
                <?php
                // Output the WordPress settings fields for the plugin options.
                settings_fields('ppws-settings-options');
                $custom_class =  isset($ppws_single_product_options['ppws_single_product_enable_password_field_checkbox']) == 'on' ? ' ' : 'ppws-hide-section' ;
                $custom_class2 = isset($ppws_single_product_options['enable_user_role']) == 'on' ? ' ' : 'none-redio-click' ;
                echo '<p class="ppws-note ppws-note-info '.$custom_class.'">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="18px" height="18px" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                <path style="" d="M11.812,0C5.289,0,0,5.289,0,11.812s5.289,11.813,11.812,11.813s11.813-5.29,11.813-11.813   S18.335,0,11.812,0z M14.271,18.307c-0.608,0.24-1.092,0.422-1.455,0.548c-0.362,0.126-0.783,0.189-1.262,0.189   c-0.736,0-1.309-0.18-1.717-0.539s-0.611-0.814-0.611-1.367c0-0.215,0.015-0.435,0.045-0.659c0.031-0.224,0.08-0.476,0.147-0.759   l0.761-2.688c0.067-0.258,0.125-0.503,0.171-0.731c0.046-0.23,0.068-0.441,0.068-0.633c0-0.342-0.071-0.582-0.212-0.717   c-0.143-0.135-0.412-0.201-0.813-0.201c-0.196,0-0.398,0.029-0.605,0.09c-0.205,0.063-0.383,0.12-0.529,0.176l0.201-0.828   c0.498-0.203,0.975-0.377,1.43-0.521c0.455-0.146,0.885-0.218,1.29-0.218c0.731,0,1.295,0.178,1.692,0.53   c0.395,0.353,0.594,0.812,0.594,1.376c0,0.117-0.014,0.323-0.041,0.617c-0.027,0.295-0.078,0.564-0.152,0.811l-0.757,2.68   c-0.062,0.215-0.117,0.461-0.167,0.736c-0.049,0.275-0.073,0.485-0.073,0.626c0,0.356,0.079,0.599,0.239,0.728   c0.158,0.129,0.435,0.194,0.827,0.194c0.185,0,0.392-0.033,0.626-0.097c0.232-0.064,0.4-0.121,0.506-0.17L14.271,18.307z    M14.137,7.429c-0.353,0.328-0.778,0.492-1.275,0.492c-0.496,0-0.924-0.164-1.28-0.492c-0.354-0.328-0.533-0.727-0.533-1.193   c0-0.465,0.18-0.865,0.533-1.196c0.356-0.332,0.784-0.497,1.28-0.497c0.497,0,0.923,0.165,1.275,0.497   c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z" fill="#030104" data-original="#030104" class=""></path></svg> ';
                echo _e('If the "General Setting" password is enabled, at this time passwords for "Page Settings" and "Product Category" are disabled. Because "General Setting" has a higher priority.','password-protected-store-for-woocommerce');
                echo '</p>';
                ?>

                <!-- Output the Password Settings section -->
                <div class="ppws-section">
                    <?php do_settings_sections('ppws-single-product-password-settings-section'); ?>
                </div>

                <!-- Output the User Role section -->
                <div class="ppws-section ppws-section-user <?php echo $custom_class." ".$custom_class2; ?>">
                    <?php do_settings_sections('ppws-single-product-user-role-settings-section');  ?>
                </div>

                <!-- Submit button to save the settings -->
                <div class="ppws-submit-btn">
                    <?php submit_button('Save Setting'); ?>
                </div>
            </form>
            <?php
        }


        // Function to register the settings and sections for the plugin options.
        public function ppws_single_product_register_settings_init(){

            // Register the settings for the plugin options.
            register_setting(
                'ppws-settings-options',
                'ppws_single_product_settings',
                array($this, 'sanitize_settings')
            );

            /* Password Settings Start */
            add_settings_section(
                'ppws_single_product_password_settings_section',
                __('Password Settings', 'password-protected-store-for-woocommerce'),
                array(),
                'ppws-single-product-password-settings-section'
            );

            // Add the fields for password settings.
            add_settings_field(
                'ppws_single_product_enable_password_checkbox',
                __('Enable Password', 'password-protected-store-for-woocommerce' ),
                array($this, 'ppws_single_product_password_settings'),
                'ppws-single-product-password-settings-section',
                'ppws_single_product_password_settings_section',
                ['type' => 'checkbox', 'label_for' => 'ppws_single_product_enable_password_field_checkbox', 'description' => 'Enable password for Single Product.','custom_class' => 'ppws_password_checkbox_validation']
            );

            global $ppws_single_product_options;
            $ppws_single_product_enable_password_value = isset($ppws_single_product_options['ppws_single_product_enable_password_field_checkbox']) ? $ppws_single_product_options['ppws_single_product_enable_password_field_checkbox'] : "";
            $ppws_single_product_enable_password_class = ($ppws_single_product_enable_password_value === 'on') ? "" : "ppws-hide-section";
            

            add_settings_field(
                'ppws_single_product_enable_password_checkbox_for_admin',
                __('Disable For Administrator', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_password_settings'),
                'ppws-single-product-password-settings-section',
                'ppws_single_product_password_settings_section',
                [
                    'type' => 'checkbox', 
                    'label_for' => 'ppws_single_product_enable_password_field_checkbox_for_admin', 
                    'description' => '', 
                    'class' => " ppws-single-product-enable-password-section $ppws_single_product_enable_password_class"
                ]
            );

            
            add_settings_field(
                'ppws_single_product_set_password_expiry_textbox',
                __('Set Password Expiry Days', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_password_settings'),
                'ppws-single-product-password-settings-section',
                'ppws_single_product_password_settings_section',
                ['type' => 'number', 'label_for' => 'ppws_single_product_set_password_expiry_field_textbox', 'description' => 'Set expiry time of password for pages.', 'placeholder' => 'Set password expiry', 'class' => " ppws-single-product-enable-password-section $ppws_single_product_enable_password_class"]
            );

            /* Password Settings End */

            /* User Role Start */
            add_settings_section(
                'ppws_single_product_user_role_settings_section',
                __('User Role', 'password-protected-store-for-woocommerce'),
                array(),
                'ppws-single-product-user-role-settings-section'
            );

            // Add the fields for user role settings.
            add_settings_field(
                'enable_disable_user_role',
                __('Enable/Disable User Role', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_password_settings'),
                'ppws-single-product-user-role-settings-section',
                'ppws_single_product_user_role_settings_section',
                ['type' => 'checkbox', 'label_for' => 'enable_user_role', 'description' => 'Enable to set user wise password for pages.<br> When user role is disable then password apply for both loggedin user and non logged in user']
            );

            add_settings_field(
                'ppws_single_product_user_select_role_radio',
                __('Select User Role', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_select_user_role_settings'),
                'ppws-single-product-user-role-settings-section',
                'ppws_single_product_user_role_settings_section',
                ['type' => 'radio', 'label_for' => 'ppws_single_product_select_user_role_field_radio', 'description' => 'Enable to set user wise password for pages.<br> When user role is disable then password apply for both loggedin user and non logged in user']
            );

            add_settings_field(
                'ppws_single_product_logged_in_user_checkbox',
                __('Select Logged In User', 'password-protected-store-for-woocommerce'),
                array($this, 'ppws_single_product_logged_in_user_role_settings'),
                'ppws-single-product-user-role-settings-section',
                'ppws_single_product_user_role_settings_section',
                ['type' => 'checkbox', 'label_for' => 'ppws_single_product_logged_in_user_field_checkbox', 'class' => 'ppws-page-logged-in-user-section', 'description' => 'Selected users get password form at front side.']
            );
            /* User Role End */
        } 
        
        // Callback function to display the single product password settings field in the admin panel.
        public function ppws_single_product_password_settings($args) {
            global $ppws_single_product_options;
        
            // Retrieve the current value of the field from the options.
            $value = isset($ppws_single_product_options[$args['label_for']]) ? $ppws_single_product_options[$args['label_for']] : '';

            if ($args['type'] == 'checkbox') {
                ?>
                <label class="ppws-switch">
                    <input type="checkbox" class="ppws-checkbox <?php if (isset($args['custom_class'])) esc_attr_e($args['custom_class']); ?>" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']) ?>]" id="<?php esc_attr_e($args['label_for']) ?>" value="on" <?php checked($value, 'on'); ?>>
                    <span class="ppws-slider ppws-round"></span>
                </label>
                <p class="ppws-note"> <?php echo wp_kses($args['description'], array('br' => array())); ?> </p>
                <?php
            } elseif ($args['type'] == 'text') {
                ?>
                <input type="text" class="ppws-textbox ppws-pwd-input" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']) ?>]" id="<?php esc_attr_e($args['label_for']) ?>" placeholder="<?php esc_attr_e($args['placeholder']) ?>" value="<?php esc_attr_e(ppws_decrypted_password($value)); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ($args['type'] == 'number') {
                ?>
                <input type="number" class="ppws-numberbox" min="1" max="400" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']); ?>]" id="<?php esc_attr_e($args['label_for']) ?>" value="<?php esc_attr_e($value) ?>" placeholder="<?php esc_attr_e($args['placeholder']) ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        // Callback function to display the single product user role settings field in the admin panel.
        public function ppws_single_product_logged_in_user_role_settings($args) {
            global $ppws_single_product_options;
            $value = array();
            $blank_arr = array();
            $value = isset($ppws_single_product_options[$args['label_for']]) ? $ppws_single_product_options[$args['label_for']] : $blank_arr;
            if (isset($ppws_single_product_options[$args['label_for']]) && !empty($ppws_single_product_options[$args['label_for']])) {
                $value = explode(",", $ppws_single_product_options[$args['label_for']]);
            }

            if ($args['type'] == 'checkbox') {
                global $wp_roles;
                $all_roles = $wp_roles->roles;
                $editable_roles = apply_filters('editable_roles', $all_roles);?>
                <div class="ppws_all_user_list">
                    <div class="ppws_all_user_list_input">
                        <label>
                            <input type="checkbox" class="ppws-checkbox editable_roles_all"><?php _e('All', 'password-protected-store-for-woocommerce') ?>
                        </label>
                    </div>
                    <?php
                    foreach ($editable_roles as $role) {
                        if ($role['name'] != 'Administrator') {
                            ?>
                            <div class="ppws_all_user_list_input">
                                <label>
                                    <input type="checkbox" class="ppws-checkbox editable_roles_single" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']) ?>][]" value="<?php esc_attr_e($role['name']); ?>" <?php checked(in_array($role['name'], $value)); ?>><?php esc_attr_e($role['name']); ?>
                                </label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        // Callback function to display the single product user role selection settings field in the admin panel.
        public function ppws_single_product_select_user_role_settings($args) {
            global $ppws_single_product_options;

            if ($args['type'] == 'radio') {
            ?>
                <label class="ppws-label"><input type="radio" class="<?php esc_attr_e('ppws_user_non_logged_in_user'); ?>" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']); ?>]" value="non-logged-in-user" <?php checked('non-logged-in-user', $ppws_single_product_options[$args['label_for']] ?? 'non-logged-in-user'); ?>><?php _e('Non Logged In User', 'password-protected-store-for-woocommerce') ?></label>

                <label class="ppws-label"> <input type="radio" class="<?php esc_attr_e('ppws_user_logged_in_user'); ?>" name="ppws_single_product_settings[<?php esc_attr_e($args['label_for']); ?>]" value="logged-in-user" <?php checked('logged-in-user', $ppws_single_product_options[$args['label_for']] ?? null); ?>><?php _e('Logged In User', 'password-protected-store-for-woocommerce') ?></label>
                <p class="ppws-note ppws-userrole-error ppws-hide-section">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="18px" height="18px" x="0" y="0" viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <path style="" d="M11.812,0C5.289,0,0,5.289,0,11.812s5.289,11.813,11.812,11.813s11.813-5.29,11.813-11.813   S18.335,0,11.812,0z M14.271,18.307c-0.608,0.24-1.092,0.422-1.455,0.548c-0.362,0.126-0.783,0.189-1.262,0.189   c-0.736,0-1.309-0.18-1.717-0.539s-0.611-0.814-0.611-1.367c0-0.215,0.015-0.435,0.045-0.659c0.031-0.224,0.08-0.476,0.147-0.759   l0.761-2.688c0.067-0.258,0.125-0.503,0.171-0.731c0.046-0.23,0.068-0.441,0.068-0.633c0-0.342-0.071-0.582-0.212-0.717   c-0.143-0.135-0.412-0.201-0.813-0.201c-0.196,0-0.398,0.029-0.605,0.09c-0.205,0.063-0.383,0.12-0.529,0.176l0.201-0.828   c0.498-0.203,0.975-0.377,1.43-0.521c0.455-0.146,0.885-0.218,1.29-0.218c0.731,0,1.295,0.178,1.692,0.53   c0.395,0.353,0.594,0.812,0.594,1.376c0,0.117-0.014,0.323-0.041,0.617c-0.027,0.295-0.078,0.564-0.152,0.811l-0.757,2.68   c-0.062,0.215-0.117,0.461-0.167,0.736c-0.049,0.275-0.073,0.485-0.073,0.626c0,0.356,0.079,0.599,0.239,0.728   c0.158,0.129,0.435,0.194,0.827,0.194c0.185,0,0.392-0.033,0.626-0.097c0.232-0.064,0.4-0.121,0.506-0.17L14.271,18.307z    M14.137,7.429c-0.353,0.328-0.778,0.492-1.275,0.492c-0.496,0-0.924-0.164-1.28-0.492c-0.354-0.328-0.533-0.727-0.533-1.193   c0-0.465,0.18-0.865,0.533-1.196c0.356-0.332,0.784-0.497,1.28-0.497c0.497,0,0.923,0.165,1.275,0.497   c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z" fill="#030104" data-original="#030104" class=""></path>
                    </svg><?php _e('You must first enable user roles to select any specific user role.','password-protected-store-for-woocommerce'); ?>
                </p>
            <?php
            }
        }
        // Callback function to sanitize the submitted settings before saving to the database.
        public function sanitize_settings($input) {
            $new_input = array();

            if (isset($input['ppws_single_product_enable_password_field_checkbox']) && !empty($input['ppws_single_product_enable_password_field_checkbox'])) {
                $new_input['ppws_single_product_enable_password_field_checkbox'] = sanitize_text_field($input['ppws_single_product_enable_password_field_checkbox']);
            }
            
            if (isset($input['ppws_single_product_enable_password_field_checkbox_for_admin']) && !empty($input['ppws_single_product_enable_password_field_checkbox_for_admin'])) {
                $new_input['ppws_single_product_enable_password_field_checkbox_for_admin'] = sanitize_text_field($input['ppws_single_product_enable_password_field_checkbox_for_admin']);
            }

            if (isset($input['ppws_single_product_set_password_expiry_field_textbox']) && !empty($input['ppws_single_product_set_password_expiry_field_textbox'])) {
                $new_input['ppws_single_product_set_password_expiry_field_textbox'] = sanitize_text_field($input['ppws_single_product_set_password_expiry_field_textbox']);
            } else {
                $new_input['ppws_single_product_set_password_expiry_field_textbox'] = 1;
            }

            if (isset($input['enable_user_role'])) {
                $new_input['enable_user_role'] = sanitize_text_field($input['enable_user_role']);

                if (isset($input['ppws_single_product_select_user_role_field_radio'])) {
                    $new_input['ppws_single_product_select_user_role_field_radio'] = sanitize_text_field($input['ppws_single_product_select_user_role_field_radio']);
                }

                if (isset($input['ppws_single_product_logged_in_user_field_checkbox'])) {
                    $user_role_list = implode(",", $input['ppws_single_product_logged_in_user_field_checkbox']);
                    $new_input['ppws_single_product_logged_in_user_field_checkbox'] = sanitize_text_field($user_role_list);
                }
            }

            return $new_input;
        }
    }
}