<?php
/*
Plugin Name: Password Protected Store for WooCommerce
Description: Password Protected Store for WooCommerce is an excellent plugin to set Password Protected Store for WooCommerce. It allows you to set password in yore store. Password can be set on whole site, on category, on pages, and on user role.
Author: Geek Code Lab
Version: 1.4
WC tested up to: 7.7.0
Author URI: https://geekcodelab.com/
Text Domain : password-protected-store-for-woocommerce
*/

if (!defined('ABSPATH')) exit;

if (!defined("WPPS_PLUGIN_DIR_PATH"))
    define("WPPS_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

if (!defined("WPPS_PLUGIN_URL"))
    define("WPPS_PLUGIN_URL", plugins_url() . '/' . basename(dirname(__FILE__)));

define("ppws_BUILD", '1.4');
$plugin = plugin_basename(__FILE__); //plugin_action_links_password-protected-store-for-woocommerce/password-protected-store-for-woocommerce.php
/* Plugin load hook */
add_action('plugins_loaded', 'ppws_plugin_load_woocommerce_password_protected_store');
function ppws_plugin_load_woocommerce_password_protected_store() {
    if (!class_exists('WooCommerce')) {
        add_action(
            'admin_notices',
            function() {
                echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Password Protected Store for WooCommerce to be installed and active. You can download %s here.', 'password-protected-store-for-woocommerce' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
            }
        );
        add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'ppws_plugin_add_pre_settings_link');
        return;
    } else {
        add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'ppws_plugin_add_settings_link');
    }
}
/* Plugin active/deactive hook */
register_activation_hook(__FILE__, 'ppws_plugin_active_woocommerce_password_protected_store');
function ppws_plugin_active_woocommerce_password_protected_store()
{
    /*$error = 'required <b>woocommerce</b> plugin.';
    if (!class_exists('WooCommerce')) {
        die('Plugin Not Activated: ' . $error);
    }*/


    /** General Setting Start */
    $general_pwd        = "";
    $general_expiry_day = "1";
    $general_option     = array();
    $general_option_settings        = get_option('ppws_general_settings');

    if(!isset($general_option_settings['ppws_set_password_field_textbox']))             $general_option['ppws_set_password_field_textbox']          = $general_pwd;
    if(!isset($general_option_settings['ppws_set_password_expiry_field_textbox']))      $general_option['ppws_set_password_expiry_field_textbox']   = $general_expiry_day;

    if(isset($general_option) && !empty($general_option)){
        if(count($general_option) > 0)	update_option('ppws_general_settings', $general_option);
    }
    /** General Setting End */


    /** Page Setting Start */
    $page_pwd        = "";
    $page_expiry_day = "1";
    $page_option     = array();
    $page_option_settings        = get_option('ppws_page_settings');

    if(!isset($page_option_settings['ppws_page_set_password_field_textbox']))           $page_option['ppws_page_set_password_field_textbox']            = $page_pwd;
    if(!isset($page_option_settings['ppws_page_set_password_expiry_field_textbox']))    $page_option['ppws_page_set_password_expiry_field_textbox']     = $page_expiry_day;

    if(isset($page_option) && !empty($page_option)){
        if(count($page_option) > 0)	update_option('ppws_page_settings', $page_option);
    }
    /** Page Setting End */

    /** Product Categories Setting Start */
    $product_cat_pwd        = "";
    $product_cat_expiry_day = "1";
    $product_cat_option     = array();
    $product_cat_option_settings        = get_option('ppws_product_categories_settings');

    if(!isset($product_cat_option_settings['ppws_product_categories_password']))                $product_cat_option['ppws_product_categories_password']                 = $product_cat_pwd;
    if(!isset($product_cat_option_settings['ppws_product_categories_password_expiry_day']))     $product_cat_option['ppws_product_categories_password_expiry_day']      = $product_cat_expiry_day;

    if(isset($product_cat_option) && !empty($product_cat_option)){
        if(count($product_cat_option) > 0)	update_option('ppws_product_categories_settings', $product_cat_option);
    }
    /** Product Categories Setting End */    


    /** Content Setting Start */

    $popup_title                = "Password Protected Store for WooCommerce";
    $popup_above_content        = "You must login with the password.";
    $popup_below_content        = "if you have any questions please contact us.";
    $submit_btn_text            = "submit";
    $pwd_input_placeholder      = "Enter Password";

    $ppws_form_label_option     = array();
    $form_label_settings        = get_option('ppws_form_content_option');

    if(!isset($form_label_settings['ppws_form_mian_title']))            $ppws_form_label_option['ppws_form_mian_title']			    = $popup_title;
    if(!isset($form_label_settings['ppws_form_above_content']))   	    $ppws_form_label_option['ppws_form_above_content']	        = $popup_above_content;
    if(!isset($form_label_settings['ppws_form_below_content']))         $ppws_form_label_option['ppws_form_below_content']	        = $popup_below_content;
    if(!isset($form_label_settings['ppws_form_submit_btn_text']))       $ppws_form_label_option['ppws_form_submit_btn_text']	    = $submit_btn_text;
    if(!isset($form_label_settings['ppws_form_pwd_placeholder']))       $ppws_form_label_option['ppws_form_pwd_placeholder']	    = $pwd_input_placeholder;

    if(isset($ppws_form_label_option) && !empty($ppws_form_label_option)){
        if(count($ppws_form_label_option) > 0)	update_option('ppws_form_content_option', $ppws_form_label_option);
    }

    /** Content Setting End */


    /** Form Style Start */

    $popup_title_color              = "#000";
    $popup_title_font_size          = "28";
    $popup_title_font_alignment     = "center";

    $popup_content_color            = "#000";
    $popup_content_size             = "16";
    $popup_content_alignment        = "center";

    $popup_inputbox_color           = "#fff";
    $popup_inputbox_border_width    = "2";
    $popup_inputbox_border_color    = "#000";
    $popup_placeholder_text_color   = "#000";
    $popup_inputbox_font_text_size  = "16";

    $popup_button_color             = "#000";
    $popup_button_hover_color       = "#ccc";
    $popup_button_font_color        = "#fff";
    $popup_button_font_hover_color  = "#000";
    $popup_button_font_size         = "16";
    $popup_button_border            = "0";
    $popup_button_border_color      = "";

    $form_background_opacity        = "0.65";
    $form_background_opacity_color  = "#fff";
    $ppws_page_background_opacity   = "0.65";
    $ppws_page_bg_opacity_color     = "#000";

    
    $page_background_radio          = 'none';
    $form_background_radio          = 'none';

    
    $ppws_form_option               = array();
    $form_settings_option           = get_option('ppws_form_desgin_settings');


    /** Form Title Start */
    if(!isset($form_settings_option['ppws_form_title_color_field_textbox']))   	    $ppws_form_option['ppws_form_title_color_field_textbox']			= $popup_title_color;
    if(!isset($form_settings_option['ppws_form_title_size_field_textbox']))   	    $ppws_form_option['ppws_form_title_size_field_textbox']			    = $popup_title_font_size;
    if(!isset($form_settings_option['ppws_form_title_alignment_field_textbox']))    $ppws_form_option['ppws_form_title_alignment_field_textbox']	    = $popup_title_font_alignment;
    /** Form Title End */


    /** Form Content Start */
    if(!isset($form_settings_option['ppws_form_content_color_field_textbox']))   	$ppws_form_option['ppws_form_content_color_field_textbox']		    = $popup_content_color;
    if(!isset($form_settings_option['ppws_form_content_size_field_textbox']))   	$ppws_form_option['ppws_form_content_size_field_textbox']			= $popup_content_size;
    if(!isset($form_settings_option['ppws_form_content_alignment_field_textbox']))  $ppws_form_option['ppws_form_content_alignment_field_textbox']	    = $popup_content_alignment;
    /** Form Content End */

    /** Form Inputbox Start */
    if(!isset($form_settings_option['ppws_form_inputbox_color_field_textbox']))     $ppws_form_option['ppws_form_inputbox_color_field_textbox']			= $popup_inputbox_color;
    if(!isset($form_settings_option['ppws_form_inputbox_border_width']))            $ppws_form_option['ppws_form_inputbox_border_width']			    = $popup_inputbox_border_width;
    if(!isset($form_settings_option['ppws_form_inputbox_border_color']))            $ppws_form_option['ppws_form_inputbox_border_color']	            = $popup_inputbox_border_color;
    if(!isset($form_settings_option['ppws_form_placeholder_text_color']))           $ppws_form_option['ppws_form_placeholder_text_color']	            = $popup_placeholder_text_color;
    if(!isset($form_settings_option['ppws_form_inputbox_text_size_field_textbox'])) $ppws_form_option['ppws_form_inputbox_text_size_field_textbox']		= $popup_inputbox_font_text_size; 
    /** Form Inputbox End */

    /** Button Style Start */
    if(!isset($form_settings_option['ppws_form_button_color_field_textbox']))   	$ppws_form_option['ppws_form_button_color_field_textbox']			= $popup_button_color;
    if(!isset($form_settings_option['ppws_form_button_hover_color']))   	        $ppws_form_option['ppws_form_button_hover_color']			        = $popup_button_hover_color;
    if(!isset($form_settings_option['ppws_form_button_font_color']))                $ppws_form_option['ppws_form_button_font_color']	                = $popup_button_font_color;
    if(!isset($form_settings_option['ppws_form_button_font_hover_color']))          $ppws_form_option['ppws_form_button_font_hover_color']              = $popup_button_font_hover_color;
    if(!isset($form_settings_option['ppws_submit_btn_font_size']))                  $ppws_form_option['ppws_submit_btn_font_size']                      = $popup_button_font_size;
    if(!isset($form_settings_option['ppws_form_button_border_field_textbox']))      $ppws_form_option['ppws_form_button_border_field_textbox']          = $popup_button_border;
    /** Button Style End */

    /** Background Start */
    if(!isset($form_settings_option['ppws_form_page_background_field_radio']))   	$ppws_form_option['ppws_form_page_background_field_radio']			= $page_background_radio;
    if(!isset($form_settings_option['ppws_page_background_opacity']))   	        $ppws_form_option['ppws_page_background_opacity']			        = $ppws_page_background_opacity;
    if(!isset($form_settings_option['ppws_page_page_background_opacity_color']))   	$ppws_form_option['ppws_page_page_background_opacity_color']		= $ppws_page_bg_opacity_color;
    if(!isset($form_settings_option['ppws_form_background_field_radio']))   	    $ppws_form_option['ppws_form_background_field_radio']			    = $form_background_radio;
    if(!isset($form_settings_option['ppws_form_background_opacity']))   	        $ppws_form_option['ppws_form_background_opacity']			        = $form_background_opacity;
    if(!isset($form_settings_option['ppws_form_background_opacity_color']))   	    $ppws_form_option['ppws_form_background_opacity_color']			    = $form_background_opacity_color;
    /** Background End */

    if(isset($ppws_form_option) && !empty($ppws_form_option)){
        if(count($ppws_form_option) > 0)	update_option('ppws_form_desgin_settings', $ppws_form_option);
    }

   /** Form Style End */


}

