<?php
/* Main tab settings class() from options.php */
if ( !class_exists( 'ppws_form_settings' ) ) {


    /* Main option key for store data for Form Settings */
    $ppws_form_settings_option = get_option( 'ppws_form_content_option' );
    class ppws_form_settings {
        public function __construct() {
            add_action( 'admin_init', array( $this, 'ppws_form_settings_register_settings_init' ) );
        }

        /* Form creation class() call back function from options.php */
        function ppws_form_settings_callback() {
            ?>
            <form action="options.php?tab=form-content" method="post">
                <?php settings_fields( 'ppws-settings-options' ); ?>
                <div class="ppws-section">
                    <?php do_settings_sections( 'ppws-form-settings-section' );
                    ?>
                </div>
                <div class="ppws-submit-btn">

                    <?php submit_button( 'Save Setting' ); ?>
                </div>
            </form>
            <?php
        }

        /* Main function for register and rendering settings field */
        public function ppws_form_settings_register_settings_init() {
            /* hook for register settings */
            register_setting( 'ppws-settings-options', 'ppws_form_content_option', array( $this, 'sanitize_settings' ) );

            add_settings_section( 'ppws_form_settings_section', __( 'Form Settings', 'password-protected-store-for-woocommerce' ), array(), 'ppws-form-settings-section' );

            add_settings_field( 'ppws_form_title_textbox', __( 'Form Title', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'text', 'label_for' => 'ppws_form_mian_title', 'description' => 'Set title for password form shown on fontend.', 'placeholder' => 'Set form title' ]  );

            add_settings_field( 'ppws_form_above_content_textarea', __( 'Form Above Content', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'textarea', 'editor_id' => 'editor_one', 'label_for' => 'ppws_form_above_content', 'description' => 'Set above content for password form shown on fontend.', 'placeholder' => 'Put content here.' ] );

            add_settings_field( 'ppws_form_below_content_textarea', __( 'Form Below Content', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'textarea', 'editor_id' => 'editor_two', 'label_for' => 'ppws_form_below_content', 'description' => 'Set below content for password form shown on fontend.', 'placeholder' => 'Put content here.' ] );

            add_settings_field( 'ppws_form_button_text_textbox', __( 'Submit Button Text', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'text', 'label_for' => 'ppws_form_submit_btn_text', 'description' => 'Set submit button text for password form shown on fontend.', 'placeholder' => 'Set form button text' ] );
           
            add_settings_field( 'ppws_form_placeholder_textbox', __( 'Form Inputbox placeholder', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'text', 'label_for' => 'ppws_form_pwd_placeholder', 'description' => 'Set inputbox placeholder for password form shown on fontend.', 'placeholder' => 'Set form inputbox placeholder' ]  );
    
            add_settings_field( 'ppws_incorrect_password_message_textbox', __( 'Incorrect Password Message', 'password-protected-store-for-woocommerce' ), array( $this, 'ppws_form_settings_fun' ), 'ppws-form-settings-section', 'ppws_form_settings_section', [ 'type' => 'text', 'label_for' => 'ppws_incorrect_password_message', 'description' => 'Change incorrect password message text. Default: Password mismatch', 'placeholder' => 'Password mismatch' ]  );        
        }

        public function ppws_form_settings_fun( $args ) {
            global $ppws_form_settings_option;
            $value = isset( $ppws_form_settings_option[ $args[ 'label_for' ] ] ) ? $ppws_form_settings_option[ $args[ 'label_for' ] ] : '';

            if ( $args[ 'type' ] == 'text' ) {
                ?>
                <input type="text" class="ppws-textbox" name="ppws_form_content_option[<?php esc_attr_e( $args[ 'label_for' ] ) ?>]" id="<?php esc_attr_e( $args[ 'label_for' ] ) ?>" placeholder="<?php esc_attr_e( $args[ 'placeholder' ] ) ?>" value="<?php esc_attr_e($value); ?>">
                  <p class="ppws-note"> 
                    <?php 
                      $allowed_html = array( 'br'     => array(), );
                    echo wp_kses( $args['description'], $allowed_html ); ?> 
                </p>
                <?php
            } elseif ( $args[ 'type' ] == 'textarea' ) {
                $content = esc_html__($value);
                    
                $settings = array(
                    'textarea_name' => "ppws_form_content_option[". $args[ 'label_for' ]."]",
                   
                    'editor_css'    => '<style>.ppws-wp-editor-block .wp-editor-area{height:300px; width:100%;}</style>',
                ); 
                ?>
    
                <div class="ppws-wp-editor-block">
                    <?php //wp_editor( htmlspecialchars_decode($value), $args[ 'editor_id' ], $settings ); ?>
                    <textarea name="ppws_form_content_option[<?php esc_attr_e( $args[ 'label_for' ] ) ?>];" id="<?php esc_attr_e($args[ 'label_for' ]); ?>" rows="12" class="wp-editor wp-editor-area"> <?php  echo wp_unslash($content); ?></textarea>
                </div>
                  <p class="ppws-note"> 
                    <?php 
                      $allowed_html = array( 'br'     => array(), );
                    echo wp_kses( $args['description'], $allowed_html ); ?> 
                </p>
                <?php
            }
        }

        public function sanitize_settings( $input ) {
            $new_input = array();

            if( isset( $input[ 'ppws_form_mian_title' ] ) && !empty( $input[ 'ppws_form_mian_title' ] ) ) {
                $new_input[ 'ppws_form_mian_title' ] = sanitize_text_field( $input[ 'ppws_form_mian_title' ] );
            }

            if( isset( $input[ 'ppws_form_above_content' ] ) && !empty( $input[ 'ppws_form_above_content' ] ) ) {
                $new_input[ 'ppws_form_above_content' ] = sanitize_text_field( htmlentities($input[ 'ppws_form_above_content' ]) );
            }

            if( isset( $input[ 'ppws_form_below_content' ] ) && !empty( $input[ 'ppws_form_below_content' ] ) ) {
                $new_input[ 'ppws_form_below_content' ] = sanitize_text_field( htmlentities($input[ 'ppws_form_below_content' ]) );
            }

            if( isset( $input[ 'ppws_form_submit_btn_text' ] ) && !empty( $input[ 'ppws_form_submit_btn_text' ] ) ) {
                $new_input[ 'ppws_form_submit_btn_text' ] = sanitize_text_field( $input[ 'ppws_form_submit_btn_text' ] );
            }

            if( isset( $input[ 'ppws_form_pwd_placeholder' ] ) && !empty( $input[ 'ppws_form_pwd_placeholder' ] ) ) {
                $new_input[ 'ppws_form_pwd_placeholder' ] = sanitize_text_field( $input[ 'ppws_form_pwd_placeholder' ] );
            }

            if( isset( $input[ 'ppws_incorrect_password_message' ] ) && !empty( $input[ 'ppws_incorrect_password_message' ] ) ) {
                $new_input[ 'ppws_incorrect_password_message' ] = sanitize_text_field( $input[ 'ppws_incorrect_password_message' ] );
            }

            return $new_input;
        }
    }
}
?>