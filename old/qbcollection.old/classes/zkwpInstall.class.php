<?php

class zkwpInstall
{
    /**
     * @var wpdb
     */
    private $db;
    private $collections;

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->prefix = $wpdb->prefix . 'zkwp_';
        $this->collections = $collections;
    }

    public function install() {
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
        $this->runUpdates();
    }

    private function createTable($name, array $columns) {
        $sql = 'CREATE TABLE ' . $this->prefix . $name . ' (
                id int(5) NOT NULL AUTO_INCREMENT,
                ' . implode("\n", $columns) . '
                active int(1) NOT NULL default 1,
                PRIMARY KEY  (id)
                ) ' . $this->getCharset() . ';';
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private function alterTable($name, $alteration, $option) {
        $sql = 'ALTER TABLE ' . $this->prefix . $name . ' ' . $alteration;
        $this->customQuery($sql, $option);
    }

    private function fillTable($name, $fields) {
        $sql = 'INSERT INTO ' . $this->prefix . $name . ' (`' . implode('`,`', $fields) . '`) '
                . ' VALUES ' . file_get_contents(ZKWP_TOOLS_DIR . 'resources/' . $name . '.sql');
        $this->customQuery($sql, 'zkwp_db_fill_' . $name);
    }

    private function customQuery($sql, $option) {
        if (!get_option($option)) {
            if ($this->db->query($sql)) {
                update_option($option, true);
            }
        }
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

    /* updates - for each update create new function, place it right before runUpdates,
     * and add it to runUpdates */

    private function update0() {
        $this->fillTable('breed', ['name_pl', 'name_en']);
        $this->fillTable('group', ['name_pl']);
        $this->fillTable('fee', ['name', 'description', 'value']);
        $this->fillTable('club', ['name', 'leader', 'support', 'duty']);
        $this->fillTable('kennel', ['name', 'description', 'breed_id', 'address', 'city', 'postalcode', 'contact', 'phone', 'email', 'website', 'image']);
        $alter = 'ADD CONSTRAINT kennel_breed_id FOREIGN KEY (breed_id) REFERENCES ' . $this->prefix . 'breed' . '(id)';
        $this->alterTable('kennel', $alter, 'zkwp_db_kennel_altered');

        $alter = 'ADD CONSTRAINT hound_breed_id FOREIGN KEY (breed_id) REFERENCES ' . $this->prefix . 'breed' . '(id)';
        $this->alterTable('hound', $alter, 'zkwp_db_hound_altered');
    }

    private function update1() {
    }

    private function runUpdates() {
        $this->update0();
        //$this->update1();
    }
}
