<?php
/*
Plugin Name: Password Protected Store for WooCommerce
Description: Password Protected Store for WooCommerce is an excellent plugin to set Password Protected Store for WooCommerce. It allows you to set password in your store. Password can be set on whole site, on category, on pages, and on user role.
Author: Geek Code Lab
Version: 1.9
WC tested up to: 8.4.0
Author URI: https://geekcodelab.com/
Text Domain : password-protected-store-for-woocommerce
*/

if (!defined('ABSPATH')) exit;

if (!defined("WPPS_PLUGIN_DIR_PATH"))
    define("WPPS_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

if (!defined("WPPS_PLUGIN_URL"))
    define("WPPS_PLUGIN_URL", plugins_url() . '/' . basename(dirname(__FILE__)));


define("PPWS_BUILD", '1.9');

/* Plugin active/deactive hook */
register_activation_hook(__FILE__, 'ppws_plugin_active_woocommerce_password_protected_store');
function ppws_plugin_active_woocommerce_password_protected_store()
{
    /** Deactivate Pro Plugin if active */
    if (is_plugin_active( 'password-protected-woo-store-pro/password-protected-store-for-woocommerce-pro.php' ) ) {
		deactivate_plugins('password-protected-woo-store-pro/password-protected-store-for-woocommerce-pro.php');
    }

    /** General Setting Start */
    $general_pwd        = "";
    $general_expiry_day = "";
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
    $page_expiry_day = "";
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
    $product_cat_expiry_day = "";
    $product_cat_option     = array();
    $product_cat_protect_archive = "on";
    $product_cat_option_settings        = get_option('ppws_product_categories_settings');

    if(!isset($product_cat_option_settings['ppws_product_categories_password']))                $product_cat_option['ppws_product_categories_password']                 = $product_cat_pwd;
    if(!isset($product_cat_option_settings['ppws_product_categories_password_expiry_day']))     $product_cat_option['ppws_product_categories_password_expiry_day']      = $product_cat_expiry_day;
    if(!isset($product_cat_option_settings['ppws_protect_archive_checkbox_field_checkbox']))    $product_cat_option['ppws_protect_archive_checkbox_field_checkbox']     = $product_cat_protect_archive;

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

if ( ! function_exists( 'ppws_install_woocommerce_admin_notice' ) ) {
	/**
	 * Trigger an admin notice if WooCommerce is not installed.
	 */
	function ppws_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p>
				<?php
				// translators: %s is the plugin name.
				echo esc_html( sprintf( __( '%s is enabled but not effective. It requires WooCommerce in order to work.', 'password-protected-store-for-woocommerce' ), 'Password Protected Store for WooCommerce' ) );
				?>
			</p>
		</div>
		<?php
	}
}


function ppws_woocommerce_constructor() {
    // Check WooCommerce installation
	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'ppws_install_woocommerce_admin_notice' );
		return;
	}

}
add_action( 'plugins_loaded', 'ppws_woocommerce_constructor' );

/* Adding options.php */
require_once(WPPS_PLUGIN_DIR_PATH . 'admin/options.php');
require_once(WPPS_PLUGIN_DIR_PATH . 'admin/functions.php');
require_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-public.php');

add_action( 'admin_enqueue_scripts', 'ppws_add_scripts_enqueue_script');
function ppws_add_scripts_enqueue_script( $hook ) {
    wp_enqueue_style('ppws-select2-css', WPPS_PLUGIN_URL . '/assets/css/select2.min.css', array(), PPWS_BUILD );
    wp_enqueue_style('ppws-admin-style', WPPS_PLUGIN_URL . '/assets/css/admin-style.css', PPWS_BUILD );

    wp_enqueue_script('jquery');

    if($hook == 'woocommerce_page_ppws-option-page') {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        wp_enqueue_editor();
        wp_enqueue_media();
    }

    wp_enqueue_script( 'ppws-select2-js', WPPS_PLUGIN_URL . '/assets/js/select2.min.js', array( 'jquery' ), PPWS_BUILD, true );
    $js = WPPS_PLUGIN_URL . '/assets/js/admin-script.js';
    wp_enqueue_script('ppws-admin-js', $js,  array('jquery','media-upload'), PPWS_BUILD);
    wp_localize_script('ppws-admin-js', 'ppwsObj', [ 'ajaxurl' => admin_url('admin-ajax.php') ] );
}

/* Front side css file */

