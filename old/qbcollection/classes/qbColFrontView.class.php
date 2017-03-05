<?php

class qbColFrontView
{
    public function render($view, $query) {
        global $wpdb;
        $this->itemList = $wpdb->get_results($query);
        include $view;
    }

    /* view functions */
}
