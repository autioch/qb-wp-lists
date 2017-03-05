<?php

/* TODO rewrite */

class zkwpAdmin {

    private $pup = null;
    private $install = null;
    private $collections = null;

    public function __construct($collections) {
        $this->pup = zkwp_load_class('zkwpAdminPup', true);
        $this->collections = $collections;
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('admin_print_footer_scripts', array($this, 'footerScripts'));
        register_activation_hook(ZKWP_TOOLS_FILE, array($this, 'activation'));
        register_deactivation_hook(ZKWP_TOOLS_FILE, array($this, 'deactivation'));
    }

    public function adminInit() {
        $pageName = 'zkwp_pup';
        $sectionId = 'zkwp_pup_options_section';
        $optionGroup = 'zkwp_pup_options';
        add_settings_section($sectionId, 'Szczenięta', array($this->pup, 'sectionCallback'), $pageName);
        register_setting($optionGroup, 'zkwp_pup_cache_duration', array($this->pup, 'sanitize'));
        register_setting($optionGroup, 'zkwp_pup_department', array($this->pup, 'sanitize'));
        register_setting($optionGroup, 'zkwp_pup_cache', array($this->pup, 'sanitize'));
        add_settings_field('zkwp_pup_cache_duration', 'Odświeżanie', array($this->pup, 'cacheDurationCallback'), $pageName, $sectionId);
        add_settings_field('zkwp_pup_department', 'Oddział', array($this->pup, 'departmentCallback'), $pageName, $sectionId);
        add_settings_field('zkwp_pup_cache', 'Plik cache', array($this->pup, 'cacheCallback'), $pageName, $sectionId);
    }

    public function adminMenu() {
        /*
         * In situations where a plugin is creating its own top-level menu, the first
         * submenu will normally have the same link title as the top-level menu and
         * hence the link will be duplicated. The duplicate link title can be avoided
         * by calling the add_submenu_page function the first time with the parent_slug
         * and menu_slug parameters being given the same value.
         *  */
        add_menu_page('ZKWP Tools', 'ZKWP Tools', 'edit_others_posts', 'zkwp_champion', array($this, 'getSubmenuPage'), null, 3);
        add_submenu_page('zkwp_champion', 'Czempiony', 'Czempiony', 'edit_others_posts', 'zkwp_champion', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Reproduktory', 'Reproduktory', 'edit_others_posts', 'zkwp_reproductor', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Hodowle', 'Hodowle', 'edit_others_posts', 'zkwp_kennel', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Wystawy', 'Wystawy', 'edit_others_posts', 'zkwp_show', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Kluby i sekcje', 'Kluby i sekcje', 'edit_others_posts', 'zkwp_club', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Opłaty', 'Opłaty', 'edit_others_posts', 'zkwp_fee', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Galerie', 'Galerie', 'edit_others_posts', 'zkwp_gallery', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Rasy', 'Rasy', 'edit_others_posts', 'zkwp_breed', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Grupy', 'Grupy', 'edit_others_posts', 'zkwp_group', array($this, 'getSubmenuPage'));
        add_submenu_page('zkwp_champion', 'Szczenięta', 'Szczenięta', 'edit_others_posts', 'zkwp_pup', array($this, 'pupOptions'));
    }

    public function footerScripts() {
        if (wp_script_is('quicktags')) {
            ?>
            <script type="text/javascript">
                QTags.addButton('zkwp_tools_champion', 'Czempiony', '[zkwp_tools_champion]', '', '', 'Wstawi listę czempionów', 1);
                QTags.addButton('zkwp_tools_reproductor', 'Reproduktory', '[zkwp_tools_reproductor]', '', '', 'Wstawi listę reproduktorów', 1);
                QTags.addButton('zkwp_tools_kennel', 'Hodowle', '[zkwp_tools_kennel]', '', '', 'Wstawi listę hodowli', 1);
                QTags.addButton('zkwp_tools_show', 'Wystawy', '[zkwp_tools_show year="2014"]', '', '', 'Wstawi listę wystaw dla wybranego roku', 1);
                QTags.addButton('zkwp_tools_club', 'Klub i sekcje', '[zkwp_tools_club]', '', '', 'Wstawi listę klubów i sekcji', 1);
                QTags.addButton('zkwp_tools_fee', 'Opłaty', '[zkwp_tools_fee]', '', '', 'Wstawi listę opłat', 1);
                QTags.addButton('zkwp_tools_gallery', 'Galeria', '[zkwp_tools_gallery]', '', '', 'Wstawi listę galerii', 1);
                QTags.addButton('zkwp_tools_pup', 'Szczeniaki', '[zkwp_tools_pup]', '', '', 'Wstawi listę szczeniąt', 1);
            </script>
            <?php

        }
    }

    public function activation() {
        $this->install = zkwp_load_class('zkwpInstall', true, $this->collections);
        $this->install->install();
    }

    public function deactivation() {
//        global $wpdb;
//        $wpdb->query("delete from `wp_options` where option_name like 'zkwp_db%'");
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'group');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'club');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'show');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'hound');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'kennel');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'breed');
//        $wpdb->query('drop table ' . ZKWP_TABLE . 'fee');
    }

    public function getSubmenuPage() {
        $page = str_replace('zkwp_', '', filter_input(INPUT_GET, 'page'));
        if (empty($this->$page)) {
            $this->$page = zkwp_load_class('zkwpCollectionPage', true, $this->collections[$page]);
        }
        $this->$page->getPage();
        $this->enqueueResources();
    }

    public function pupOptions() {
        $this->pup->getPage();
        $this -> enqueueResources();
    }

    public function enqueueResources() {
        /* enqueue jquery and jquery.datatables to enhance the table we will produce */
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery.datatables', ZKWP_TOOLS_URL . 'public/jquery.dataTables.min.js', array('jquery'));
        wp_enqueue_script('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.min.js', array('jquery', 'jquery-ui-datepicker'));
        wp_enqueue_style('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.css');
    }

}
