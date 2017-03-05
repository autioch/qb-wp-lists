<?php

/*
  Plugin Name: Qb Collections
  Plugin URI: http://qb.net.pl
  Description: Easily managable collections of items.
  Version: 0.1
  Author: Jakub Szczepaniak
  Author URI: http://qb.net.pl
  License: GPL2
 */

/* plugin file */
define('QBCOL', __FILE__);

/* plugin working dir for php includes */
define('QBCOL_DIR', plugin_dir_path(__FILE__));

/* plugin url for public includes  */
define('QBCOL_URL', plugin_dir_url(__FILE__));

/*  database prefix */
/* TODO - this sometimes doesn't work */
global $wpdb;
define('QBCOL_TABLE', $wpdb->prefix . 'qbcol_');

function qbColLoadClass($class, $create = false, $arg = null) {
    /* Autoloaders are not welcome in da Wordpress world */
    !class_exists($class) && require_once QBCOL_DIR . 'classes/' . $class . '.class.php';

    return $create ? new $class($arg) : true;
}

$qbCol = qbColLoadClass(is_admin() ? 'qbColAdmin' : 'qbColFront', true);