/* Plugin page plugin setting, active/deactive links  */
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'ppws_plugin_add_settings_link');
function ppws_plugin_add_settings_link($links)
{
    $support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __('Support', 'password-protected-store-for-woocommerce') . '</a>';
    array_unshift($links, $support_link);

    if (class_exists('WooCommerce')) {
        $settings_link = '<a href="admin.php?page=ppws-option-page">' . __('Settings', 'password-protected-store-for-woocommerce') . '</a>';
        array_unshift($links, $settings_link);
    }

    $pro_link = '<a href="https://geekcodelab.com/wordpress-plugins/password-protected-store-for-woocommerce-pro/"  target="_blank" style="color:#46b450;font-weight: 600;">' . __( 'Premium Upgrade', 'password-protected-store-for-woocommerce' ) . '</a>'; 
	array_unshift( $links, $pro_link );
    
    return $links;
}

add_action('init', 'ppws_cookie_checker');
function ppws_cookie_checker(){

    $ppws_cookie = ppws_get_cookie('ppws_cookie');
    if (!isset($ppws_cookie)) {
        update_option('ppws_password_status', 'on');
    }
}


add_action( 'wp', 'ppws_wp' );      // before template redirect
function ppws_wp() {
    global $wp_did_header;

    if ( ! $wp_did_header || 'POST' !== $_SERVER['REQUEST_METHOD'] || ! filter_input( INPUT_POST, 'ppws_submit', FILTER_VALIDATE_INT ) ) {
        return;
    }

    if ( ! ( $password = filter_input( INPUT_POST, 'ppws_password', FILTER_SANITIZE_STRING ) ) ) {
        return;
    }
}

add_action('template_redirect', 'ppws_enable_password_start');
function ppws_enable_password_start() {
    if( is_protected_whole_site() || is_protected_page() || is_protected_product_categories() ) {
        ppws_prevent_indexing();
        ppws_nocache_headers();
    }

    $ppws_whole_site_options = get_option('ppws_general_settings');
    $ppws_page_options = get_option('ppws_page_settings');
    $ppws_product_categories_options = get_option('ppws_product_categories_settings');
        

    do {
        if (is_protected_page() || is_protected_product_categories()) {
            if(is_protected_page()) {
                $ppws_page_cookie = (ppws_get_cookie('ppws_page_cookie') != '') ? ppws_get_cookie('ppws_page_cookie') : 'ddd';
                $ppws_page_main_password = $ppws_page_options['ppws_page_set_password_field_textbox'];
                if(ppws_decrypted_password($ppws_page_cookie) != ppws_decrypted_password($ppws_page_main_password)) {
                    include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
                    die;
                }else{
                    break;
                }
            }   
            
            if(is_protected_product_categories()) {
                $ppws_categories_cookie = ppws_get_cookie('ppws_categories_cookie');
                $ppws_categories_main_password = $ppws_product_categories_options['ppws_product_categories_password'];
                if(ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)) {
                    include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
                    die;
                }else{
                    break;
                }
            }
        }

        if(is_protected_whole_site()) {
            $ppws_cookie = ppws_get_cookie('ppws_cookie');
            $ppws_main_password = $ppws_whole_site_options['ppws_set_password_field_textbox'];
            if(ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password)) {
                include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
                die;
            }else{
                break;
            }
        }
    } while (0);

    // if(is_protected_whole_site()) {
    //     $ppws_cookie = ppws_get_cookie('ppws_cookie');
    //     $ppws_main_password = $ppws_whole_site_options['ppws_set_password_field_textbox'];
    //     if(ppws_decrypted_password($ppws_cookie) != ppws_decrypted_password($ppws_main_password)) {
    //         include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
    //         die;
    //     }
    // }else if (is_protected_page() || is_protected_product_categories()) {
    //     if(is_protected_page()) {
    //         $ppws_page_cookie = (ppws_get_cookie('ppws_page_cookie') != '') ? ppws_get_cookie('ppws_page_cookie') : 'ddd';
    //         $ppws_page_main_password = $ppws_page_options['ppws_page_set_password_field_textbox'];
    //         if(ppws_decrypted_password($ppws_page_cookie) != ppws_decrypted_password($ppws_page_main_password)) {
    //             include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
    //             die;
    //         }
    //     }   
        
    //     if(is_protected_product_categories()) {
    //         $ppws_categories_cookie = ppws_get_cookie('ppws_categories_cookie');
    //         $ppws_categories_main_password = $ppws_product_categories_options['ppws_product_categories_password'];
    //         if(ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)) {
    //             include_once(WPPS_PLUGIN_DIR_PATH . 'front/class-ppws-protected-form.php');
    //             die;
    //         }
    //     }
    // }
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
 * Hide / Exclude products from a particular category on the shop page
 */
add_action( 'woocommerce_product_query', 'ppsw_custom_query_exclude_taxonomy' );