/* Adding options.php */
require_once(WPPS_PLUGIN_DIR_PATH . 'admin/options.php');
require_once(WPPS_PLUGIN_DIR_PATH . 'admin/functions.php');

/* Add admin style and script file only to admin side */
add_action('admin_print_styles', 'ppws_admin_style');
function ppws_admin_style()
{
    if (is_admin()) {
        $js = WPPS_PLUGIN_URL . '/assets/js/admin-script.js';
        wp_enqueue_style('ppws_admin_style', WPPS_PLUGIN_URL . '/assets/css/admin-style.css',ppws_BUILD);
        wp_enqueue_style('wp-color-picker');

        
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('jquery');
        wp_enqueue_editor();
        wp_enqueue_media();
        wp_enqueue_script('ppws_admin_js', $js,  array('jquery','media-upload'), ppws_BUILD);
    }
}

/* Front side css file */

/* Plugin page plugin setting, active/deactive links  */
function ppws_plugin_add_pre_settings_link($links)
{
    $support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __('Support') . '</a>';
    array_unshift($links, $support_link);
    return $links;
}

/* Plugin page plugin setting, active/deactive links  */
function ppws_plugin_add_settings_link($links)
{
    $support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __('Support') . '</a>';
    array_unshift($links, $support_link);

    $settings_link = '<a href="admin.php?page=ppws-option-page">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);

    return $links;
}

