<?php

class qbWpListsShortcode
{
    private $singleShowPresented = false;
    private $selectedId = -1;

    public function __construct($collections)
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
        $this->getSelectedId();
        $this->registerShortcodes();
    }

    public function shortcodeCallback($atts)
    {
        global $wpdb;
        $attributes = shortcode_atts(['itemid' => false, 'id' => false], $atts);
        $id = $attributes['id'];
        $itemId = $attributes['itemid'];
        $this->enqueueResources();
        $shortcodeQueries = $this->collections[$id]['shortcode'];
        $datasExtras = [];

        if ($itemId) {
            $datas = $wpdb->get_results($shortcodeQueries['item'] . $itemId);
            if (array_key_exists('item_extra', $shortcodeQueries)) {
                $datasExtras = $wpdb->get_results($shortcodeQueries['item_extra'] . $itemId);
            }
        } else {
            $datas = $wpdb->get_results($shortcodeQueries['list']);
        }
        if (!isset($this->view)) {
            $this->view = qbWpListsLoadClass('ShortcodeView', true);
        }

        ob_start();

        if ($itemId) {
            $this->view->render($id . '.item', $datas, $datasExtras);
        } else {
            $this->view->render($id, $datas);
        }

        return ob_get_clean();
    }

    private function getSelectedId()
    {
        $id = filter_input(INPUT_GET, 'qb-wp-lists-key');
        $this->selectedId = is_numeric($id) ? $id : -1;
    }

    private function registerShortcodes()
    {
        add_shortcode(QBWPLISTS_ID . 'shortcode', [$this, 'shortcodeCallback']);
    }

    private function enqueueResources()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery.datatables', QBWPLISTS_URL . 'public/jquery.dataTables.min.js', ['jquery']);
        wp_enqueue_script(QBWPLISTS_ID, QBWPLISTS_URL . 'public/qb_wp_lists.min.js', ['jquery']);
        wp_enqueue_script('jquery.unveil', QBWPLISTS_URL . 'public/jquery.unveil.js', ['jquery']);
        wp_enqueue_style(QBWPLISTS_ID, QBWPLISTS_URL . 'public/qb_wp_lists.css');
    }
}
