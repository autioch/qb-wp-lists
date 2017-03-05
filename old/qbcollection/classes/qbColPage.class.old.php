<?php

/* TODO rewrite, handle delete and save and edit buttons on edit/add page */

class qbColPage {

    public function __construct($collection) {
        global $wpdb;
        $this->db = $wpdb;
        $this->table = QBCOL_TABLE . $collection['id'];
        $this->page = 'qbcol_' . $collection['id'];
        $this->title = $collection['title'];
        $this->fields = $collection['fields'];
        /* show records list */
        $this->list = $collection['list'];
        $this->listColumns = $collection['listColumns'];
        /* forms */
        $this->form = null;
        $this->item = null;
    }

    public function getPage() {
        $action = filter_input(INPUT_GET, 'action');
        $id = filter_input(INPUT_GET, 'id');

        ob_start();

        switch ($action) {
            case 'add':
            case 'edit':
                $action = $this->editItem($id);
                break;
            case 'delete':
                $this->dbDeleteItem($id);
                $this->getItemList();
                $action = 'list';
                break;
            default:
                $this->getItemList();
                break;
        }
        $content = ob_get_clean();
        $this->showTitle($action);
        $this->showMessages();
        echo $content;
    }

    private function showTitle($action) {
        echo '<h3 class="zkwp-tools-title">', $this->title;
        switch ($action) {
            case 'list' :
                echo ' (', $this->db->num_rows, ') ';
                break;
            case 'add' :
                echo ' - dodawanie';
                break;
            case 'edit' :
                echo ' - edycja';
                break;
        }
        echo '</h3>';
    }

    private function editItem($id) {
        $item = null;
        if (is_numeric($id)) {
            $item = $this->dbGetItem($id);
        }

        $form = $this->getForm($item);
        if ($form->validate()) {
            $this->dbSaveItem($form->getAll());
            $this->showItemList();
            return 'list';
        } else {
            if ($form->sent) {
                $this->addMessage('Proszę poprawnie wypełnić wszystkie pola');
                $form->stripSlashes();
            }
            $form->render();
            return is_null($item) ? 'add' : 'edit';
        }
    }

    /* Form functions */

    /* Database functions */

    private function dbSaveItem($values) {
        if (isset($values['id']) && is_numeric($values['id'])) {
            return $this->dbUpdateItem($values);
        } else {
            return $this->dbAddItem($values);
        }
    }

    private function dbAddItem($values) {
        $nonempty = array();
        foreach ($values as $key => $val) {
            if (strlen($val) > 0) {
                $nonempty[$key] = $val;
            }
        }
        if (false === $this->db->insert($this->table, $nonempty)) {
            $this->addMessage('Wystąpił błąd podczas dodawania rekordu.');
        } else {
            $this->addMessage('Pomyślnie dodano rekord.', 'success');
        }
    }

    private function dbUpdateItem($values) {
        /* TODO
         * compare $values with definition of table from collection, 
         * set NULL for cols that are not present i $values.
         */
        if (false === $this->db->update($this->table, $values, array('id' => $values['id']))) {
            $this->addMessage('Wystąpił błąd podczas aktualizacji rekordu.');
        } else {
            $this->addMessage('Pomyślnie zmieniono rekord.', 'success');
        }
    }

    private function dbGetItem($id) {
        $item = $this->db->get_row('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
        if (is_null($item)) {
            $this->addMessage('Nie znaleziono rekordu o id = ' . $id . '.');
            return null;
        } else {
            return $item;
        }
    }

    private function dbDeleteItem($id) {
        if (false === $this->db->delete($this->table, array('id' => $id))) {
            $this->addMessage('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
        } else {
            $this->addMessage('Pomyślnie usunięto rekord.', 'success');
        }
    }

}
