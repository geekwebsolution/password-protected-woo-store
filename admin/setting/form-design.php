<?php
if ( !class_exists( 'ppws_form_style_settings' ) ) {
    $ppws_form_style_settings_option = get_option( 'ppws_form_desgin_settings' );
    class ppws_form_style_settings {
        public function __construct() {
            add_action( 'admin_init', array( $this, 'ppws_form_style_settings_register_settings_init' ) );
        }

        function ppws_form_style_settings_callback() {
            ?>
            <form action="options.php?tab=form-design" method="post">
                <?php settings_fields( 'ppws-settings-options' ); ?>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-title-style-settings-section' ); ?>
                </div>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-content-style-settings-section' ); ?>
                </div>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-inputbox-style-settings-section' ); ?>
                </div>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-button-style-settings-section' ); ?>
                </div>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-background-settings-section' ); ?>
                </div>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-additional-style-settings-section' ); ?>
                </div>
                <div class="ppws-submit-btn">
                    
                    <?php submit_button( 'Save Setting' ); 
                    ?>
                </div>
            </form>
            <?php
        }

        public function ppws_form_style_settings_register_settings_init() {
            register_setting( 'ppws-settings-options', 'ppws_form_desgin_settings', array( $this, 'sanitize_settings' ) );

            /* Form title start */
            add_settings_section( 'ppws_form_title_style_settings_section', __( 'Page Title', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-title-style-settings-section' );

            add_settings_field( 'ppws_form_title_color_textbox', __( 'Title Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_title_style_settings_fun' ), 'ppws-form-title-style-settings-section', 'ppws_form_title_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_title_color_field_textbox', 'description' => 'Set title color for password form shown on frontend .', 'placeholder' => 'Set form title color.' ]  );

            add_settings_field( 'ppws_form_title_size_textbox', __( 'Title Size', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_title_style_settings_fun' ), 'ppws-form-title-style-settings-section', 'ppws_form_title_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_title_size_field_textbox', 'description' => 'Set title size for password form shown on frontend .', 'placeholder' => 'Set form title size.' ]  );

            add_settings_field( 'ppws_form_title_alignment_selectbox', __( 'Title Alignment', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_title_alignment_style_settings_fun' ), 'ppws-form-title-style-settings-section', 'ppws_form_title_style_settings_section', [ 'type' => 'select', 'label_for' => 'ppws_form_title_alignment_field_textbox', 'description' => 'Set title alignment for password form shown on frontend .', 'placeholder' => 'Set form title alignment.' ]  );

            /* Form title end */

            /* Form content start */
            add_settings_section( 'ppws_form_content_style_settings_section', __( 'Page Content', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-content-style-settings-section' );

            add_settings_field( 'ppws_form_content_color_textbox', __( 'Content Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_content_style_settings_fun' ), 'ppws-form-content-style-settings-section', 'ppws_form_content_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_content_color_field_textbox', 'description' => 'Set content color for password form shown on frontend .', 'placeholder' => 'Set form content color.' ] );

            add_settings_field( 'ppws_form_content_size_textbox', __( 'Content Size', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_content_style_settings_fun' ), 'ppws-form-content-style-settings-section', 'ppws_form_content_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_content_size_field_textbox', 'description' => 'Set content size for password form shown on frontend .', 'placeholder' => 'Set form content size.' ]  );

            add_settings_field( 'ppws_form_content_alignment_selectbox', __( 'Content Alignment', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_content_alignment_style_settings_fun' ), 'ppws-form-content-style-settings-section', 'ppws_form_content_style_settings_section', [ 'type' => 'select', 'label_for' => 'ppws_form_content_alignment_field_textbox', 'description' => 'Set content alignment for password form shown on frontend .', 'placeholder' => 'Set form content alignment.' ]  );

            /* Form content end */

            /* Form inputbox start */
            add_settings_section( 'ppws_form_inputbox_style_settings_section', __( 'Form Inputbox', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-inputbox-style-settings-section' );

            add_settings_field( 'ppws_form_inputbox_color_textbox', __( 'Inputbox Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_inputbox_style_settings_fun' ), 'ppws-form-inputbox-style-settings-section', 'ppws_form_inputbox_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_inputbox_color_field_textbox', 'description' => 'Set inputbox color for password form shown on frontend .', 'placeholder' => 'Set form inputbox color.' ] );

            add_settings_field( 'ppws_form_inputbox_border_textbox', __( 'Inputbox Border', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_inputbox_style_settings_fun' ), 'ppws-form-inputbox-style-settings-section', 'ppws_form_inputbox_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_inputbox_border_width', 'description' => 'Set inputbox border for password form shown on frontend .', 'placeholder' => 'Set form inputbox border.' ] );

            add_settings_field('ppws_form_inputbox_border_color_textbox',  __( 'Inputbox Border Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_inputbox_style_settings_fun' ), 'ppws-form-inputbox-style-settings-section', 'ppws_form_inputbox_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_inputbox_border_color', 'description' => 'Set inputbox border color for password form shown on frontend .']);


            add_settings_field( 'ppws_form_placeholder_text_color_textbox', __( 'Inputbox Placeholder Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_inputbox_style_settings_fun' ), 'ppws-form-inputbox-style-settings-section', 'ppws_form_inputbox_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_placeholder_text_color', 'description' => 'Set inputbox placeholder color for password form shown on frontend .' ]  );

            add_settings_field( 'ppws_form_inputbox_text_size_textbox', __( 'Inputbox font Size', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_inputbox_style_settings_fun' ), 'ppws-form-inputbox-style-settings-section', 'ppws_form_inputbox_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_inputbox_text_size_field_textbox', 'placeholder' => 'Set input font size.', 'description' => 'Set inputbox size for password form shown on frontend .' ]  );

            /* Form inputbox end */

            /* Form button start */
            add_settings_section( 'ppws_form_button_style_settings_section', __( 'Form Button Style', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-button-style-settings-section' );
            
            add_settings_field( 'ppws_form_button_color_colorpicker', __( 'Button Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_button_color_field_textbox', 'description' => 'Set button color for password form shown on frontend .', 'placeholder' => 'Set form button color.' ] );

            add_settings_field( 'ppws_form_button_hover_color_colorpicker', __( 'Button Hover Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_button_hover_color', 'description' => 'Set button hover color for password form shown on frontend .', 'placeholder' => 'Set form button hover color.' ] );

            add_settings_field( 'ppws_form_button_font_color_colorpicker', __( 'Button Font Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_button_font_color', 'description' => 'Set button font color for password form shown on frontend .', 'placeholder' => 'Set form button font color.' ] );

            add_settings_field( 'ppws_form_button_font_hover_color_colorpicker', __( 'Button Font Hover Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_button_font_hover_color', 'description' => 'Set button font hover color for password form shown on frontend .', 'placeholder' => 'Set form button font hover color.' ] );

            add_settings_field( 'ppws_form_button_font_size', __( 'Button Font Size', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_submit_btn_font_size', 'description' => 'Set button size for password form shown on frontend .', 'placeholder' => 'Set Font Size' ]  );

            add_settings_field( 'ppws_form_button_border_textbox', __( 'Button Border', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_button_border_field_textbox', 'description' => 'Set button border for password form shown on frontend .', 'placeholder' => 'Set form button border.' ]  );

            add_settings_field( 'ppws_form_button_border_color_textbox', __( 'Button Border Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_button_color_style_settings_fun' ), 'ppws-form-button-style-settings-section', 'ppws_form_button_style_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_button_border_color_field_textbox', 'description' => 'Set button border color for password form shown on frontend .' ] );

            /* Form button end */

            add_settings_section( 'ppws_form_background_settings_section', __( 'Background', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-background-settings-section' );

            
            add_settings_field( 'ppws_form_page_background_radio', __( 'Page Background', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_radio' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'radio', 'label_for' => 'ppws_form_page_background_field_radio', 'description' => 'Select page background type.' ] );

            global $ppws_form_style_settings_option;
            $ppws_form_page_background_radio = isset($ppws_form_style_settings_option['ppws_form_page_background_field_radio']) ? $ppws_form_style_settings_option['ppws_form_page_background_field_radio'] : "";
            $ppws_form_page_background_image_selecter_class = "";
            if($ppws_form_page_background_radio != 'image') {
                $ppws_form_page_background_image_selecter_class = "ppws-hide-section";
            }

            add_settings_field( 'ppws_form_page_background_image_selecter', __( 'Select Page Background Image', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_image_selecter' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'image_selecter', 'label_for' => 'ppws_form_page_background_field_image_selecter', 'placeholder' => 'Select Image', 'class' => "$ppws_form_page_background_image_selecter_class ppws-form-page-background-image-selecter", 'description' => 'Select page background image for password form shown on frontend .' ] );

            global $ppws_form_style_settings_option;
            $ppws_form_page_background_radio = isset($ppws_form_style_settings_option['ppws_form_page_background_field_radio']) ? $ppws_form_style_settings_option['ppws_form_page_background_field_radio'] : "";
            $ppws_form_page_background_color_selecter_class = "";
            if($ppws_form_page_background_radio != 'solid-color') {
                $ppws_form_page_background_color_selecter_class = "ppws-hide-section";
            }

            add_settings_field( 'ppws_form_page_background_color_selecter', __( 'Select Page Background Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_color_selecter' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'color_selecter', 'label_for' => 'ppws_form_page_background_field_color_selecter', 'class' => "$ppws_form_page_background_color_selecter_class ppws-form-page-background-color-selecter", 'description' => 'Select page background color for password form shown on frontend .' ] );

            add_settings_field( 'ppws_form_background_opacity_page_textbox', __( 'Page Background Opacity', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_background_opacity_style_settings_fun' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_page_background_opacity', 'description' => 'Set page background opacity for password form shown on frontend .', 'placeholder' => 'Page background opacity.', 'min' => '0', 'max'=> '1.0' ] );

            add_settings_field('ppws_page_background_opacity_color_textbox', __( 'Page Background Opacity Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_background_opacity_style_settings_fun' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_page_page_background_opacity_color', 'description' => 'Set page background opacity color for password form shown on frontend .' ]);
          

            add_settings_field( 'ppws_form_background_radio', __( 'Form Background', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_radio' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'radio', 'label_for' => 'ppws_form_background_field_radio', 'description' => 'Select your form background type.' ] );

            global $ppws_form_style_settings_option;
            $ppws_form_background_radio = isset($ppws_form_style_settings_option['ppws_form_background_field_radio']) ? $ppws_form_style_settings_option['ppws_form_background_field_radio'] : "";
            $ppws_form_background_image_selecter_class = "";
            if($ppws_form_background_radio != 'image') {
                $ppws_form_background_image_selecter_class = "ppws-hide-section";
            }

            add_settings_field('ppws_form_background_image_selecter', __( 'Select Form Background Image', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_image_selecter' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'image_selecter', 'label_for' => 'ppws_form_background_field_image_selecter', 'placeholder' => 'Select Image', 'description' => 'Select your background image.', 'class' => "$ppws_form_background_image_selecter_class ppws-form-background-image-selecter", 'description' => 'Select your form background image for password form shown on frontend .' ]);

            global $ppws_form_style_settings_option;
            $ppws_form_background_radio = isset($ppws_form_style_settings_option['ppws_form_background_field_radio']) ? $ppws_form_style_settings_option['ppws_form_background_field_radio'] : "";
            $ppws_form_background_color_selecter_class = "";
            if($ppws_form_background_radio != 'solid-color') {
                $ppws_form_background_color_selecter_class = "ppws-hide-section";
            }
            add_settings_field('ppws_form_background_color_selecter', __('Select Form Background Color', 'password-protected-store-for-woocommerce'), array( $this, 'ppws_form_settings_color_selecter' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'color_selecter', 'label_for' => 'ppws_form_background_field_color_selecter', 'class' => "$ppws_form_background_color_selecter_class ppws-form-background-color-selecter", 'description' => 'Select your form background color for password form shown on frontend .' ] );

            

            add_settings_field( 'ppws_form_background_opacity_form_textbox', __( 'Form Background Opacity', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_background_opacity_style_settings_fun' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'number', 'label_for' => 'ppws_form_background_opacity', 'description' => 'Set form background opacity for password form shown on frontend .', 'placeholder' => 'Form background opacity.', 'min' => '0', 'max'=> '1.0' ] );

            add_settings_field('ppws_form_background_opacity_color_textbox', __( 'Form Background Opacity Color', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_background_opacity_style_settings_fun' ), 'ppws-form-background-settings-section', 'ppws_form_background_settings_section', [ 'type' => 'color', 'label_for' => 'ppws_form_background_opacity_color', 'description' => 'Set form background opacity color for password form shown on frontend .' ]);


            /**
             * Additional style section start
             */
            add_settings_section(
                'ppws_form_additional_style_settings_section', // Section ID
                __('Additional Style', 'password-protected-store-for-woocommerce'), // Section title
                array(), // Callback function (optional)
                'ppws-form-additional-style-settings-section' // Page slug
            );

            // Add the settings field for custom CSS textarea
            add_settings_field(
                'ppws_form_additional_style_textarea', // Field ID
                __('Custom CSS', 'password-protected-store-for-woocommerce'), // Field title
                array($this, 'ppws_form_additional_style_textarea_fun'), // Callback function to render the field
                'ppws-form-additional-style-settings-section', // Page slug
                'ppws_form_additional_style_settings_section', // Section ID
                array(
                    'type' => 'textarea',
                    'label_for' => 'ppws_form_additional_style_field_textarea',
                    'description' => 'Enter your additional CSS for the form popup.'
                ) // Additional arguments for the field
            );

        }

        public function ppws_form_settings_radio( $args ) {
            global $ppws_form_style_settings_option;

            if ( $args[ 'type' ] == 'radio' ) {
              
                ?>
                <label>
                    <input type="radio" class="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" value="none" <?php checked('none', $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ?? null); ?>><?php _e('None','password-protected-store-for-woocommerce') ?>
                </label>
                <label>
                    <input type="radio" class="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" value="solid-color" <?php checked('solid-color', $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ?? null); ?>><?php _e('Solid Color','password-protected-store-for-woocommerce') ?>
                </label>
                <label>
                    <input type="radio" class="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" value="image" <?php checked('image', $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ?? null); ?>><?php _e('Image','password-protected-store-for-woocommerce') ?>
                </label>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_settings_image_selecter( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';
            ?>
                <input type="text" class="ppws-textbox" readonly name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
        }

        public function ppws_form_settings_color_selecter( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
        }


        public function ppws_form_title_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'number' ) {
                ?>
                <input type="number" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" min="0" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'checkbox' ) {
                ?>
                <label class="ppws-switch">
                    <input type="checkbox" class="ppws-checkbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" value="on" <?php if($value == "on"){ esc_attr_e('checked'); } ?>>
                    <span class="ppws-slider ppws-round"></span>
                </label>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'color' ) {
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_title_alignment_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';
            
            if ( $args[ 'type' ] == 'select' ) {
                ?>
                <select name="ppws_form_desgin_settings[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="right" <?php if($value == "right"){ esc_attr_e('selected'); } ?>><?php _e('Right','password-protected-store-for-woocommerce') ?></option>
                    <option value="center" <?php if($value == "center"){ esc_attr_e('selected'); } ?>><?php _e('Center','password-protected-store-for-woocommerce') ?></option>
                    <option value="left" <?php if($value == "left"){ esc_attr_e('selected'); } ?>><?php _e('Left','password-protected-store-for-woocommerce') ?></option>
                </select>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_content_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'number' ) {
                ?>
                <input type="number" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" min="0" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'checkbox' ) {
                ?>
                <label class="ppws-switch">
                    <input type="checkbox" class="ppws-checkbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" value="on" <?php if($value == "on"){ esc_attr_e('checked'); } ?>>
                    <span class="ppws-slider ppws-round"></span>
                </label>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'color' ) {
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_content_alignment_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';
            
            if ( $args[ 'type' ] == 'select' ) {
                ?>
                <select name="ppws_form_desgin_settings[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="right" <?php if($value == "right"){ esc_attr_e('selected'); } ?>><?php _e('Right','password-protected-store-for-woocommerce') ?></option>
                    <option value="center" <?php if($value == "center"){ esc_attr_e('selected'); } ?>><?php _e('Center','password-protected-store-for-woocommerce') ?></option>
                    <option value="left" <?php if($value == "left"){ esc_attr_e('selected'); } ?>><?php _e('Left','password-protected-store-for-woocommerce') ?></option>
                </select>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_inputbox_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'text' ) {
                ?>
                <input type="text" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'checkbox' ) {
                ?>
                <label class="ppws-switch">
                    <input type="checkbox" class="ppws-checkbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" value="on" <?php if($value == "on"){ esc_attr_e('checked'); } ?>>
                    <span class="ppws-slider ppws-round"></span>
                </label>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'color' ) {
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif( $args[ 'type' ] == 'number' ){
                ?>
                <input type="number" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_button_color_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'text' ) {
                ?>
                <input type="text" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'checkbox' ) {
                ?>
                <label class="ppws-switch">
                    <input type="checkbox" class="ppws-checkbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" value="on" <?php if($value == "on"){ esc_attr_e('checked'); } ?>>
                    <span class="ppws-slider ppws-round"></span>
                </label>
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif ( $args[ 'type' ] == 'color' ) {
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } elseif( $args[ 'type' ] == 'number' ){
                ?>
                <input type="number" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" min="0" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }

        public function ppws_form_background_opacity_style_settings_fun( $args ) {
            global $ppws_form_style_settings_option;
            $value = isset( $ppws_form_style_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_style_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'number' ) {
                ?>
                <input type="number" class="ppws-textbox" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>" min="<?php esc_attr_e( $args[ 'min' ] ) ?>" max="<?php esc_attr_e( $args[ 'max' ] ) ?>" step=".01" >
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            } else if( $args[ 'type' ] == 'color' ) {
                ?>
                <input class="ppws-color-field" name="ppws_form_desgin_settings[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" type="text" value="<?php esc_attr_e($value); ?>" data-default-color="#effeff" />
                <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
                <?php
            }
        }
        
        // Additional style textarea field callback function
        public function ppws_form_additional_style_textarea_fun($args) {
            global $ppws_form_style_settings_option;
            
            // Get the current value of the textarea field
            $value = isset($ppws_form_style_settings_option[$args['label_for']]) ? $ppws_form_style_settings_option[$args['label_for']] : '';
            ?>
            <label>
                <textarea name="ppws_form_desgin_settings[<?php esc_attr_e($args['label_for']) ?>]" class="ppws-textbox" cols="50" rows="4"><?php esc_attr_e($value); ?></textarea>
            </label>
            <p class="ppws-note"><?php esc_attr_e($args['description']) ?></p>
            <?php
        }


        public function sanitize_settings( $input ) {
            $new_input = array();


            if( isset( $input[ 'ppws_form_title_color_field_textbox' ] ) && !empty( $input[ 'ppws_form_title_color_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_title_color_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_title_color_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_title_size_field_textbox' ] ) && !empty( $input[ 'ppws_form_title_size_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_title_size_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_title_size_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_title_alignment_field_textbox' ] ) && !empty( $input[ 'ppws_form_title_alignment_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_title_alignment_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_title_alignment_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_content_color_field_textbox' ] ) && !empty( $input[ 'ppws_form_content_color_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_content_color_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_content_color_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_content_size_field_textbox' ] ) && !empty( $input[ 'ppws_form_content_size_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_content_size_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_content_size_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_content_alignment_field_textbox' ] ) && !empty( $input[ 'ppws_form_content_alignment_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_content_alignment_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_content_alignment_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_inputbox_color_field_textbox' ] ) && !empty( $input[ 'ppws_form_inputbox_color_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_inputbox_color_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_inputbox_color_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_inputbox_border_width' ] ) && !empty( $input[ 'ppws_form_inputbox_border_width' ] ) ) {
                $new_input[ 'ppws_form_inputbox_border_width' ] = sanitize_text_field( $input[ 'ppws_form_inputbox_border_width' ] );
            }

            if( isset( $input[ 'ppws_form_placeholder_text_color' ] ) && !empty( $input[ 'ppws_form_placeholder_text_color' ] ) ) {
                $new_input[ 'ppws_form_placeholder_text_color' ] = sanitize_text_field( $input[ 'ppws_form_placeholder_text_color' ] );
            }

            if( isset( $input[ 'ppws_form_inputbox_text_size_field_textbox' ] ) && !empty( $input[ 'ppws_form_inputbox_text_size_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_inputbox_text_size_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_inputbox_text_size_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_button_color_field_textbox' ] ) && !empty( $input[ 'ppws_form_button_color_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_button_color_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_button_color_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_button_hover_color' ] ) && !empty( $input[ 'ppws_form_button_hover_color' ] ) ) {
                $new_input[ 'ppws_form_button_hover_color' ] = sanitize_text_field( $input[ 'ppws_form_button_hover_color' ] );
            }

            if( isset( $input[ 'ppws_form_button_font_color' ] ) && !empty( $input[ 'ppws_form_button_font_color' ] ) ) {
                $new_input[ 'ppws_form_button_font_color' ] = sanitize_text_field( $input[ 'ppws_form_button_font_color' ] );
            }

            if( isset( $input[ 'ppws_form_button_font_hover_color' ] ) && !empty( $input[ 'ppws_form_button_font_hover_color' ] ) ) {
                $new_input[ 'ppws_form_button_font_hover_color' ] = sanitize_text_field( $input[ 'ppws_form_button_font_hover_color' ] );
            }

            if( isset( $input[ 'ppws_submit_btn_font_size' ] ) && !empty( $input[ 'ppws_submit_btn_font_size' ] ) ) {
                $new_input[ 'ppws_submit_btn_font_size' ] = sanitize_text_field( $input[ 'ppws_submit_btn_font_size' ] );
            }

            if( isset( $input[ 'ppws_form_button_border_field_textbox' ] ) && !empty( $input[ 'ppws_form_button_border_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_button_border_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_button_border_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_page_background_field_radio' ] ) && !empty( $input[ 'ppws_form_page_background_field_radio' ] ) ) {
                $new_input[ 'ppws_form_page_background_field_radio' ] = sanitize_text_field( $input[ 'ppws_form_page_background_field_radio' ] );
            }

            if( isset( $input[ 'ppws_form_background_field_radio' ] ) && !empty( $input[ 'ppws_form_background_field_radio' ] ) ) {
                $new_input[ 'ppws_form_background_field_radio' ] = sanitize_text_field( $input[ 'ppws_form_background_field_radio' ] );
            }

            if( isset( $input[ 'ppws_form_background_field_image_selecter' ] ) && !empty( $input[ 'ppws_form_background_field_image_selecter' ] ) ) {
                $new_input[ 'ppws_form_background_field_image_selecter' ] = sanitize_text_field( $input[ 'ppws_form_background_field_image_selecter' ] );
            }

            if( isset( $input[ 'ppws_form_background_field_color_selecter' ] ) && !empty( $input[ 'ppws_form_background_field_color_selecter' ] ) ) {
                $new_input[ 'ppws_form_background_field_color_selecter' ] = sanitize_text_field( $input[ 'ppws_form_background_field_color_selecter' ] );
            }

            if( isset( $input[ 'ppws_form_page_background_field_image_selecter' ] ) && !empty( $input[ 'ppws_form_page_background_field_image_selecter' ] ) ) {
                $new_input[ 'ppws_form_page_background_field_image_selecter' ] = sanitize_text_field( $input[ 'ppws_form_page_background_field_image_selecter' ] );
            }

            if( isset( $input[ 'ppws_form_page_background_field_color_selecter' ] ) && !empty( $input[ 'ppws_form_page_background_field_color_selecter' ] ) ) {
                $new_input[ 'ppws_form_page_background_field_color_selecter' ] = sanitize_text_field( $input[ 'ppws_form_page_background_field_color_selecter' ] );
            }
            
            if( isset( $input[ 'ppws_form_background_opacity' ] )) {
                $new_input[ 'ppws_form_background_opacity' ] = sanitize_text_field( $input[ 'ppws_form_background_opacity' ] );
            }

            if( isset( $input[ 'ppws_page_background_opacity' ] ) ) {
                $new_input[ 'ppws_page_background_opacity' ] = sanitize_text_field( $input[ 'ppws_page_background_opacity' ] );
            }

            if( isset( $input[ 'ppws_form_inputbox_border_color' ] ) && !empty( $input[ 'ppws_form_inputbox_border_color' ] ) ) {
                $new_input[ 'ppws_form_inputbox_border_color' ] = sanitize_text_field( $input[ 'ppws_form_inputbox_border_color' ] );
            }

            if( isset( $input[ 'ppws_form_button_border_color_field_textbox' ] ) && !empty( $input[ 'ppws_form_button_border_color_field_textbox' ] ) ) {
                $new_input[ 'ppws_form_button_border_color_field_textbox' ] = sanitize_text_field( $input[ 'ppws_form_button_border_color_field_textbox' ] );
            }

            if( isset( $input[ 'ppws_form_background_opacity_color' ] ) && !empty( $input[ 'ppws_form_background_opacity_color' ] ) ) {
                $new_input[ 'ppws_form_background_opacity_color' ] = sanitize_text_field( $input[ 'ppws_form_background_opacity_color' ] );
            }

            if( isset( $input[ 'ppws_page_page_background_opacity_color' ] ) && !empty( $input[ 'ppws_page_page_background_opacity_color' ] ) ) {
                $new_input[ 'ppws_page_page_background_opacity_color' ] = sanitize_text_field( $input[ 'ppws_page_page_background_opacity_color' ] );
            }

            if( isset( $input[ 'ppws_form_additional_style' ] ) && !empty( $input[ 'ppws_form_additional_style' ] ) ) {
                $new_input[ 'ppws_form_additional_style' ] = sanitize_text_field( $input[ 'ppws_form_additional_style' ] );
            }

            if( isset( $input[ 'ppws_form_additional_style_field_textarea' ] ) && !empty( $input[ 'ppws_form_additional_style_field_textarea' ] ) ) {
                $new_input[ 'ppws_form_additional_style_field_textarea' ] = htmlspecialchars( $input[ 'ppws_form_additional_style_field_textarea' ] );
            }


            return $new_input;
        }
    }
}
?>