<?php

class qbWpListsAdmin
{
    private $install = null;
    private $collections = null;

    public function __construct($collections) {
        $this->collections = $collections;
        add_action('admin_menu', [$this, 'adminMenu']);
        add_action('admin_print_footer_scripts', [$this, 'footerScripts']);
        register_activation_hook(QBWPLISTS_FILE, [$this, 'activation']);
        register_deactivation_hook(QBWPLISTS_FILE, [$this, 'deactivation']);
        file_put_contents('F:\\activation.text', 'a');
    }

    public function adminMenu() {
        /*
         * In situations where a plugin is creating its own top-level menu, the first
         * submenu will normally have the same link title as the top-level menu and
         * hence the link will be duplicated. The duplicate link title can be avoided
         * by calling the add_submenu_page function the first time with the parent_slug
         * and menu_slug parameters being given the same value.
         *  */
        add_menu_page('Qb Wp Lists', 'Qb Wp Lists', 'edit_others_posts', 'qb_wp_lists_champion', [$this, 'getSubmenuPage'], null, 3);
        add_submenu_page('qb_wp_lists_champion', 'Czempiony', 'Czempiony', 'edit_others_posts', 'qb_wp_lists_champion', [$this, 'getSubmenuPage']);
        add_submenu_page('qb_wp_lists_champion', 'Reproduktory', 'Reproduktory', 'edit_others_posts', 'qb_wp_lists_reproductor', [$this, 'getSubmenuPage']);
    }

    public function footerScripts() {
        if (wp_script_is('quicktags')) {
            ?>
            <script type="text/javascript">
                QTags.addButton('qb_wp_lists_champion', 'Czempiony', '[qb_wp_lists_champion]', '', '', 'Wstawi listę czempionów', 1);
                QTags.addButton('qb_wp_lists_reproductor', 'Reproduktory', '[qb_wp_lists_reproductor]', '', '', 'Wstawi listę reproduktorów', 1);
            </script>
            <?php

        }
    }

    public function activation() {
        $this->install = qbWpListsLoadClass('Install', true, $this->collections);
        $this->install->install();
    }

    public function deactivation() {
       global $wpdb;
       $wpdb->query('drop table ' . QBWPLISTS_TABLE . 'champion');
       $wpdb->query('drop table ' . QBWPLISTS_TABLE . 'reproductor');
       $wpdb->query('drop table ' . QBWPLISTS_TABLE . 'contact_nonces');
    }

    public function getSubmenuPage() {
        $page = str_replace('qb_wp_lists_', '', filter_input(INPUT_GET, 'page'));
        if (empty($this->$page)) {
            $this->$page = qbWpListsLoadClass('AdminPage', true, $this->collections[$page]);
        }
        $this->$page->getPage();
        $this->enqueueResources();
    }

    public function enqueueResources() {
        /* enqueue jquery and jquery.datatables to enhance the table we will produce */
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery.datatables', QBWPLISTS_URL . 'public/jquery.dataTables.min.js', ['jquery']);
        wp_enqueue_script('qb_wp_lists', QBWPLISTS_URL . 'public/qb_wp_lists.min.js', ['jquery', 'jquery-ui-datepicker']);
        wp_enqueue_style('qb_wp_lists', QBWPLISTS_URL . 'public/qb_wp_lists.css');
    }
}
