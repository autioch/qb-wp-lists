<?php

class qbColDatabase {

    /**
     *
     * @var wpdb
     */
    private $db;    
    private $collection;

    public function __construct($collection) {
        global $wpdb;
        $this -> db = $wpdb;
        $this -> prefix = $wpdb->prefix . 'qbcol_';
        $this -> collection = $collection;
    }

    public function getList($table) {
        if (array_key_exists('list', $this->collection)) {
            $sql = $this->collection['list'];
        } else {
            $sql = 'SELECT * FROM ' . $this->prefix . $table . ' ORDER BY id';
        }
        return $this->db->get_results($sql);
    }

    public function save($table, $values) {
        if (isset($values['id']) && is_numeric($values['id'])) {
            return $this->update($table, $values);
        } else {
            return $this->add($table, $values);
        }
    }

    private function add($table, $values) {
        $nonempty = array();
        foreach ($values as $key => $val) {
            if (strlen($val) > 0) {
                $nonempty[$key] = $val;
            }
        }
        return $this->db->insert($this->prefix . $table, $nonempty);
    }

    private function update($table, $values) {
        return $this->db->update($this->prefix . $table, $values, array('id' => $values['id']));
    }

    public function get($table, $id) {
        $item = $this->db->get_row('SELECT * FROM ' . $this->prefix . $table . ' WHERE id = ' . $id);
        if (is_null($item)) {
            return null;
        }
        return $item;
    }

    public function delete($table, $id) {
        return $this->db->delete($this->prefix . $table, array('id' => $id));
    }

}
