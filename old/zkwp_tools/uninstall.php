<?php

/*
 * File uninstalling the plugin
 * removes all options, all data
 * 
 */

if (
        !defined('WP_UNINSTALL_PLUGIN') ||
        !WP_UNINSTALL_PLUGIN ||
        dirname(WP_UNINSTALL_PLUGIN) != dirname(plugin_basename(__FILE__))
) {
    status_header(404);
    exit;
}

// Delete all options
//delete_option('qb_test_setting');
//delete_option('qb_test_db_version');