//add_filter("plugin_action_links_$plugin", 'ppws_plugin_add_settings_link');

/*
- How to check if a user (not current user) is logged in?
- https://wordpress.stackexchange.com/questions/34429/how-to-check-if-a-user-not-current-user-is-logged-in
*/


// add_action('wp_enqueue_scripts', 'ppws_include_front_script_demo');
// function ppws_include_front_script_demo(){
//     wp_enqueue_style('ppws_front_style', WPPS_PLUGIN_URL . '/assets/css/front-style.css', array(), '0.1.0' );
// }

// add_action('wp_head', 'ppws_include_front_script',99);
// function ppws_include_front_script()
// {

//     // wp_enqueue_style('ppws_front_style', WPPS_PLUGIN_URL . '/assets/css/front-style.css', array(), '0.1.0',99 );
//     die;
// }
// // add_action( 'wp_enqueue_scripts', array(&$this, 'theme_styles'), 99 );

add_action('init', 'ppws_cookie_checker');
function ppws_cookie_checker(){

    $ppws_cookie = ppws_get_cookie('ppws_cookie');
    if (!isset($ppws_cookie)) {
        update_option('ppws_password_status', 'on');
    }
}

add_action('template_redirect', 'ppws_enable_password_start');
function ppws_enable_password_start(){
    $ppws_whole_site_options = get_option('ppws_general_settings');
    $ppws_page_options = get_option('ppws_page_settings');
    $ppws_product_categories_options = get_option('ppws_product_categories_settings');
    if (isset($ppws_whole_site_options['ppws_enable_password_field_checkbox']) == 'on') {
        
        // get general_setting cookie
        $ppws_cookie = ppws_get_cookie('ppws_cookie');
        // check Disable For Administrator
        $ppws_password_status_for_admin = isset($ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin']) ? $ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin'] : 'off';
        // get store password into the database
        $ppws_main_password = $ppws_whole_site_options['ppws_set_password_field_textbox'];

        if(current_user_can( 'administrator' ) && $ppws_password_status_for_admin != 'on' && ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password) ){
            include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
            die;  
        }  else if(isset($ppws_whole_site_options['enable_user_role']) && $ppws_whole_site_options['ppws_select_user_role_field_radio'] == "non-logged-in-user" && !is_user_logged_in() && ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password)){
            include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
            die;  
        } else {
            
            if (isset($ppws_whole_site_options['enable_user_role'])) {

                if ($ppws_whole_site_options['ppws_select_user_role_field_radio'] == "logged-in-user" && is_user_logged_in() && !current_user_can( 'administrator' ) && isset($ppws_whole_site_options['ppws_logged_in_user_field_checkbox']) && ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password)) {
                     
                    
                    $current_user = wp_get_current_user();
                    $current_user_role = $current_user->roles;
                    $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                    $logged_in_user = $ppws_whole_site_options['ppws_logged_in_user_field_checkbox'];
                    
                    $selected_user = explode(",", $logged_in_user);

                    if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
              
                        include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                        die;         
                    }
                } 
            }else{
                if(!current_user_can( 'administrator' ) && ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password)){
                    include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                    die;
                }
            }
        }
        
    } else if (isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) || isset($ppws_page_options['ppws_page_enable_password_field_checkbox'])) {
        if(isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'])){
            if($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'] === 'on'){
                if(isset($ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'])) {
                    // get categories_setting cookie
                    $ppws_categories_cookie = ppws_get_cookie('ppws_categories_cookie');
                    $ppws_categories_main_password = $ppws_product_categories_options['ppws_product_categories_password'];
                    // check Disable For Administrator
                    $ppws_password_status_for_admin = isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin']) ? $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin'] : 'off';
                    $ppws_password_status = get_option('ppws_password_status');
                    global $wp_query;
                    $all_selected_category = explode(",", $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox']);
                    $flag_signle_product = 0;
                    if (is_product()) {
                        $product    = wc_get_product();
                        $id         = $product->get_id();
                        $all_cat_id = array();
                        if(isset($all_selected_category) && !empty($all_selected_category)){
                            foreach ($all_selected_category as $key => $cat_id) {
                                array_push($all_cat_id,$cat_id);
                                $args_query = array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'child_of' => $cat_id );
                                $sub_categories =  get_terms( $args_query );
                                if(isset($sub_categories) && !empty($sub_categories)){
                                    foreach ($sub_categories as $key => $sub_cat) {
                                        array_push($all_cat_id,$sub_cat->term_id);
                                    }
                                }
                            }
                        }
                        if (has_term($all_cat_id, 'product_cat', $id)) {
                            $flag_signle_product = 1;
                        }
                    }
                    if( is_product_category() ) {
                        $woo_category = $wp_query->get_queried_object()->term_id;
                        if (is_product_category()) {
                            $all_selected_category = explode(",", $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox']);
                            if (in_array($woo_category, $all_selected_category)) {
                                $flag_signle_product = 1;
                            } 
                        }
                    }
                    if($flag_signle_product == 1){
                        if(current_user_can( 'administrator' ) && $ppws_password_status_for_admin != 'on' && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                            include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                            die; 
                        } else if(isset($ppws_product_categories_options['enable_user_role']) && !empty($ppws_product_categories_options['enable_user_role'])){
                            if($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "non-logged-in-user" 
                            && !is_user_logged_in() && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                                include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                die;  
                            }
                            if ($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "logged-in-user" && is_user_logged_in() && isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                                $current_user = wp_get_current_user();
                                $current_user_role = $current_user->roles;
                                $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                                if(isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])){
                                    
                                    $selected_user = explode(",", $ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']);
                                    //if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                                    if (in_array(ucfirst($final), $selected_user) && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)) {
                                        /* If yes then show Password Page */
                                        include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                        die;
                                    }
                                }
                            }
                        } else {
                            if(!current_user_can( 'administrator' ) && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                                include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                die;
                            }
                        }
                    }
                }
            }
        }
        
        if(isset($ppws_page_options['ppws_page_enable_password_field_checkbox'])){
            if($ppws_page_options['ppws_page_enable_password_field_checkbox'] === 'on'){

            
            $ppws_page_cookie = (ppws_get_cookie('ppws_page_cookie') != '') ? ppws_get_cookie('ppws_page_cookie') : 'ddd';
            $ppws_page_main_password = $ppws_page_options['ppws_page_set_password_field_textbox'];

            $ppws_page_status_for_admin = isset($ppws_page_options['ppws_page_enable_password_field_checkbox_for_admin']) ? $ppws_page_options['ppws_page_enable_password_field_checkbox_for_admin'] : 'off';
            
            if ( is_home() && ! in_the_loop() ) {
                $ID = get_option('page_for_posts');
            }elseif(is_post_type_archive('product')){
                $ID = get_option( 'woocommerce_shop_page_id' ); 
            }else { 
                $ID = get_the_ID();
            }
            /* Get Current User */
            $page_name = get_the_title();   
     
            $selected_pages = array();
            if(isset( $ppws_page_options['ppws_page_list_of_page_field_checkbox'])){
                $selected_pages = explode(",", $ppws_page_options['ppws_page_list_of_page_field_checkbox']);
            }
            
            
            if (in_array(ucfirst($ID), $selected_pages)) {
                if(current_user_can( 'administrator' ) && $ppws_page_status_for_admin != 'on' && ppws_decrypted_password($ppws_page_cookie) != ppws_decrypted_password($ppws_page_main_password)){
                    include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                    die;  
                } else if(isset($ppws_page_options['enable_user_role'])){
                    if(isset($ppws_page_options['ppws_page_select_user_role_field_radio'])){
                        if($ppws_page_options['ppws_page_select_user_role_field_radio'] === "non-logged-in-user" && !is_user_logged_in() && ppws_decrypted_password($ppws_page_cookie) !== ppws_decrypted_password($ppws_page_main_password)){
                            // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                            // die; 
                            ppws_open_popup();
                        }
                        if ($ppws_page_options['ppws_page_select_user_role_field_radio'] === "logged-in-user" && is_user_logged_in() && isset($ppws_page_options['ppws_page_logged_in_user_field_checkbox']) && ppws_decrypted_password($ppws_page_cookie) !== ppws_decrypted_password($ppws_page_main_password)) {
                            $current_user = wp_get_current_user();
                            $current_user_role = $current_user->roles;
                            $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
    
                            /* Create array of selected user */
                            $selected_user = explode(",", $ppws_page_options['ppws_page_logged_in_user_field_checkbox']);
                            /* Checking Current User is in selected user */
                            if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                                /* If yes then show Password Page */
                                include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                die;
                            }
                        }
                    }
                    
                } else {
                    if(!current_user_can( 'administrator' ) && ppws_decrypted_password($ppws_page_cookie) != ppws_decrypted_password($ppws_page_main_password)){
                        include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                        die;
                    }
                }
                
            }
            }
        }
    }
}

