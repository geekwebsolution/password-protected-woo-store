<?php

if (!defined('ABSPATH')) exit;

/**
 * License manager module
 */
function ppws_updater_utility() {
    $prefix = 'WPPS_';
    $settings = [
        'prefix' => $prefix,
        'get_base' => WPPS_PLUGIN_BASENAME,
        'get_slug' => WPPS_PLUGIN_DIR,
        'get_version' => WPPS_BUILD,
        'get_api' => 'https://download.geekcodelab.com/',
        'license_update_class' => $prefix . 'Update_Checker'
    ];

    return $settings;
}

function ppws_updater_activate() {

    // Refresh transients
    delete_site_transient('update_plugins');
    delete_transient('ppws_plugin_updates');
    delete_transient('ppws_plugin_auto_updates');
}

require_once(WPPS_PLUGIN_DIR_PATH . 'updater/class-update-checker.php');
