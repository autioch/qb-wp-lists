<?php



class qbWpListsInstall
{
    private $db;
    private $collections;

    public function __construct($collections)
    {
        $this->collections = $collections;
        $this->db = qbWpListsLoadClass('Database', true);
        $this->tables = include './install.php';
    }

    public function install()
    {
        foreach ($this->tables as $id => $definition) {
            $columns = [];
            foreach ($definition as $name => $field) {
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