function ppws_open_popup(){
    include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
    die; 
}
/* End Enable Password */
add_action('end_whole_site_pass', 'ppws_whole_site_disable_password_end');
function ppws_whole_site_disable_password_end()
{
    update_option('ppws_password_status', 'off');
    $redirect_url = home_url();

    global $wp;
    $current_slug = home_url( add_query_arg( array(), $wp->request ) );
?>
    <script>
        window.location = <?php echo "'".esc_js($current_slug). "'"; ?>;
    </script>
<?php
    exit;
}

/**
 * Exclude products from a particular category on the shop page
 */
function custom_query_exclude_taxonomy( $q ) {

    $ppws_product_categories_options = get_option('ppws_product_categories_settings');

    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'id',
           'terms' => explode( ',', $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'] ), // Don't display products in the clothing category on the shop page.
           'operator' => 'NOT IN'
    );

    $q->set( 'tax_query', $tax_query );

}

add_action('init', 'ppws_on_init');

/**
 * Hide category products from wc query/loop/shop
 */
function ppws_on_init() {

    $ppws_product_categories_options = get_option('ppws_product_categories_settings');

    if(isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) && $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'] === 'on'){
        if(isset($ppws_product_categories_options['ppws_hide_products_checkbox_field_checkbox']) && $ppws_product_categories_options['ppws_hide_products_checkbox_field_checkbox'] === 'on'){
                // get categories_setting cookie
                $ppws_categories_cookie = ppws_get_cookie('ppws_categories_cookie');
                $ppws_categories_main_password = $ppws_product_categories_options['ppws_product_categories_password'];
                // check Disable For Administrator
                $ppws_password_status_for_admin = isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin']) ? $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin'] : 'off';

                if(current_user_can( 'administrator' ) && $ppws_password_status_for_admin != 'on' && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                    add_action( 'woocommerce_product_query', 'custom_query_exclude_taxonomy' );  
                } else if(isset($ppws_product_categories_options['enable_user_role']) && !empty($ppws_product_categories_options['enable_user_role'])){
                    if($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "non-logged-in-user" 
                            && !is_user_logged_in() && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                                add_action( 'woocommerce_product_query', 'custom_query_exclude_taxonomy' );  
                            }

                            if ($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "logged-in-user" && is_user_logged_in() && isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                                $current_user = wp_get_current_user();
                                $current_user_role = $current_user->roles;
                                $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                                if(isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])){
                                    
                                    $selected_user = explode(",", $ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']);
                                    if (in_array(ucfirst($final), $selected_user) && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)) {
                                        add_action( 'woocommerce_product_query', 'custom_query_exclude_taxonomy' );  
                                    }
                                }
                            }
                } else {
                    if(!current_user_can( 'administrator' ) && ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)){
                        add_action( 'woocommerce_product_query', 'custom_query_exclude_taxonomy' );  
                    }
                }
        }
    }
}