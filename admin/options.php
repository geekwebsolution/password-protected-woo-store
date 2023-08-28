<?php
include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/general-setting.php');
include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/page-setting.php');
include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/product-categories-setting.php');

include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/single-product-setting.php');
include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/single-categories-setting.php');

include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/form-content.php');
include(WPPS_PLUGIN_DIR_PATH . 'admin/setting/form-design.php');

$default_tab = null;
$tab = "";

$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab;

if (!class_exists('ppws_password_protected_store_settings')) {
    if ($tab == null) { //ppws-whole-site
        $ppws_whole_site_class = new ppws_whole_site_settings();
        add_action('admin_init', array($ppws_whole_site_class, 'ppws_whole_site_register_settings_init'));
    }

    if ($tab == 'page-setting') {
        $ppws_page_class = new ppws_page_settings();
        add_action('admin_init', array($ppws_page_class, 'ppws_page_register_settings_init'));
    }

    if ($tab == 'product-categories') {
        $ppws_product_categories_class = new ppws_product_categories_settings();
        add_action('admin_init', array($ppws_product_categories_class, 'ppws_product_categories_register_settings_init'));
    }

    if ($tab == 'single-product-setting') {
        $ppws_single_product_class = new ppws_single_product_setting();
        add_action('admin_init', array($ppws_single_product_class, 'ppws_single_product_register_settings_init'));
    }

    if ($tab == 'single-categories-setting') {
        $ppws_single_categories_class = new ppws_single_categories_setting();
        add_action('admin_init', array($ppws_single_categories_class, 'ppws_single_categories_register_settings_init'));
    }

    if ($tab == 'form-content') {        
        $ppws_form_class = new ppws_form_settings();
        add_action('admin_init', array($ppws_form_class, 'ppws_form_settings_register_settings_init'));
    }

    if ($tab == 'form-design') {
        $ppws_form_style_class = new ppws_form_style_settings();
        add_action('admin_init', array($ppws_form_style_class, 'ppws_form_style_settings_register_settings_init'));
    }

    class ppws_password_protected_store_settings 
    {
        public function __construct() 
        {
             add_action('admin_menu', array($this, 'ppws_admin_menu_setting_page'));
        }

         function ppws_admin_menu_setting_page()
        {
            add_submenu_page('woocommerce', 'Password Protected', 'Password Protected', 'manage_options', 'ppws-option-page', array($this, 'password_protected_store_callback'));
        }

        function password_protected_store_callback() 
        {
            $default_tab = null;
            $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $default_tab;
            ?>
            <div class='ppws-main-box'>
                <div class='ppws-container'>
                    <div class='ppws-header'>
                        <h1 class='ppws-h1'> <?php _e('Password Protected Store for WooCommerce', 'password-protected-store-for-woocommerce'); ?> </h1>
                    </div>
                    <div class="ppws-option-section">
                        <div class="ppws-tabbing-box">
                            <ul class="ppws-tab-list nav-tab-wrapper">
                                <li>
                                    <a href="?page=ppws-option-page" class="nav-tab <?php if ($tab === null) :  ?>nav-tab-active <?php endif; ?>"> <?php _e('General Setting', 'password-protected-store-for-woocommerce'); ?> </a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=product-categories" class="nav-tab <?php if ($tab === 'product-categories') : ?>nav-tab-active<?php endif; ?>"><?php _e('Product Categories', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=page-setting" class="nav-tab <?php if ($tab === 'page-setting') : ?>nav-tab-active<?php endif; ?>"><?php _e('Page Setting', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=single-product-setting" class="nav-tab <?php if ($tab === 'single-product-setting') : ?>nav-tab-active<?php endif; ?>"><?php _e('Single Product Setting', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=single-categories-setting" class="nav-tab <?php if ($tab === 'single-categories-setting') : ?>nav-tab-active<?php endif; ?>"><?php _e('Single Categories Setting', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=form-content" class="nav-tab <?php if ($tab === 'form-content') : ?>nav-tab-active<?php endif; ?>"><?php _e('Form Content', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                                <li>
                                    <a href="?page=ppws-option-page&tab=form-design" class="nav-tab <?php if ($tab === 'form-design') : ?>nav-tab-active<?php endif; ?>"><?php _e('Form Design', 'password-protected-store-for-woocommerce'); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="ppws-tabbing-option">
                            <?php
                            if ($tab == null) {
                                $ppws_whole_site_class = new ppws_whole_site_settings();
                                $ppws_whole_site_class->ppws_whole_site_callback();
                            }

                            if ($tab == 'page-setting') {
                                $ppws_page_class = new ppws_page_settings();
                                $ppws_page_class->ppws_page_callback();
                            }

                            if ($tab == 'product-categories') {
                                $ppws_product_categories_class = new ppws_product_categories_settings();
                                $ppws_product_categories_class->ppws_product_categories_callback();
                            }

                            if ($tab == 'single-product-setting') {
                                $ppws_single_product_class = new ppws_single_product_setting();
                                $ppws_single_product_class->ppws_single_product_callback();
                            }

                            if ($tab == 'single-categories-setting') {
                                $ppws_single_categories_class = new ppws_single_categories_setting();
                                $ppws_single_categories_class->ppws_single_categories_callback();
                            }

                            if ($tab == 'form-content') {
                                $ppws_form_class = new ppws_form_settings();
                                $ppws_form_class->ppws_form_settings_callback();
                            }

                            if ($tab == 'form-design') {
                                $ppws_form_style_class = new ppws_form_style_settings();
                                $ppws_form_style_class->ppws_form_style_settings_callback();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    new ppws_password_protected_store_settings();
}