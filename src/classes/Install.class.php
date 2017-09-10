<?php

class qbWpListsInstall
{
    private $db;
    private $collections;

    public function __construct($collections)
    {
        $this->collections = $collections;
        $this->db = qbWpListsLoadClass('Database', true);
    }

    public function install()
    {
        foreach ($this->collections as $id => $collection) {
            $columns = [];
            foreach ($collection['fields'] as $name => $field) {
                $col = '`' . $name . '`' . ' ' . (array_key_exists('db', $field) ? $field['db'] : 'varchar(128)');

                if (array_key_exists('required', $field) && $field['required']) {
                    $col .= ' NOT NULL';
                }

                $columns[] = $col . ',';
            }
            $this->db->createTable($id, $columns);
        }
    }
}
