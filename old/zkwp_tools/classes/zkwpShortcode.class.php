<?php

/* TODO rewrite */

class zkwpShortcode
{
    private $breeds = ' b.name_pl as breed_pl, b.name_en as breed_en, b.name_de as breed_de ';
    private $pupLoader;
    private $extraParam = null;
    private $singleShowPresented = false;
    private $selectedKey = -1;

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
        $this->getSelectedKey();
        $this->registerShortcodes();
    }

    /* CALLBACKS */

    public function championCallback() {
        $this->enqueueResources();
        $sql = 'SELECT b.name as breed_name, g.name_pl as group_name, g.id as group_id, ' . $this->breeds . ', c.* FROM ' . ZKWP_TABLE . 'champion c '
                . ' LEFT JOIN ' . ZKWP_TABLE . 'breed b ON c.breed_id = b.id '
                . ' LEFT JOIN ' . ZKWP_TABLE . 'group g ON c.group_id = g.id '
                . ' WHERE c.active = 1 ORDER BY g.id ASC, g.name_pl ASC, b.name ASC';
        ob_start();
        $this->fillView('champion', $sql);

        return ob_get_clean();
    }

    public function reproductorCallback() {
        $this->enqueueResources();
        $sql = 'SELECT g.id AS group_id, g.name_pl AS group_name, '
                . ' r.breed_id AS breed_id, b.name AS breed_name, ' . $this->breeds
                . ' FROM wp_zkwp_reproductor r LEFT JOIN wp_zkwp_breed b ON r.breed_id = b.id '
                . ' LEFT JOIN wp_zkwp_group g ON b.group_id = g.id '
                . ' WHERE r.active =1 GROUP BY r.breed_id ORDER BY g.id, b.name';
        ob_start();
        $this->fillView('reproductor.select', $sql);
        if ($this->selectedKey > 0) {
            $sql = 'SELECT * FROM ' . ZKWP_TABLE . 'reproductor where active = 1 and breed_id = ' . $this->selectedKey;
            $this->fillView('reproductor', $sql);
        }

        return ob_get_clean();
    }

    public function clubCallback() {
        $this->enqueueResources();
        $sql = 'SELECT * FROM ' . ZKWP_TABLE . 'club where active = 1';
        ob_start();
        $this->fillView('club', $sql);

        return ob_get_clean();
    }

    public function feeCallback() {
        $this->enqueueResources();
        $sql = 'SELECT * FROM ' . ZKWP_TABLE . 'fee where active = 1';
        ob_start();
        $this->fillView('fee', $sql);

        return ob_get_clean();
    }

    public function kennelCallback() {
        $this->enqueueResources();
        $sql = 'SELECT k.breed_id AS optionkey, b.name_pl AS optionvalue, ' . $this->breeds
                . ' FROM ' . ZKWP_TABLE . 'kennel k '
                . ' LEFT JOIN ' . ZKWP_TABLE . 'breed b ON k.breed_id = b.id '
                . ' WHERE k.active = 1 group by k.breed_id ORDER BY b.name_pl COLLATE utf8_polish_ci;';
        ob_start();
        $this->fillView('select', $sql);
        if ($this->selectedKey > 0) {
            $sql = 'SELECT * FROM ' . ZKWP_TABLE . 'kennel where active = 1 and breed_id = ' . $this->selectedKey;
            $this->fillView('kennel', $sql);
        }

        return ob_get_clean();
    }

    public function showCallback($atts) {
        if ($this->singleShowPresented) {
            return;
        }
        $this->enqueueResources();
        ob_start();
        if ($this->selectedKey > 0) {
            $this->singleShowPresented = true;
            $sql = 'SELECT * FROM ' . ZKWP_TABLE . 'show where id=' . $this->selectedKey;
            $this->fillView('showsingle', $sql);
        } else {
            $a = shortcode_atts(['year' => false], $atts);
            $queryEnd = $a['year'] ? '= ' . $a['year'] : '< YEAR(CURDATE())';
            $sql = 'SELECT id, show_date, city, title FROM ' . ZKWP_TABLE . 'show '
                    . ' WHERE active = 1 and YEAR(show_date) ' . $queryEnd . ' ORDER BY show_date DESC';
            $this->extraParam = $a['year'] ? 'Wystawy na rok ' . $a['year'] : 'Wystawy archiwalne';
            $this->fillView('showlist', $sql);
        }

        return ob_get_clean();
    }

    public function galleryCallback() {
        $this->enqueueResources();
        $sql = 'SELECT YEAR(g.event_date) as year, g.* '
                . ' FROM ' . ZKWP_TABLE . 'gallery g '
                . ' WHERE active = 1 ORDER BY event_date DESC';
        ob_start();
        $this->fillView('gallery', $sql);

        return ob_get_clean();
    }

    public function pupCallback() {
        if (!isset($this->pupLoader)) {
            $this->pupLoader = zkwp_load_class('zkwpPupLoader', true);
            $this->enqueueResources();
        }

        return $this->pupLoader->getData();
    }

    private function getSelectedKey() {
        $id = filter_input(INPUT_GET, 'qbc-key');
        $this->selectedKey = is_numeric($id) ? $id : -1;
    }

    private function registerShortcodes() {
        add_shortcode('zkwp_tools_champion', [$this, 'championCallback']);
        add_shortcode('zkwp_tools_reproductor', [$this, 'reproductorCallback']);
        add_shortcode('zkwp_tools_club', [$this, 'clubCallback']);
        add_shortcode('zkwp_tools_fee', [$this, 'feeCallback']);
        add_shortcode('zkwp_tools_kennel', [$this, 'kennelCallback']);
        add_shortcode('zkwp_tools_show', [$this, 'showCallback']);
        add_shortcode('zkwp_tools_pup', [$this, 'pupCallback']);
        add_shortcode('zkwp_tools_gallery', [$this, 'galleryCallback']);
    }

    /* MISC FUNCTIONS */

    private function fillView($view, $query) {
        if (!isset($this->view)) {
            $this->view = zkwp_load_class('zkwpView', true);
            $this->view->selectedKey = $this->selectedKey;
        }
        $this->view->extraParam = $this->extraParam;
        $this->view->render($view, $query);
    }

    private function enqueueResources() {
        /* enqueue jquery and jquery.datatables to enhance the table we will produce */
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery.datatables', ZKWP_TOOLS_URL . 'public/jquery.dataTables.min.js', ['jquery']);
        wp_enqueue_script('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.min.js', ['jquery']);
        wp_enqueue_script('jquery.unveil', ZKWP_TOOLS_URL . 'public/jquery.unveil.js', ['jquery']);
        wp_enqueue_style('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.css');
    }
}
