<?php

class qbWpListsShortcode
{
    private $db;
    private $view;
    private $collections;

    public function __construct($collections)
    {
        $this->collections = $collections;
        $this->registerShortcodes();
        $this->db = qbWpListsLoadClass('Database', true);
    }

    public function shortcodeCallback($atts)
    {
        $this->enqueueResources();
        
        $attributes = shortcode_atts(['itemid' => false, 'id' => false], $atts);
        $id = $attributes['id'];
        $itemId = $attributes['itemid'];
        $shortcodeQueries = $this->collections[$id]['shortcode'];
        $datas = [];
        $datasExtras = [];
        $templateId = '';

        if ($itemId) {
            $templateId = $id . '.item';
            $datas = $this->db->custom($shortcodeQueries['item'] . $itemId);
            if (array_key_exists('item_extra', $shortcodeQueries)) {
                $datasExtras = $this->db->custom($shortcodeQueries['item_extra'] . $itemId);
            }
        } else {
            $templateId = $id;
            $datas = $this->db->custom($shortcodeQueries['list']);
            if (array_key_exists('list_extra', $shortcodeQueries)) {
                $datasExtras = $this->db->custom($shortcodeQueries['list_extra']);
            }
        }

        if (!isset($this->view)) {
            $this->view = qbWpListsLoadClass('ShortcodeView', true);
        }

        ob_start();

        $this->view->render($templateId, $datas, $datasExtras);

        return ob_get_clean();
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
