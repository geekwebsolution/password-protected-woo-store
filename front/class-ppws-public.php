<?php

/**
 * Checks if the whole site is protected based on password settings and user roles.
 * @return bool True if the whole site is protected, false otherwise.
 */
function is_protected_whole_site() {
    // Get whole site options from settings.
    $ppws_whole_site_options = get_option('ppws_general_settings');

    // Check if the site options exist and are not empty.
    if (isset($ppws_whole_site_options) && !empty($ppws_whole_site_options)) {

        // Check if password protection is enabled for the whole site.
        if (isset($ppws_whole_site_options['ppws_enable_password_field_checkbox']) && 'on' === $ppws_whole_site_options['ppws_enable_password_field_checkbox']) {
            
            // Get the status of password protection for admin users.
            $ppws_password_status_for_admin = isset($ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin']) ? $ppws_whole_site_options['ppws_enable_password_field_checkbox_for_admin'] : 'off';

            // Check if user roles are enabled.
            if (isset($ppws_whole_site_options['enable_user_role'])) {

                // Check if the site is accessible for non-logged-in users.
                if (isset($ppws_whole_site_options['ppws_select_user_role_field_radio']) && "non-logged-in-user" === $ppws_whole_site_options['ppws_select_user_role_field_radio'] && !is_user_logged_in()) {
                    return true;
                } else {
                    // Check if the site is accessible for logged-in users based on their roles.
                    if (isset($ppws_whole_site_options['ppws_select_user_role_field_radio']) && "logged-in-user" === $ppws_whole_site_options['ppws_select_user_role_field_radio'] && is_user_logged_in()) {

                        if(isset($ppws_whole_site_options['ppws_logged_in_user_field_checkbox'])){
                            $current_user = wp_get_current_user();
                            $current_user_role = $current_user->roles;
                            $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
        
                            $logged_in_user = $ppws_whole_site_options['ppws_logged_in_user_field_checkbox'];
                            $selected_user = explode(",", $logged_in_user);
    
                            // Add "Administrator" role to the selected user roles if admin bypass is disabled.
                            if ('on' !== $ppws_password_status_for_admin && current_user_can('administrator')) {
                                array_push($selected_user, 'Administrator');
                            }
    
                            // Check if the current user role is allowed to access the site or the user is not logged in.
                            if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                                return true;
                            }
                        }else{
                            // Add "Administrator" role to the selected user roles if admin bypass is disabled.
                            if ('on' !== $ppws_password_status_for_admin && current_user_can('administrator')) {
                                return true;
                            }
                            
                        }

                    }
                }
            } else {
                // Check if the current user is an administrator and admin bypass is disabled.
                if (current_user_can('administrator')) {
                    if ('on' !== $ppws_password_status_for_admin) {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }
    }

    // Return false if password protection is not enabled or no options are found.
    return false;
}

/**
 * Check if product categories are protected based on password settings and user roles.
 * @return bool True if the product categories are protected, false otherwise.
 */
function is_protected_product_categories() {
    // Get product categories options from settings.
    $ppws_product_categories_options = get_option('ppws_product_categories_settings');
    
    // Check if the product categories options exist and are not empty.
    if (isset($ppws_product_categories_options) && !empty($ppws_product_categories_options)) {

        // Check if password protection is enabled for product categories.
        if (isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) && 'on' === $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox']) {

            // Check if password protection is enabled for all categories.
            if (isset($ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'])) {
                
                // Get the status of password protection for admin users.
                $ppws_password_status_for_admin = isset($ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin']) ? $ppws_product_categories_options['ppws_product_categories_enable_password_field_checkbox_for_admin'] : 'off';
                
                // Get the global password status.
                $ppws_password_status = get_option('ppws_password_status');
                
                global $wp_query;
                $all_selected_category = $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox'];
                $all_selected_category = explode(",", $ppws_product_categories_options['ppws_product_categories_all_categories_field_checkbox']);
                
                $flag_single_product = 0;
                if (is_product()) {
                    $product = wc_get_product();
                    $id = $product->get_id();
                    $all_cat_id = array();
                    if (isset($all_selected_category) && !empty($all_selected_category)) {
                        foreach ($all_selected_category as $key => $cat_id) {
                            array_push($all_cat_id, $cat_id);
                            $args_query = array('taxonomy' => 'product_cat', 'hide_empty' => false, 'child_of' => $cat_id);
                            $sub_categories = get_terms($args_query);
                            if (isset($sub_categories) && !empty($sub_categories)) {
                                foreach ($sub_categories as $key => $sub_cat) {
                                    array_push($all_cat_id, $sub_cat->term_id);
                                }
                            }
                        }
                    }
                    if (has_term($all_cat_id, 'product_cat', $id)) {
                        $flag_single_product = 1;
                    }
                }
                if (is_product_category()) {
                    $woo_category = $wp_query->get_queried_object()->term_id;
                    if (in_array($woo_category, $all_selected_category)) {
                        $flag_single_product = 1;
                    } 
                }

                if ($flag_single_product == 1) {
                    if (isset($ppws_product_categories_options['enable_user_role']) && !empty($ppws_product_categories_options['enable_user_role'])) {
                        if (isset($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio']) && "non-logged-in-user" === $ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] 
                        && !is_user_logged_in()) {
                            return true;
                        } elseif (isset($ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio']) && "logged-in-user" === $ppws_product_categories_options['ppws_product_categories_select_user_role_field_radio'] && is_user_logged_in()) {

                            if (isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                                $current_user = wp_get_current_user();
                                $current_user_role = $current_user->roles;
                                $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
    
                                if (isset($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']) && !empty($ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox'])) {
                                    $selected_user = explode(",", $ppws_product_categories_options['ppws_product_categories_logged_in_user_field_checkbox']);
                                  
                                    if (current_user_can('administrator') && $ppws_password_status_for_admin != 'on') {
                                        array_push($selected_user, 'Administrator');
                                    }
                                    if (in_array(ucfirst($final), $selected_user)) {
                                        return true;
                                    }
                                }
                            } else {
                                if (current_user_can('administrator') && $ppws_password_status_for_admin != 'on') {
                                    return true;
                                }
                            }

                        }
                    } else {
                        // Check if the current user is an administrator and admin bypass is disabled.
                        if (current_user_can('administrator')) {
                            if ('on' !== $ppws_password_status_for_admin) {
                                return true;
                            }
                        } else {
                            return true;
                        } 
                    }
                }
            }
        } 
    }

    // Return false if password protection is not enabled or no options are found.
    return false;
}

/**
 * Check if the protected page is protected based on password settings and user roles.
 * @return bool True if the page is protected, false otherwise.
 */
function is_protected_page() {
    // Get page options from settings.
    $ppws_page_options = get_option('ppws_page_settings');
    
    // Check if the page options exist and password protection is enabled.
    if (isset($ppws_page_options['ppws_page_enable_password_field_checkbox']) && $ppws_page_options['ppws_page_enable_password_field_checkbox'] === 'on') {
        
        // Get the status of password protection for admin users.
        $ppws_page_status_for_admin = isset($ppws_page_options['ppws_page_enable_password_field_checkbox_for_admin']) ? $ppws_page_options['ppws_page_enable_password_field_checkbox_for_admin'] : 'off';
        
        // Get the current page ID.
        if (is_home() && !in_the_loop()) {
            $ID = get_option('page_for_posts');
        } elseif (is_post_type_archive('product')) {
            $ID = get_option('woocommerce_shop_page_id'); 
        } else { 
            $ID = get_the_ID();
        }
        
        // Get the current page name.
        $page_name = get_the_title();
        
        // Get selected protected pages.
        $selected_pages = isset($ppws_page_options['ppws_page_list_of_page_field_checkbox']) ? explode(",", $ppws_page_options['ppws_page_list_of_page_field_checkbox']) : array();
        
        // Check if the current page ID is in the selected protected pages.
        if (in_array(ucfirst($ID), $selected_pages)) {
            if (isset($ppws_page_options['enable_user_role'])) {
                if (isset($ppws_page_options['ppws_page_select_user_role_field_radio'])) {
                    // Check if the page is accessible for non-logged-in users.
                    if ("non-logged-in-user" === $ppws_page_options['ppws_page_select_user_role_field_radio'] && !is_user_logged_in()) {
                        return true;
                    } elseif ("logged-in-user" === $ppws_page_options['ppws_page_select_user_role_field_radio'] && is_user_logged_in()) {
                        // Check if the page is accessible for logged-in users based on their roles.
                        $current_user = wp_get_current_user();
                        $current_user_role = $current_user->roles;
                        $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
    
                        $selected_user = isset($ppws_page_options['ppws_page_logged_in_user_field_checkbox']) ? explode(",", $ppws_page_options['ppws_page_logged_in_user_field_checkbox']) : array();
                            
                        if (current_user_can('administrator') && $ppws_page_status_for_admin != 'on') {
                            array_push($selected_user, 'Administrator');
                        }

                        if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                            return true;
                        }
                    }
                } else {
                    // Check if the current user is an administrator and admin bypass is disabled.
                    if (current_user_can('administrator') && $ppws_page_status_for_admin != 'on') {
                        return true;
                    }
                }

            } else {
                // Check if the current user is an administrator and admin bypass is disabled.
                if (current_user_can('administrator')) {
                    if ('on' !== $ppws_page_status_for_admin) {
                        return true;
                    }
                } else {
                    return true;
                } 
            }

        }
    }

    // Return false if password protection is not enabled or no options are found.
    return false;
}


/**
 * Checks if the single product is protected based on password settings and user roles.
 */
function is_protected_single_product() {
    global $product;
    
    $final          = '';
    $selected_user  = array();

    // Get single product settings from options.
    $ppws_single_product_settings = get_option('ppws_single_product_settings');
    // Check if the product settings exist and are not empty.
    if (isset($ppws_single_product_settings) && !empty($ppws_single_product_settings)) {
        
        // Check if password protection is enabled.
        if (isset($ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox']) && 'on' === $ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox'] && is_product()) {
            // Get the product object and its password settings.
            $ppws_single_product_obj    = get_page_by_path($product, OBJECT, 'product');
            $ppws_single_product_meta   = get_post_meta($ppws_single_product_obj->ID, 'ppws_single_product_password_setting', true);
            
            // Check if the password settings exist and the product is set as "Private".
            if (isset($ppws_single_product_meta)) {
                if(isset($ppws_single_product_meta['ppws_single_product_password_setting_radio']) && 'Private' === $ppws_single_product_meta['ppws_single_product_password_setting_radio']){
                    
                    // Get the status of password protection for admin users.
                    $ppws_single_product_status_for_admin = isset($ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox_for_admin']) ? $ppws_single_product_settings['ppws_single_product_enable_password_field_checkbox_for_admin'] : 'off';
                    
                    // Check if user roles are enabled.
                    if (isset($ppws_single_product_settings['enable_user_role']) && 'on' === $ppws_single_product_settings['enable_user_role']) {

                        // Check if the product is accessible for non-logged-in users.
                        if ("non-logged-in-user" === $ppws_single_product_settings['ppws_single_product_select_user_role_field_radio'] && !is_user_logged_in()) {
                            // Product is accessible for non-logged-in users.
                            return true;
                        } else {
                            // Check if the product is accessible for logged-in users based on their roles.
                            if ("logged-in-user" === $ppws_single_product_settings['ppws_single_product_select_user_role_field_radio'] && is_user_logged_in()) {
                                
                                $current_user       = wp_get_current_user();
                                $current_user_role  = $current_user->roles;
                                $final              = ucfirst(str_replace("_", " ", array_shift($current_user_role)));
                           
                                // Check if the user roles is selected or not.
                                if(isset($ppws_single_product_settings['ppws_single_product_logged_in_user_field_checkbox']) && !empty($ppws_single_product_settings['ppws_single_product_logged_in_user_field_checkbox'])){
                                    $logged_in_user     = $ppws_single_product_settings['ppws_single_product_logged_in_user_field_checkbox'];
                                    $selected_user      = explode(",", $logged_in_user);
                                }

                                // Add "Administrator" role to the selected user roles if admin bypass is disabled.
                                if ('on' !== $ppws_single_product_status_for_admin && current_user_can('administrator')) {
                                    array_push($selected_user, 'Administrator');
                                }

                                // Check if the current user role is allowed to access the product or the user is not logged in.
                                if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {      
                                    // Product is accessible for logged-in users based on their roles.
                                    return true;
                                }
                            }
                        }
                    } else {
                        // Check if the current user is an administrator and admin bypass is disabled.
                        if (current_user_can('administrator')) {
                            if ('on' !== $ppws_single_product_status_for_admin) {
                                // Product is accessible for administrators without admin bypass.
                                return true;
                            }
                        } else {
                            // Product is inaccessible for regular users.
                            return true;
                        }
                    }
                }
            }
        }
    }

    // Return false if password protection is not enabled or no options are found.
    return false;
}



/**
 * Checks if a product in a single category is protected by password.
 *
 * @return bool Whether the product in a single category is password protected.
 */
function is_protected_single_category() {
    global $product;

    // Initialize variables
    $ppws_product_category_password = '';
    $ppws_single_category_flag      = false;
    $selected_user                  = array();
    $ppws_product_categories_args   = array();

    // Get the settings for single categories
    $ppws_single_categories_settings = get_option('ppws_single_categories_settings');

    // Check if password protection is enabled for single categories and if it's a product page
    if (
        isset($ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox'])
        && 'on' === $ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox']
        && is_product()
        ) {
            // Get the product object
            $ppws_product_obj = get_page_by_path($product, OBJECT, 'product');
            $ppws_product_id = $ppws_product_obj->ID;
            
            // Get the categories id for the product
            $ppws_product_categories_args = ppws_get_product_categories($ppws_product_id);
            
            // Get the stored cookie for category access
            $ppws_single_categories_cookie = ppws_get_cookie("ppws_product_categories_cookie");
            $ppws_single_categories_cookie = json_decode(stripslashes($ppws_single_categories_cookie), true);
            
            // Check if the cookie prevents access for any category
            if (isset($ppws_single_categories_cookie) && !empty($ppws_single_categories_cookie)) {
                foreach ($ppws_product_categories_args as $ppws_product_category) {
                    if (array_key_exists('ppws-' . $ppws_product_category, $ppws_single_categories_cookie)) {
                        return false; // Access denied
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
                        
                            if (
                                isset($ppws_single_categories_cookie['ppws-' . $ppws_product_category])
                                && ppws_decrypted_password($ppws_single_categories_cookie['ppws-' . $ppws_product_category])
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

        // Check if access is denied for the protected category
        if ($ppws_single_category_flag) {
            // Get category password protection settings for admin
            $ppws_product_category_status_for_admin = isset($ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox_for_admin'])
                ? $ppws_single_categories_settings['ppws_single_categories_enable_password_field_checkbox_for_admin']
                : 'off';

            // Check if user role access is enabled
            if (isset($ppws_single_categories_settings['enable_user_role']) && 'on' === $ppws_single_categories_settings['enable_user_role']) {
                // Check access for non-logged-in users
                if ("non-logged-in-user" === $ppws_single_categories_settings['ppws_single_categories_select_user_role_field_radio'] && !is_user_logged_in()) {
                    return true; // Access granted
                } else {

                    // Get the current user's role
                    $current_user = wp_get_current_user();
                    $current_user_role = $current_user->roles;
                    $final = ucfirst(str_replace("_", " ", array_shift($current_user_role)));

                    // Check access for logged-in users
                    if ("logged-in-user" === $ppws_single_categories_settings['ppws_single_categories_select_user_role_field_radio'] && is_user_logged_in()) {
                        // Get selected user roles
                        if (
                            isset($ppws_single_categories_settings['ppws_single_categories_logged_in_user_field_checkbox'])
                            && !empty($ppws_single_categories_settings['ppws_single_categories_logged_in_user_field_checkbox'])
                        ) {
                            $logged_in_user = $ppws_single_categories_settings['ppws_single_categories_logged_in_user_field_checkbox'];
                            $selected_user = explode(",", $logged_in_user);
                        }

                        // Add 'Administrator' to selected user roles if admin access is allowed
                        if ('on' !== $ppws_product_category_status_for_admin && current_user_can('administrator')) {
                            array_push($selected_user, 'Administrator');
                        }

                        // Check if the current user has access
                        if (in_array(ucfirst($final), $selected_user) || !is_user_logged_in()) {
                            return true; // Access granted
                        }
                    }
                }
            } else {
                // Check admin and non-admin access
                if (current_user_can('administrator')) {
                    if ('on' !== $ppws_product_category_status_for_admin) {
                        return true; // Access granted
                    }
                } else {
                    return true; // Access granted
                }
            }
        }
    }

    return false; // Access denied
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