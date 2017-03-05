<?php

class qbWpListsInstall
{
    /**
     * @var wpdb
     */
    private $db;
    private $collections;
    private $alterKey = 'qb_wp_lists_alter_';

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
    }

    public function install() {
        $this->charset = $this->getCharset();
        foreach ($this->collections as $id => $collection) {
            $columns = [];
            foreach ($collection['fields'] as $name => $field) {
                $col = $name . ' ' . (array_key_exists('db', $field) ? $field['db'] : 'varchar(128)');

                if (array_key_exists('required', $field) && $field['required']) {
                    $col .= ' NOT NULL';
                }

                $columns[] = $col . ',';
            }
            $this->createTable($id, $columns);
        }
        $this->createTable('contact_nonces', ['nonce varchar(128),']);
    }

    private function createTable($name, array $columns) {
        $sql = 'CREATE TABLE ' . QBWPLISTS_TABLE . $name . ' (
                id int(5) NOT NULL AUTO_INCREMENT,
                ' . implode("\n", $columns) . '
                active int(1) NOT NULL default 1,
                PRIMARY KEY  (id)
                ) ' . $this->charset . ';';
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private function getCharset() {
        $charset_collate = '';

        if (method_exists($this->db, 'get_charset_collate')) {
            $charset_collate = $this->db->get_charset_collate();
        } else {
            if (!empty($this->db->charset)) {
                $charset_collate = "DEFAULT CHARACTER SET $this->db->charset";
            }
            if (!empty($this->db->collate)) {
                $charset_collate .= " COLLATE $this->db->collate";
            }
        }

        return $charset_collate;
    }
}
