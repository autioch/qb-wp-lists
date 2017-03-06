<?php

/*
  Plugin Name: Qb WP Lists
  Plugin URI: https://github.com/autioch/qb-wp-lists
  Description: Plugin for managing and displaying lists of items.
  Version: 1.0.0
  Author: Autioch
  Author URI: https://github.com/autioch
  License: GPL2
*/

/* Current plugin version. */
define('QBWPLISTS', '1.0.0');

/* Current plugin working directory, if we want to include any php. */
define('QBWPLISTS_DIR', plugin_dir_path(__FILE__));

/* Current plugin url, if we want to include any js/css. */
define('QBWPLISTS_URL', plugin_dir_url(__FILE__));

/* Main file. */
define('QBWPLISTS_FILE', __FILE__);

/* Generic resource prefix */
define('QBWPLISTS_ID', 'qb_wp_lists_');

/* Database tables prefix. */
global $wpdb;
define('QBWPLISTS_TABLE', $wpdb->prefix . QBWPLISTS_ID);

/* Load definitions of the lists. */
$qbWpListsDefinitions = include_once QBWPLISTS_DIR . 'resources/definitions.php';
$qbWpListsForms = include_once QBWPLISTS_DIR . 'resources/forms.php';

require_once QBWPLISTS_DIR . 'utils.php';

/* Load support class for forms */
qbWpListsLoadClass('Form');

/* Create class based on location in wordpress. */
if (is_admin()) {
    /* For admin, load administration class. */
    $qbWpListsAdmin = qbWpListsLoadClass('Admin', true, $qbWpListsDefinitions);
} else {
    /* For frontend, public part, load shortcodes and contact forms. */
    $qbWpListsShortcode = qbWpListsLoadClass('Shortcode', true, $qbWpListsDefinitions);
    $qbWpListsContactForm = qbWpListsLoadClass('Contact', true, $qbWpListsForms);
}
