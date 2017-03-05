<?php

/* TODO Finish update mechanism. */

class qbWpListsUpdate
{
    /**
     * @var wpdb
     */
    private $db;
    private $collections;
    private $alterKey = QBWPLISTS_ID . 'alter_';

    public function __construct($collections)
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $collections;
    }

    public function update()
    {
        $this->runUpdates();
    }

    private function alterTable($name, $alteration, $updateKey)
    {
        if (!get_option($updateKey)) {
            $sql = 'ALTER TABLE ' . QBWPLISTS_TABLE . $name . ' ' . $alteration;
            $this->updateQuery($sql, $updateKey);
        }
    }

    private function fillTable($name, $fields, $updateKey)
    {
        if (!get_option($updateKey)) {
            $sql = 'INSERT INTO ' . QBWPLISTS_TABLE . $name . ' (`' . implode('`,`', $fields) . '`) '
                . ' VALUES ' . file_get_contents(QBWPLISTS_DIR . 'resources/' . $name . '.sql');
            $this->updateQuery($sql, $updateKey);
        }
    }

    private function updateQuery($sql, $updateKey)
    {
        if ($this->db->query($sql)) {
            update_option($updateKey, true);
        }
    }

    private function getCharset()
    {
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

    private function update0()
    {
        $this->fillTable('breed', ['name_pl', 'name_en']);
        $this->fillTable('group', ['name_pl']);
        $this->fillTable('fee', ['name', 'description', 'value']);
        $this->fillTable('club', ['name', 'leader', 'support', 'duty']);
        $this->fillTable('kennel', ['name', 'description', 'breed_id', 'address', 'city', 'postalcode', 'contact', 'phone', 'email', 'website', 'image']);
        $alter = 'ADD CONSTRAINT kennel_breed_id FOREIGN KEY (breed_id) REFERENCES ' . QBWPLISTS_TABLE . 'breed' . '(id)';
        $this->alterTable('kennel', $alter, 'zkwp_db_kennel_altered');

        $alter = 'ADD CONSTRAINT hound_breed_id FOREIGN KEY (breed_id) REFERENCES ' . QBWPLISTS_TABLE . 'breed' . '(id)';
        $this->alterTable('hound', $alter, 'zkwp_db_hound_altered');
    }

    private function update1()
    {
    }

    private function runUpdates()
    {
        // $this->update0();
        //$this->update1();
    }
}
