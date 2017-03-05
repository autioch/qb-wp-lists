<?php

/* TODO rewrite, handle delete and save and edit buttons on edit/add page */

class qbColPage {

    /**
     *
     * @var qbColDatabase 
     */
    private $db;

    /**
     *
     * @var qbColMessage 
     */
    private $message;

    /**
     *
     * @var qbColForm
     */
    private $form;

    public function __construct($collection) {
        $this->collection = $collection;
        $this->listColumns = $collection['listColumns'];
        $this->id = $collection['id'];
        $this->message = qbColLoadClass('qbColMessage', true);
        $this->db = qbColLoadClass('qbColDatabase', true, $collection);
    }

    public function getPage() {
        $action = filter_input(INPUT_GET, 'action');

        switch ($action) {
            case 'add':
            case 'edit':
                $this->editAction();
                break;
            case 'delete':
                $this->deleteAction();
                break;
            default:
                $this->listAction();
        }
    }

    private function listAction() {
        $itemList = $this->db->getList($this->id);
        include QBCOL_DIR . 'views/qbColPage.list.view.php';
    }

    private function editAction() {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            $item = $this->dbGetItem($id);
        }
        if (!$item) {
            return;
        }

        $form = qbColLoadClass('qbColForm', true, $this->collection);
        if ($form->validate()) {
            $this->db->save($form->getAll());
            return $this->listAction();
        }

        if ($form->sent) {
            $this->addMessage('Proszę poprawnie wypełnić wszystkie pola');
        }

        include QBCOL_DIR . 'views/qbColPage.edit.view.php';
        $form->render();
    }

    private function deleteAction() {
        $id = filter_input(INPUT_GET, 'id');
        if ($this->db->delete($this->id, $id)) {
            $this->message->add('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
        } else {
            $this->message->add('Pomyślnie usunięto rekord.', 'success');
        }
        $this->listAction();
    }

}
