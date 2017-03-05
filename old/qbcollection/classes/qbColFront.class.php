<?php

/* TODO rewrite getting and using selected key */

class qbColFront {

    private $selectedKey = -1;

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
        $this->getSelectedKey();
        $this->registerShortcodes();
    }

    private function getSelectedKey() {
        $id = filter_input(INPUT_GET, 'zkwp-tools-key');
        $this->selectedKey = is_numeric($id) ? $id : -1;
    }

    private function registerShortcodes() {
        add_shortcode('qbcol', array($this, 'qbColCallback'));
    }

    public function qbColCallback($atts) {
        $this->enqueueResources();
        $a = shortcode_atts(array('collection' => false), $atts);
        $col = $this->collections[$a['collection']];
        ob_start();
        if (array_key_exists('frontSelectQuery', $col)) {
            $this->fillView('select', $col['front']['select'], $col['id']);
            if ($this->selectedKey > 0) {
                $this->fillView('list', $col['front']['list'], $col['id']);
            }
        } else {
            $this->fillView('list', $col['front']['list'], $col['id']);
        }
        return ob_get_clean();
    }

    private function fillView($view, $query, $id) {
        if (!isset($this->view)) {
            $this->view = qbColLoadClass('qbColFrontView', true);
            $this->view->selectedKey = $this->selectedKey;
        }
        $this->view->render($this->getViewFile($view, $id), $query);
    }

    private function getViewFile($view, $id) {
        $colView = QBCOL_DIR . 'views/' . $id . '.' . $view . '.view.php';
        if (file_exists($colView)) {
            return $colView;
        } else {
            return QBCOL_DIR . 'views/' . $view . '.view.php';
        }
    }

    private function enqueueResources() {
        /* enqueue jquery and jquery.datatables to enhance the table we will produce */
        //wp_enqueue_script('jquery');
        //wp_enqueue_script('jquery.datatables', ZKWP_TOOLS_URL . 'public/jquery.dataTables.min.js', array('jquery'));
        //wp_enqueue_script('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.min.js', array('jquery'));
        //wp_enqueue_script('jquery.unveil', ZKWP_TOOLS_URL . 'public/jquery.unveil.js', array('jquery'));
        //wp_enqueue_style('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.css');
    }

}
