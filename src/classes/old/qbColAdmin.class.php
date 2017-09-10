<?php

class qbColAdmin
{
    private $collections = [];

    public function __construct()
    {
        $this->collections = include_once QBCOL_DIR . 'collections.php';
        add_action('admin_menu', [$this,    'adminMenu']);
        add_action('admin_print_footer_scripts', [$this, 'adminPrintFooterScripts']);
        register_activation_hook(QBCOL, [$this, 'activationHook']);
        register_deactivation_hook(QBCOL, [$this, 'deactivationHook']);
    }

    public function adminMenu()
    {
        add_menu_page('Kolekcje', 'Kolekcje', 'edit_others_posts', 'qbcol', [$this, 'menuPage'], null, 4);
        foreach ($this->collections as $c) {
            add_submenu_page('qbcol', $c['title'], $c['title'], 'edit_others_posts', 'qbcol_' . $c['id'], [$this, 'submenuPage']);
        }
    }

    public function adminPrintFooterScripts()
    {
        if (wp_script_is('quicktags')) {
            ?>
            <script type="text/javascript">
                QTags.addButton('qbcol', 'Kolekcje', '[qbcol id=""]', '', '', 'Wstawi tag kolekcji', 1);
            </script>
            <?php
        }
    }

    public function activationHook()
    {
        $this->database = qbColLoadClass('qbColInstall', true, $this->collections);
        $this->database->install();
    }

    public function deactivationHook()
    {
    }

    public function menuPage()
    {
        echo 'Qb Collections';
    }

    public function submenuPage()
    {
        $page = str_replace('qbcol_', '', filter_input(INPUT_GET, 'page'));
        qbColLoadClass('qbColPage', true, $this->collections[$page])->getPage();
        $this->enqueuePublic();
    }

    public function enqueuePublic()
    {
        /* enqueue jquery and jquery.datatables to enhance the table we will produce */
//        wp_enqueue_script('jquery');
//        wp_enqueue_script('jquery-ui-datepicker');
//        wp_enqueue_script('jquery.datatables', ZKWP_TOOLS_URL . 'public/jquery.dataTables.min.js', array('jquery'));
//        wp_enqueue_script('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.min.js', array('jquery', 'jquery-ui-datepicker'));
//        wp_enqueue_style('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.css');
    }
}
