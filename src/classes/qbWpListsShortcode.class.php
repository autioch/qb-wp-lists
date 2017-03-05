<?php

class qbWpListsShortcode
{
    private $breeds = ' b.name_pl as breed_pl, b.name_en as breed_en, b.name_de as breed_de ';
    private $singleShowPresented = false;
    private $selectedKey = -1;

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
        $this->getSelectedId();
        $this->registerShortcodes();
    }

    public function championCallback() {
        $this->enqueueResources();
        $sql = 'SELECT b.name as breed_name, g.name_pl as group_name, g.id as group_id, ' . $this->breeds . ', c.* FROM ' . QBWPLISTS_TABLE . 'champion c '
                . ' LEFT JOIN ' . QBWPLISTS_TABLE . 'breed b ON c.breed_id = b.id '
                . ' LEFT JOIN ' . QBWPLISTS_TABLE . 'group g ON c.group_id = g.id '
                . ' WHERE c.active = 1 ORDER BY g.id ASC, g.name_pl ASC, b.name ASC';
        ob_start();
        $this->render('champion', $sql);

        return ob_get_clean();
    }

    public function reproductorCallback() {
        $this->enqueueResources();
        $sql = 'SELECT g.id AS group_id, g.name_pl AS group_name, '
                . ' r.breed_id AS breed_id, b.name AS breed_name, ' . $this->breeds
                . ' FROM ' . QBWPLISTS_TABLE . 'reproductor r LEFT JOIN ' . QBWPLISTS_TABLE . 'breed b ON r.breed_id = b.id '
                . ' LEFT JOIN ' . QBWPLISTS_TABLE . 'group g ON b.group_id = g.id '
                . ' WHERE r.active =1 GROUP BY r.breed_id ORDER BY g.id, b.name';
        ob_start();
        $this->render('reproductor.select', $sql);
        if ($this->selectedKey > 0) {
            $sql = 'SELECT * FROM ' . QBWPLISTS_TABLE . 'reproductor where active = 1 and breed_id = ' . $this->selectedKey;
            $this->render('reproductor', $sql);
        }

        return ob_get_clean();
    }

    private function getSelectedId() {
        $id = filter_input(INPUT_GET, 'qb-wp-lists-key');
        $this->selectedKey = is_numeric($id) ? $id : -1;
    }

    private function registerShortcodes() {
        add_shortcode('qb_wp_lists_champion', [$this, 'championCallback']);
        add_shortcode('qb_wp_lists_reproductor', [$this, 'reproductorCallback']);
    }

    private function render($view, $query) {
        if (!isset($this->view)) {
            $this->view = qbWpListsLoadClass('View', true);
            $this->view->selectedKey = $this->selectedKey;
        }
        $this->view->render($view, $query);
    }

    private function enqueueResources() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery.datatables', QBWPLISTS_URL . 'public/jquery.dataTables.min.js', ['jquery']);
        wp_enqueue_script('qb_wp_lists', QBWPLISTS_URL . 'public/qb_wp_lists.min.js', ['jquery']);
        wp_enqueue_script('jquery.unveil', QBWPLISTS_URL . 'public/jquery.unveil.js', ['jquery']);
        wp_enqueue_style('qb_wp_lists', QBWPLISTS_URL . 'public/qb_wp_lists.css');
    }
}
