<?php

class qbWpListsDatabase
{
    /**
     * @var wpdb
     */
    private $db;
    private $charset;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->db->show_errors();
        $this->charset = false;
    }

    public function getList($table)
    {
        return $this->db->get_results('SELECT * FROM ' . QBWPLISTS_TABLE . $table . ' ORDER BY id');
    }

    public function getItem($table, $id)
    {
        $item = $this->db->get_row('SELECT * FROM ' . QBWPLISTS_TABLE . $table . ' WHERE id = ' . $id);
        if (is_null($item)) {
            return false;
        }

        return $item;
    }

    public function save($table, $values)
    {
        if (isset($values['id']) && is_numeric($values['id'])) {
            return $this->update($table, $values);
        } else {
            return $this->add($table, $values);
        }
    }

    public function delete($table, $id)
    {
        return $this->db->delete(QBWPLISTS_TABLE . $table, ['id' => $id]);
    }

    public function custom($sqlQuery)
    {
        return $this->db->get_results($sqlQuery);
    }

    private function add($table, $values)
    {
        $nonempty = [];
        foreach ($values as $key => $val) {
            if (mb_strlen($val) > 0) {
                $nonempty[$key] = $val;
            }
        }

        return $this->db->insert(QBWPLISTS_TABLE . $table, $nonempty);
    }

    private function update($table, $values)
    {
        return $this->db->update(QBWPLISTS_TABLE . $table, $values, ['id' => $values['id']]);
    }

    private function createTable($name, array $columns)
    {
        $sql = 'CREATE TABLE ' . QBWPLISTS_TABLE . $name . ' (
                id int(5) NOT NULL AUTO_INCREMENT,
                ' . implode("\n", $columns) . '
                active int(1) NOT NULL default 1,
                PRIMARY KEY  (id)
                ) ' . $this->getCharset() . ';';
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private function getCharset()
    {
        if (!$this->charset) {
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

            $this->charset = $charset_collate;
        }

        return   $this->charset;
    }
}