function ppsw_custom_query_exclude_taxonomy($q) {
    if(is_admin())  return;

    ppws_nocache_headers();

    $hide_protected_cat_products = false;

    $ppws_product_categories_options = get_option('ppws_product_categories_settings');    

    if(isset($ppws_product_categories_options) && !empty($ppws_product_categories_options)) {

        $dfa_product_categories_protect_enable = (isset($ppws_product_categories_options["ppws_product_categories_enable_password_field_checkbox_for_admin"]) && $ppws_product_categories_options["ppws_product_categories_enable_password_field_checkbox_for_admin"] == "on") ? true : false;

        $hide_general_product_from_loop = (isset($ppws_product_categories_options['ppws_hide_products_checkbox_field_checkbox']) && !empty($ppws_product_categories_options['ppws_hide_products_checkbox_field_checkbox'])) ? $ppws_product_categories_options['ppws_hide_products_checkbox_field_checkbox']: '';

        if($hide_general_product_from_loop == 'on') {
            $enable_categories_password = (isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'])) ? $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']: '';
            if($enable_categories_password == 'on') {

                if (isset($ppws_product_categories_options['enable_user_role']) && !empty($ppws_product_categories_options['enable_user_role'])) {
                    if (isset($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio']) && "non-logged-in-user" === $ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] 
                    && !is_user_logged_in()) {
                        $hide_protected_cat_products = true;
                    } elseif (isset($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio']) && "logged-in-user" === $ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] && is_user_logged_in()) {

                        if (isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                            $current_user = wp_get_current_user();
                            $current_user_role = $current_user->roles;
                            $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                            if (isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                                $selected_user = explode(",", $ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']);
                            
                                if (current_user_can('administrator') && $dfa_product_categories_protect_enable) {
                                    array_push($selected_user, 'Administrator');
                                }
                                if (in_array(ucfirst($final), $selected_user)) {
                                    $hide_protected_cat_products = true;
                                }
                            }
                        } else {
                            if (current_user_can('administrator') && $dfa_product_categories_protect_enable) {
                                $hide_protected_cat_products = true;
                            }
                        }

                    }
                }else{
                    if (current_user_can('administrator')) {
                        if(!$dfa_product_categories_protect_enable) {
                            $hide_protected_cat_products = true;
                        }
                    }else{
                        $hide_protected_cat_products = true;
                    }
                }

            }
        }
    }

    if($hide_protected_cat_products) {
        // get categories_setting cookie
        $ppws_categories_cookie = ppws_get_cookie('ppws_categories_cookie');
        $ppws_categories_main_password = $ppws_product_categories_options['ppws_product_categories_password'];

        if(ppws_decrypted_password($ppws_categories_cookie) != ppws_decrypted_password($ppws_categories_main_password)) {
            $protected_categories = (isset($ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'])) ? $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'] : array();
            if(isset($protected_categories) && !empty($protected_categories)) {
                $tax_query = (array) $q->get( 'tax_query' );

                $tax_query[] = array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => explode( ',', $protected_categories ), // Don't display products in the clothing category on the shop page.
                    'operator' => 'NOT IN',
                    'include_children' => false
                );

                $q->set( 'tax_query', $tax_query );
            }
        }
    }
}

/**
 * Added HPOS support for woocommerce
 */
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

/**
 * Select post types to exclude data
 */
add_action('wp_ajax_ppws_search_product_categories','ppws_search_product_categories');
add_action( 'wp_ajax_nopriv_ppws_search_product_categories', 'ppws_search_product_categories' );
function ppws_search_product_categories() {
    $all_categories = $result = [];
    $search = $_POST['search'];

    $fun_args = array(
        'taxonomy' => 'product_cat',
        'search' => $search,
        'orderby' => 'name',
        'show_count' => 0,
        'pad_counts' => 0,
        'hierarchical' => 1,
        'hide_empty' => 0
    );
    $all_categories = get_categories($fun_args);

    if(isset($all_categories) && !empty($all_categories)) {
        foreach ($all_categories as $cat) {
            $category_id = $cat->term_id;
            $cat_name = $cat->name;
            $result[] = array(
                'id' => $category_id,
                'title' => $cat_name." (#".$category_id.")"
            );
        }
    }

    echo json_encode($result);
	die;
}

/**
 * Select post types to exclude data
 */
add_action('wp_ajax_ppws_search_pages','ppws_search_pages');
add_action( 'wp_ajax_nopriv_ppws_search_pages', 'ppws_search_pages' );
function ppws_search_pages() {
    $all_pages = $result = [];
    $search = $_POST['search'];

    $all_pages = get_posts(array(
		's'					=> $search,
		'post_type'			=> 'page',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1
	));

    if(isset($all_pages) && !empty($all_pages)) {
        foreach ($all_pages as $post) {
            $result[] = array(
				'id' => $post->ID,
				'title' => $post->post_title." (#".$post->ID.")"
			);
        }
    }

    echo json_encode($result);
	die;
}