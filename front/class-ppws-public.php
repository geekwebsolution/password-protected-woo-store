<?php
/**
 * check status of whole site protection
 */
function is_protected_whole_site() {
    $ppws_whole_site_options = get_option('ppws_general_settings');
    // check Disable For Administrator
    $ppws_password_status_for_admin = isset($ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin']) ? $ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin'] : 'off';

    if (isset($ppws_whole_site_options['ppws_enable_password_field_checkbox']) == 'on') {

        if(current_user_can( 'administrator' ) && $ppws_password_status_for_admin != 'on'){
            return true;
        }  else if(isset($ppws_whole_site_options['enable_user_role']) && $ppws_whole_site_options['ppws_select_user_role_field_radio'] == "non-logged-in-user" && !is_user_logged_in()){
            return true;
        } else {        
            if (isset($ppws_whole_site_options['enable_user_role'])) {

                if ($ppws_whole_site_options['ppws_select_user_role_field_radio'] == "logged-in-user" && is_user_logged_in() && !current_user_can( 'administrator' ) && isset($ppws_whole_site_options['ppws_logged_in_user_field_checkbox'])) { 
                    
                    $current_user = wp_get_current_user();
                    $current_user_role = $current_user->roles;
                    $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                    $logged_in_user = $ppws_whole_site_options['ppws_logged_in_user_field_checkbox'];
                    
                    $selected_user = explode(",", $logged_in_user);

                    if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {      
                        return true;
                    }
                } 
            }else{
                if(!current_user_can( 'administrator' )){
                    return true;
                }
            }
        }
    }
}

/**
 * check status of product categories protection
 */
function is_protected_product_categories() {
    $ppws_product_categories_options = get_option('ppws_product_categories_settings');
    if(isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'])){
        if($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox'] === 'on'){
            if(isset($ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'])) {
                
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
                    if(current_user_can( 'administrator' ) && $ppws_password_status_for_admin != 'on'){
                        return true;
                    } else if(isset($ppws_product_categories_options['enable_user_role']) && !empty($ppws_product_categories_options['enable_user_role'])){
                        if($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "non-logged-in-user" 
                        && !is_user_logged_in()){
                            return true;
                        }
                        if ($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] === "logged-in-user" && is_user_logged_in() && isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                            $current_user = wp_get_current_user();
                            $current_user_role = $current_user->roles;
                            $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                            if(isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])){
                                
                                $selected_user = explode(",", $ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']);
                    
                                if (in_array(ucfirst($final), $selected_user)) {
                                    /* If yes then show Password Page */
                                    // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                    // die;
                                    return true;
                                }
                            }
                        }
                    } else {
                        if(!current_user_can( 'administrator' )){
                            // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                            // die;
                            return true;
                        }
                    }
                }
            }
        }
    }
}

/**
 * check status of protected page protection
 */
function is_protected_page() {
    $ppws_page_options = get_option('ppws_page_settings');
    if(isset($ppws_page_options['ppws_page_enable_password_field_checkbox'])){
        if($ppws_page_options['ppws_page_enable_password_field_checkbox'] === 'on'){
            // $ppws_page_cookie = (ppws_get_cookie('ppws_page_cookie') != '') ? ppws_get_cookie('ppws_page_cookie') : 'ddd';
            // $ppws_page_main_password = $ppws_page_options['ppws_page_set_password_field_textbox'];

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
                if(current_user_can( 'administrator' ) && $ppws_page_status_for_admin != 'on'){
                    // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                    // die;  
                    return true;
                } else if(isset($ppws_page_options['enable_user_role'])){
                    if(isset($ppws_page_options['ppws_page_select_user_role_field_radio'])){
                        if($ppws_page_options['ppws_page_select_user_role_field_radio'] === "non-logged-in-user" && !is_user_logged_in()){
                            // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                            // die; 
                            // ppws_open_popup();
                            return true;
                        }
                        if ($ppws_page_options['ppws_page_select_user_role_field_radio'] === "logged-in-user" && is_user_logged_in() && isset($ppws_page_options['ppws_page_logged_in_user_field_checkbox'])) {
                            $current_user = wp_get_current_user();
                            $current_user_role = $current_user->roles;
                            $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
    
                            /* Create array of selected user */
                            $selected_user = explode(",", $ppws_page_options['ppws_page_logged_in_user_field_checkbox']);
                            /* Checking Current User is in selected user */
                            if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                                /* If yes then show Password Page */
                                // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                                // die;
                                return true;
                            }
                        }
                    }
                    
                } else {
                    if(!current_user_can( 'administrator' )){
                        // include_once(WPPS_PLUGIN_DIR_PATH . 'front/index.php');
                        // die;
                        return true;
                    }
                }
                
            }
        }
    }
}

/**
 * Nocache headers
 */
function ppws_nocache_headers() {
    // Set headers to prevent caching
    nocache_headers();
       
    // Set constants to prevent caching in certain caching plugins
    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
        define( 'DONOTCACHEPAGE', true );
    }
    if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
        define( 'DONOTCACHEOBJECT', true );
    }
    if ( ! defined( 'DONOTCACHEDB' ) ) {
        define( 'DONOTCACHEDB', true );
    }
}

/**
 * No index for Protected Page
 */
function ppws_prevent_indexing() {
    // noindex this page - we add X-Robots-Tag header and set meta robots
    if ( ! headers_sent() ) {
        header( 'X-Robots-Tag: noindex, nofollow' );
    }
}