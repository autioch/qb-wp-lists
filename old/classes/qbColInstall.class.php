<?php

class qbColInstall
{
    /**
     * @var wpdb
     */
    private $db;
    private $collections;
    private $charset;

    public function __construct($collections) {
        global $wpdb;
        $this->db = $wpdb;
        $this->prefix = $wpdb->prefix . 'qbcol_';
        $this->collections = $collections;
        $this->setCharset();
    }

    public function install() {
        foreach ($this->collections as $id => $collection) {
            $tableName = $this->prefix . $id;

            $columns = $this->parseFields($collection['fields']);
            $this->createTable($tableName, $columns);

            $valuesFile = ZKWP_TOOLS_DIR . 'resources/' . $id . '.sql';
            $fillColumns = array_key_exists('fillColumns', $collection) ? $collection['fillColumns'] : false;

            if (file_exists($valuesFile) && $fillColumns) {
                $this->fillTable($tableName, $fillColumns, $valuesFile);
            }
        }
    }

    private function parseFields($fields) {
        $columns = [];
        foreach ($fields as $name => $field) {
            $col = $name . ' ' . (array_key_exists('db', $field) ? $field['db'] : 'varchar(128)');
            if (array_key_exists('required', $field) && $field['required']) {
                $col .= ' NOT NULL';
            }
            $columns[] = $col . ',';
        }

        return $columns;
    }

    private function createTable($name, array $columns) {
        $sql = 'CREATE TABLE ' . $name . ' (
                id int(5) NOT NULL AUTO_INCREMENT,
                ' . implode("\n", $columns) . '
                active int(1) NOT NULL default 1,
                PRIMARY KEY  (id)
                ) ' . $this->charset . ';';
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private function fillTable($name, $columns, $valuesFile) {
        $sql = 'INSERT INTO ' . $name . ' (`' . implode('`,`', $columns) . '`) VALUES ';
        $this->db->query($sql . file_get_contents($valuesFile));
        rename($valuesFile, $valuesFile . date('Ymd.His'));
    }

    private function setCharset() {
        $this->charset = '';

        if (method_exists($this->db, 'get_charset_collate')) {
            $this->charset = $this->db->get_charset_collate();
        } else {
            if (!empty($this->db->charset)) {
                $this->charset = "DEFAULT CHARACTER SET $this->db->charset";
            }
            if (!empty($this->db->collate)) {
                $this->charset .= " COLLATE $this->db->collate";
            }
        }
    }
}
