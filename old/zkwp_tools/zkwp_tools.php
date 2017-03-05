<?php

/*
  Plugin Name: ZKWP Tools
  Plugin URI: http://qb.net.pl
  Description: Zestaw narzędzi przygotowanych dla oddziałów Związku Kynologicznego w Polsce
  Version: 0.41
  Author: Jakub Szczepaniak
  Author URI: http://qb.net.pl
  License: GPL2
 */

/* aktualna wersja pluginu */
define('ZKWP_TOOLS', '0.37');

/* aktualny katalog pracy pluginu, jeśli chcemy włączyć jakiś plik  */
define('ZKWP_TOOLS_DIR', plugin_dir_path(__FILE__));

/* aktualny url do katalogu pluginu, jeśli chcemy dodać js/css  */
define('ZKWP_TOOLS_URL', plugin_dir_url(__FILE__));

/* główny plik, wykorzystywany w różnych miejscach */
define('ZKWP_TOOLS_FILE', __FILE__);

/* prefix do tabel w bazie danych */
global $wpdb;
define('ZKWP_TABLE', $wpdb->prefix . 'zkwp_');

function zkwp_load_class($class, $create = false, $arg = null) {
    /* Autoloaders are not welcome in da Wordpress world */
    !class_exists($class) && require_once ZKWP_TOOLS_DIR . 'classes/' . $class . '.class.php';

    return $create ? new $class($arg) : true;
}

include_once ZKWP_TOOLS_DIR . 'resources/collections.php';
include_once ZKWP_TOOLS_DIR . 'resources/forms.php';
zkwp_load_class('qbWebForm');

if (is_admin()) {
    $zkwpAdmin = zkwp_load_class('zkwpAdmin', true, $zkwpCollections);
} else {
    $zkwpShortcode = zkwp_load_class('zkwpShortcode', true, $zkwpCollections);
    $zkwpContactForm = zkwp_load_class('zkwpContactForm', true, $zkwpForms);
}
