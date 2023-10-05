<?php
global $product;

$ppws_whole_site_options            = get_option('ppws_general_settings');
$ppws_page_options                  = get_option('ppws_page_settings' );
$ppws_product_categories_options    = get_option('ppws_product_categories_settings' );
$ppws_single_product_settings       = get_option('ppws_single_product_settings');
$ppws_single_categories_settings    = get_option('ppws_single_categories_settings');

$ppws_single_product_meta           = array();
$ppws_single_product_cookie         = array();
$ppws_single_product_password_arg   = array();

$ppws_product_category_password_arg = array();
$ppws_product_categories_args       = array();
$ppws_single_product_category_meta  = array();
$ppws_single_product_cookie_value   = '';
$ppws_single_category_flag          = false;

// Get the product object and its password settings.
$ppws_single_product_obj = get_page_by_path($product, OBJECT, 'product');
if(is_product() && isset($ppws_single_product_obj)){
    $ppws_single_product_meta       = get_post_meta($ppws_single_product_obj->ID, 'ppws_single_product_password_setting', true);
    $ppws_product_categories_args   = ppws_get_product_categories($ppws_single_product_obj->ID);
}

// Check if password protection is enabled for single categories and if it's a product page
if (
    isset($ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox'])
    && 'on' === $ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox']
    && is_product()
) {
    // Get stored category access cookie
    $ppws_single_categories_cookie = ppws_get_cookie("ppws_product_categories_cookie");
    $ppws_single_categories_cookie = json_decode(stripslashes($ppws_single_categories_cookie), true);

    // Check if the cookie prevents access for any category
    if (isset($ppws_single_categories_cookie) && !empty($ppws_single_categories_cookie)) {
        foreach ($ppws_product_categories_args as $ppws_product_category) {
            if (array_key_exists('ppws-' . $ppws_product_category, $ppws_single_categories_cookie)) {
                $ppws_single_category_flag = false; // Access denied
            }
        }
    }

    // Loop through each product category
    foreach ($ppws_product_categories_args as $ppws_product_category) {
        // Get the password setting for the category
        $ppws_single_product_category_meta = get_term_meta($ppws_product_category, 'ppws_single_categories_password_setting', true);
        if (isset($ppws_single_product_category_meta) && !empty($ppws_single_product_category_meta)) {
            // Check if the category is set as Private
            if (
                $ppws_single_product_category_meta['ppws_single_categories_password_setting_radio']
                && 'Private' === $ppws_single_product_category_meta['ppws_single_categories_password_setting_radio']
            ) {
                // Get the password for the category
                $ppws_product_category_password = isset($ppws_single_product_category_meta['ppws_single_categories_password_setting_textbox']) 
                    ? $ppws_single_product_category_meta['ppws_single_categories_password_setting_textbox'] 
                    : '';
                // Check if the password is correct
                if (!empty($ppws_product_category_password)) {
                    if (isset($ppws_single_categories_cookie) && !empty($ppws_single_categories_cookie)) {
                        
                        if (ppws_decrypted_password($ppws_single_categories_cookie['ppws-' . $ppws_product_category])
                        !== ppws_decrypted_password($ppws_product_category_password)
                        ) {
                            $ppws_single_category_flag = true;
                        }
                    }else{
                        $ppws_single_category_flag = true;
                    }
                }
            }
        }
    }
}


if (isset($_POST['ppws_submit'])) {

    $referer       = wp_get_referer();
    if ( $referer ) {
        $secure = ( 'https' === parse_url( $referer, PHP_URL_SCHEME ) );
    } else {
        $secure = false;
    }

    $ppws_current_pass = sanitize_text_field($_POST['ppws_password']);

    // Check if password protection is enabled for a private product and if it's a product page
    if (
        isset($ppws_single_product_meta['ppws_single_product_password_setting_radio'])
        && 'Private' === $ppws_single_product_meta['ppws_single_product_password_setting_radio']
        && isset($ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox'])
        && 'on' === $ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox']
        && is_product()
    ) {
        // Check if the product password is set and correct
        if (
            isset($ppws_single_product_meta['ppws_single_product_password_setting_textbox'])
            && !empty($ppws_single_product_meta['ppws_single_product_password_setting_textbox'])
            && $ppws_current_pass === ppws_decrypted_password($ppws_single_product_password)
        ) {
            // Get product password settings and expiry
            $ppws_single_product_password = $ppws_single_product_meta['ppws_single_product_password_setting_textbox'];
            $ppws_single_product_set_password_expiry = isset($ppws_single_product_settings['ppws_single_product_set_password_expiry_field_textbox'])
                ? $ppws_single_product_settings['ppws_single_product_set_password_expiry_field_textbox']
                : 1;

            // Update the product password cookie
            $ppws_single_product_cookie = ppws_get_cookie("ppws_single_product_cookie");
            $ppws_single_product_cookie = json_decode(stripslashes($ppws_single_product_cookie), true);

            $ppws_single_product_password_arg = array(
                $product => $ppws_single_product_password
            );

            if (isset($ppws_single_product_cookie) && !empty($ppws_single_product_cookie)) {
                if (isset($ppws_single_product_cookie[$product])) {
                    $ppws_single_product_cookie[$product] = $ppws_single_product_password;
                    $ppws_single_product_cookie_value = $ppws_single_product_cookie;
                } else {
                    $ppws_single_product_cookie_value = array_merge($ppws_single_product_password_arg, $ppws_single_product_cookie);
                }
            } else {
                $ppws_single_product_cookie_value = $ppws_single_product_password_arg;
            }

            // Set the updated product password cookie
            setcookie("ppws_single_product_cookie", json_encode($ppws_single_product_cookie_value), time() + ($ppws_single_product_set_password_expiry * 60 * 60 * 24), COOKIEPATH, COOKIE_DOMAIN, $secure);

            // End the password protection for the whole site
            ppws_whole_site_disable_password_end();
        } else {
            $pwd_err = 'Password not match.';
        }

    } elseif ($ppws_single_category_flag) {
        // Get category password protection settings and expiry
        $ppws_product_Category_set_password_expiry = isset($ppws_single_categories_settings['ppws_single_categories_set_password_expiry_field_textbox'])
            ? $ppws_single_categories_settings['ppws_single_categories_set_password_expiry_field_textbox']
            : 1;

        // Update the category password cookie
        $ppws_single_categories_cookie = ppws_get_cookie("ppws_product_categories_cookie");
        $ppws_single_categories_cookie = json_decode(stripslashes($ppws_single_categories_cookie), true);

        // Loop through each product category
        foreach ($ppws_product_categories_args as $ppws_product_category) {
            // Get the password setting for the category
            $ppws_single_product_category_meta = get_term_meta($ppws_product_category, 'ppws_single_categories_password_setting', true);

            if (isset($ppws_single_product_category_meta) && !empty($ppws_single_product_category_meta)) {
                $ppws_product_category_password = $ppws_single_product_category_meta['ppws_single_categories_password_setting_textbox'];

                // Check if the category password is correct
                if ($ppws_current_pass === ppws_decrypted_password($ppws_product_category_password)) {
                    $ppws_product_category_password_arg = array(
                        'ppws-' . $ppws_product_category => $ppws_product_category_password
                    );

                    if (isset($ppws_single_categories_cookie) && !empty($ppws_single_categories_cookie)) {
                        if (isset($ppws_single_categories_cookie['ppws-' . $ppws_product_category])) {
                            $ppws_single_categories_cookie['ppws-' . $ppws_product_category] = $ppws_product_category_password;
                            $ppws_single_categories_cookie_value = $ppws_single_categories_cookie;
                        } else {
                            $ppws_single_categories_cookie_value = array_merge($ppws_product_category_password_arg, $ppws_single_categories_cookie);
                        }
                    } else {
                        $ppws_single_categories_cookie_value = $ppws_product_category_password_arg;
                    }

                    // Set the updated category password cookie
                    if (isset($ppws_single_categories_cookie_value) && !empty($ppws_single_categories_cookie_value)) {
                        setcookie("ppws_product_categories_cookie", json_encode($ppws_single_categories_cookie_value), time() + ($ppws_product_Category_set_password_expiry * 60 * 60 * 24), COOKIEPATH, COOKIE_DOMAIN, $secure);
                        ppws_whole_site_disable_password_end();
                    } else {
                        $pwd_err = 'Password not match.';
                    }
                }
            }
        }
    }elseif(isset($ppws_whole_site_options['ppws_enable_password_field_checkbox']) == 'on') {
        
        $ppws_main_password = $ppws_whole_site_options['ppws_set_password_field_textbox'];
        $ppws_set_password_expiry = $ppws_whole_site_options['ppws_set_password_expiry_field_textbox'];
        if (ppws_decrypted_password($ppws_main_password) == $ppws_current_pass) {

            setcookie( 'ppws_cookie', $ppws_main_password, time() + ($ppws_set_password_expiry * 60 * 60 * 24 ), COOKIEPATH, COOKIE_DOMAIN, $secure );
            // setcookie( self::COOKIE_PREFIX . COOKIEHASH, $cookie_value, $cookie_expiry, COOKIEPATH, COOKIE_DOMAIN, $secure );
            ppws_whole_site_disable_password_end();
            
        } else {
            $pwd_err =  'Password not match.';
        }
        
    } elseif (isset($ppws_page_options['ppws_page_enable_password_field_checkbox']) == 'on' || isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) == 'on') {
        if(is_page() || is_shop() ){
            if(isset($ppws_page_options['ppws_page_enable_password_field_checkbox'])){
                if($ppws_page_options['ppws_page_enable_password_field_checkbox'] == 'on'){
                    $ppws_main_password = $ppws_page_options['ppws_page_set_password_field_textbox'];
                    $ppws_set_password_expiry = $ppws_page_options['ppws_page_set_password_expiry_field_textbox'];
                    if (ppws_decrypted_password($ppws_main_password) == $ppws_current_pass) {
                        // setcookie('ppws_page_cookie', $ppws_main_password, time() + ($ppws_set_password_expiry * 60 * 60 * 24), "/");
                        setcookie( 'ppws_page_cookie', $ppws_main_password, time() + ($ppws_set_password_expiry * 60 * 60 * 24 ), COOKIEPATH, COOKIE_DOMAIN, $secure );
                        ppws_whole_site_disable_password_end();    
                    } else {
                        $pwd_err = 'password not match';
                    }
                }
            } 
        } else {
            if(is_category() || is_archive() || is_single() ){
                if (isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'])) {
                    if($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'] == 'on'){
                        $ppws_main_password = $ppws_product_categories_options['ppws_product_categories_password'];
                        $ppws_set_password_expiry = $ppws_product_categories_options['ppws_product_categories_password_expiry_day'];
                        if (ppws_decrypted_password($ppws_main_password) == $ppws_current_pass) {
                            // setcookie('ppws_categories_cookie', $ppws_main_password, time() + ($ppws_set_password_expiry * 60 * 60 * 24), "/");
                            setcookie( 'ppws_categories_cookie', $ppws_main_password, time() + ($ppws_set_password_expiry * 60 * 60 * 24 ), COOKIEPATH, COOKIE_DOMAIN, $secure );
                            ppws_whole_site_disable_password_end();    
                        } else {
                            $pwd_err = 'password not match';
                        }
                    }
            
                }
            }
        }

    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="robots" content="noindex, nofollow" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php _e('Password Protected Store for WooCommerce | Geek Code Lab','password-protected-store-for-woocommerce') ?>
    </title>
    <?php
        /* Form settings options */
        $ppws_form_settings_option = get_option('ppws_form_content_option');
        /* Page Background */
        $ppws_page_background = "";
        $ppws_form_background = "";         
        

        $popup_title_color                  =   "#000";
        $popup_title_font_size              =   "28";
        $popup_title_font_alignment         =   "center";

        $popup_content_color                =   "#000";
        $popup_content_size                 =   "16";
        $popup_content_alignment            =   "center";

        $popup_inputbox_color               =   "#fff";
        $popup_inputbox_border_width        =   "2px";
        $popup_inputbox_border_color        =   "#000";
        $popup_placeholder_text_color       =   "#000";
        $popup_inputbox_font_text_size      =   "16";

        $popup_button_color                 =   "#000";
        $popup_button_hover_color           =   "#ccc";
        $popup_button_font_color            =   "#fff";
        $popup_button_font_hover_color      =   "#000";
        $popup_button_font_size             =   "16";
        $popup_button_border                =   "0";
        $popup_button_border_color          =   "transparent";


        $form_background_opacity            =   "0.65";
        $form_background_opacity_color      =   "#fff";
        $ppws_page_background_opacity       =   "0.65";
        $ppws_page_bg_opacity_color         =   "#000";
        $ppws_style_option                  =   get_option( 'ppws_form_desgin_settings' );
        $popup_additional_style             =   '';


        /** Form Title Start */
        if(isset($ppws_style_option['ppws_form_title_color_field_textbox']) && !empty($ppws_style_option['ppws_form_title_color_field_textbox']) ){
            $popup_title_color =   $ppws_style_option['ppws_form_title_color_field_textbox'];
        }
        if(isset($ppws_style_option['ppws_form_title_size_field_textbox']) && !empty($ppws_style_option['ppws_form_title_size_field_textbox']) ){
            $popup_title_font_size = $ppws_style_option['ppws_form_title_size_field_textbox'].'px';
        }
        if(isset($ppws_style_option['ppws_form_title_alignment_field_textbox']) && !empty($ppws_style_option['ppws_form_title_alignment_field_textbox']) ){
            $popup_title_font_alignment = $ppws_style_option['ppws_form_title_alignment_field_textbox'];
        }
        /** Form Title End */

        /* Form  Content Start */
        if(isset($ppws_style_option['ppws_form_content_color_field_textbox']) && !empty($ppws_style_option['ppws_form_content_color_field_textbox']) ){
            $popup_content_color = $ppws_style_option['ppws_form_content_color_field_textbox'];
        }
        if(isset($ppws_style_option['ppws_form_content_size_field_textbox']) && !empty($ppws_style_option['ppws_form_content_size_field_textbox']) ){
            $popup_content_size = $ppws_style_option['ppws_form_content_size_field_textbox'].'px';
        }
        if(isset($ppws_style_option['ppws_form_content_alignment_field_textbox']) && !empty($ppws_style_option['ppws_form_content_alignment_field_textbox']) ){
            $popup_content_alignment = $ppws_style_option['ppws_form_content_alignment_field_textbox'];
        }
        /* Form  Content End */

        /* Form Inputbox Start */
        if(isset($ppws_style_option['ppws_form_inputbox_color_field_textbox']) && !empty($ppws_style_option['ppws_form_inputbox_color_field_textbox']) ){
            $popup_inputbox_color           = $ppws_style_option['ppws_form_inputbox_color_field_textbox'];
        } 
        if(isset($ppws_style_option['ppws_form_inputbox_border_width']) && !empty($ppws_style_option['ppws_form_inputbox_border_width']) ){
            $popup_inputbox_border_width    = $ppws_style_option['ppws_form_inputbox_border_width'].'px';
        }
        if(isset($ppws_style_option['ppws_form_inputbox_border_color']) && !empty($ppws_style_option['ppws_form_inputbox_border_color']) ){
            $popup_inputbox_border_color    = $ppws_style_option['ppws_form_inputbox_border_color'];
        }
        if(isset($ppws_style_option['ppws_form_placeholder_text_color']) && !empty($ppws_style_option['ppws_form_placeholder_text_color']) ){
            $popup_placeholder_text_color   = $ppws_style_option['ppws_form_placeholder_text_color'];
        }
        if(isset($ppws_style_option['ppws_form_inputbox_text_size_field_textbox']) && !empty($ppws_style_option['ppws_form_inputbox_text_size_field_textbox']) ){
            $popup_inputbox_font_text_size  = $ppws_style_option['ppws_form_inputbox_text_size_field_textbox'].'px';
        }
        /* Form Inputbox End */

        /* Button Style Start */
        if(isset($ppws_style_option['ppws_form_button_color_field_textbox']) && !empty($ppws_style_option['ppws_form_button_color_field_textbox']) ){
            $popup_button_color = $ppws_style_option['ppws_form_button_color_field_textbox'];
        }
        if(isset($ppws_style_option['ppws_form_button_hover_color']) && !empty($ppws_style_option['ppws_form_button_hover_color']) ){
            $popup_button_hover_color = $ppws_style_option['ppws_form_button_hover_color'];
        }
        if(isset($ppws_style_option['ppws_form_button_font_color']) && !empty($ppws_style_option['ppws_form_button_font_color']) ){
            $popup_button_font_color = $ppws_style_option['ppws_form_button_font_color'];
        }
        if(isset($ppws_style_option['ppws_form_button_font_hover_color']) && !empty($ppws_style_option['ppws_form_button_font_hover_color']) ){
            $popup_button_font_hover_color = $ppws_style_option['ppws_form_button_font_hover_color'];
        }
        if(isset($ppws_style_option['ppws_submit_btn_font_size']) && !empty($ppws_style_option['ppws_submit_btn_font_size']) ){
            $popup_button_font_size = $ppws_style_option['ppws_submit_btn_font_size'].'px';
        }
        if(isset($ppws_style_option['ppws_form_button_border_field_textbox']) && !empty($ppws_style_option['ppws_form_button_border_field_textbox']) ){
            $popup_button_border = $ppws_style_option['ppws_form_button_border_field_textbox'].'px';
        }
        if(isset($ppws_style_option['ppws_form_button_border_color_field_textbox']) && !empty($ppws_style_option['ppws_form_button_border_color_field_textbox']) ){
            $popup_button_border_color = $ppws_style_option['ppws_form_button_border_color_field_textbox'];
        }
        if(isset($ppws_style_option['ppws_form_additional_style_field_textarea']) && !empty($ppws_style_option['ppws_form_additional_style_field_textarea']) ){
            $popup_additional_style = $ppws_style_option['ppws_form_additional_style_field_textarea'];
        }
        /* Button Style End */

        /* Background Start */
        if(isset($ppws_style_option['ppws_form_page_background_field_radio']) && !empty($ppws_style_option['ppws_form_page_background_field_radio']) && isset($ppws_style_option['ppws_form_page_background_field_image_selecter']) ) {
            if ($ppws_style_option['ppws_form_page_background_field_radio'] == 'image') {
                $ppws_page_background = "background-image: url(" . $ppws_style_option['ppws_form_page_background_field_image_selecter'] . ");";
            } else if ($ppws_style_option['ppws_form_page_background_field_radio'] == 'solid-color' && isset($ppws_style_option['ppws_form_page_background_field_color_selecter'])) {
                $ppws_page_background = "background-color:" . $ppws_style_option['ppws_form_page_background_field_color_selecter'].";";
            }else{
                $ppws_page_background = "background-color:transparent;";
            }
        }

        if(isset($ppws_style_option['ppws_form_background_opacity'])){
            $form_background_opacity = $ppws_style_option['ppws_form_background_opacity'];
        }
        if(isset($ppws_style_option['ppws_form_background_opacity_color']) && !empty($ppws_style_option['ppws_form_background_opacity_color']) ){
            $form_background_opacity_color = $ppws_style_option['ppws_form_background_opacity_color'];
        }

        if(isset($ppws_style_option['ppws_form_background_field_radio']) && !empty($ppws_style_option['ppws_form_background_field_radio']) ){
            $ppws_form_background = "";
            if ($ppws_style_option['ppws_form_background_field_radio'] == 'image' && isset($ppws_style_option['ppws_form_background_field_image_selecter'])) {
                $ppws_form_background = "background-image: url(" . $ppws_style_option['ppws_form_background_field_image_selecter'] . ");";
            } else if ($ppws_style_option['ppws_form_background_field_radio'] == 'solid-color' && isset($ppws_style_option['ppws_form_background_field_color_selecter']) ) {
                $ppws_form_background = "background-color:" . $ppws_style_option['ppws_form_background_field_color_selecter'].";";
            }else{
                $ppws_form_background = "background-color:transparent;";
            }
        }
        if(isset($ppws_style_option['ppws_page_background_opacity'])){
            $ppws_page_background_opacity = $ppws_style_option['ppws_page_background_opacity'];
        }
        if(isset($ppws_style_option['ppws_page_page_background_opacity_color']) && !empty($ppws_style_option['ppws_page_page_background_opacity_color']) ){
            $ppws_page_bg_opacity_color = $ppws_style_option['ppws_page_page_background_opacity_color'];
        }
        /* Background End */
    ?>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}body{margin:0;overflow-x:hidden}.ppws_modal{width:100%;min-height:100vh;height:100%;display:flex;align-items:center;padding:15px;background-size:cover;background-position:center;background-repeat:no-repeat;overflow-x:auto}.ppws_modal_box{display:flex;justify-content:center;flex-direction:column;max-width:600px;width:100%;padding:30px 30px;margin-inline:auto;font-family:sans-serif;box-shadow:10px 10px 30px rgba(0,0,0,.2);position:relative;isolation:isolate;border-radius:10px;z-index:99999999999}.ppws_modal_box_text{position:relative;z-index:2}.ppws_modal_title{text-transform:capitalize;margin-bottom:15px;font-size:28px;position:relative}.ppws_modal_box p{font-size:15px;line-height:1.5}.ppws_modal_box form{display:flex;margin-block:20px 7px}.ppws_modal_box form .ppws_input{flex:1;height:46px;outline:0!important;border-radius:8px 0 0 8px;padding-inline:20px;font-size:16px;padding-top:3px;border-style:solid;border-width:2px;border-right-width:0}.ppws_modal_box form .ppws_form_button{width:100px;border:1px solid transparent;cursor:pointer;background-color:#000;color:#fff;transition:.3s;border-radius:0 8px 8px 0}.ppws_modal_box form .ppws_form_button:hover{background:#ccc;color:#000}.ppws_error_msg{color:red;font-size:14px}.ppws_modal_bottom_text{margin-top:18px}.ppws_modal_box_bg{position:absolute;top:0;left:0;width:100%;height:100%;background-color:#fff;z-index:-1;border-radius:10px;background-size:cover;background-position:center}.ppws_modal_overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:#000;opacity:.65;z-index:999999999}.ppws_form_overlay{position:absolute;top:0;left:0;width:100%;height:100%;background:#fff;opacity:.65;border-radius:10px}.ppws_input::placeholder{color:#000}@media (max-width:400px){.ppws_modal_box{padding:20px;text-align:center}.ppws_modal_box form{flex-direction:column;align-items:center}.ppws_modal_box form .ppws_input{min-height:38px;width:100%;border-radius:8px;margin-bottom:12px;border-right-width:1px}.ppws_modal_box form .ppws_form_button{border-radius:8px;height:40px}}

        .ppws_modal_title {
            color: <?php _e($popup_title_color);
            ?>;
            font-size: <?php _e($popup_title_font_size);
            ?>;
            text-align: <?php _e($popup_title_font_alignment);
            ?>;
        }


        .ppws_modal_text p {
            color: <?php _e($popup_content_color);
            ?>;
            font-size: <?php _e($popup_content_size);
            ?>;
            text-align: <?php _e($popup_content_alignment);
            ?>;
        }

        .ppws_modal_box form .ppws_input {
            background-color: <?php _e($popup_inputbox_color);
            ?>;
            border-width: <?php _e($popup_inputbox_border_width);
            ?>;
            border-color: <?php _e($popup_inputbox_border_color);
            ?>;
            font-size: <?php _e($popup_inputbox_font_text_size);
            ?>;
        }

        .ppws_modal_box form .ppws_input::placeholder {
            color: <?php _e($popup_placeholder_text_color);
            ?>;
            font-size: <?php _e($popup_inputbox_font_text_size);
            ?>;
        }

        .ppws_modal_box form .ppws_form_button {
            background-color: <?php _e($popup_button_color);
            ?>;
            color: <?php _e($popup_button_font_color);
            ?>;
            border-color: <?php _e($popup_button_border_color);
            ?>;
            border-width: <?php _e($popup_button_border);
            ?>;
            font-size: <?php _e($popup_button_font_size);
            ?>;
        }

        .ppws_modal_box form .ppws_form_button:hover {
            background-color: <?php _e($popup_button_hover_color);
            ?>;
            color: <?php _e($popup_button_font_hover_color);
            ?>;
        }

        .ppws_form_overlay {
            opacity: <?php _e($form_background_opacity);
            ?>;
            background: <?php _e($form_background_opacity_color);
            ?>;
        }

        .ppws_modal_overlay {
            opacity: <?php _e($ppws_page_background_opacity);
            ?>;
            background: <?php _e($ppws_page_bg_opacity_color);
            ?>;
        }

        .ppws_modal {
            <?php _e($ppws_page_background);
            ?>
        }

        .ppws_modal_box_bg {
            <?php _e($ppws_form_background);
            ?>
        }

        <?php _e($popup_additional_style); ?>


    </style>
</head>

<body>
    <div class="ppws_modal">
        <div class="ppws_modal_overlay"></div>
        <div class="ppws_modal_box">
            <div class="ppws_form_overlay"></div>
            <div class="ppws_modal_box_bg"></div>
            <div class="ppws_modal_box_text">
                <?php
                if(isset($ppws_form_settings_option['ppws_form_mian_title'])){ ?>
                    <h2 class="ppws_modal_title"><?php _e($ppws_form_settings_option['ppws_form_mian_title']); ?></h2>
                    <?php
                } ?>
                <?php 
                if(isset($ppws_form_settings_option['ppws_form_above_content'])){ ?>
                    <div class="ppws_modal_top_text ppws_modal_text">
                        <?php _e(htmlspecialchars_decode(esc_html__($ppws_form_settings_option['ppws_form_above_content']))); ?>
                    </div>
                    <?php
                } ?>
                <form method="POST">
                    <input type="password" name="ppws_password" class="ppws_input" <?php if(isset($ppws_form_settings_option['ppws_form_pwd_placeholder'])){?> placeholder="<?php esc_attr_e($ppws_form_settings_option['ppws_form_pwd_placeholder']) ?>" <?php } ?>>
                    <input type="submit" name="ppws_submit" value="<?php if(isset($ppws_form_settings_option['ppws_form_submit_btn_text'])){ esc_attr_e($ppws_form_settings_option['ppws_form_submit_btn_text']); }else{ esc_attr_e('Submit'); } ?>" class="ppws_form_button">
                </form>
                <?php 
                if(isset($pwd_err) && !empty($pwd_err)){
                    $incorrect_pass_message = (isset($ppws_form_settings_option['ppws_incorrect_password_message']) && !empty($ppws_form_settings_option['ppws_incorrect_password_message'])) ? $ppws_form_settings_option['ppws_incorrect_password_message']: 'Password mismatch!'; ?>
                    <span class="ppws_error_msg"><?php _e($incorrect_pass_message,'password-protected-store-for-woocommerce') ?></span>
                    <?php
                }
                
                if(isset($ppws_form_settings_option['ppws_form_below_content'])) { ?>
                    <div class="ppws_modal_bottom_text ppws_modal_text">
                        <?php
                            _e(htmlspecialchars_decode(esc_html__($ppws_form_settings_option['ppws_form_below_content'])));   
                        ?>                   
                    </div>
                    <?php
                } ?>
            </div>
        </div>
    </div>
</body>
</html>