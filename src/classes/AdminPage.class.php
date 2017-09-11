<?php

include './__formWrapper.php';

class qbWpListsAdminPage
{
    protected $collection;
    protected $page;
    protected $db;
    protected $messages;

    public function __construct($collection)
    {
        $this->collection = $collection;
        $this->page = QBWPLISTS_ID . $collection['id'];

        $this->db = qbWpListsLoadClass('Database', true);
        $this->messages = qbWpListsLoadClass('AdminMessage', true);
    }

    public function getPage()
    {
        switch (filter_input(INPUT_GET, 'action')) {
            case 'add':
                $this->editItem('add');
                break;
            case 'edit':
                $this->editItem('edit');
                break;
            case 'delete':
                $this->deleteItem();
                break;
            default:
                $this->renderList();
                break;
        }
    }

    public function editItem($mode)
    {
        $form = formWrapper($item, $this->collection['fields']);
        if ($form->validate()) {
            $this->saveItem($form->getAll());
            $this->renderList();
        } else {
            if ($form->sent) {
                $this->messages->add('Proszę poprawnie wypełnić wszystkie pola');
                $form->stripSlashes();
            }

            $this->renderHeader( $mode == 'edit' ? ' - Edycja' : ' - Dodawanie');
            $form->render();
        }
    }

    public function saveItem($values)
    {
        if (isset($values['id']) && is_numeric($values['id'])) {
            $this->db->update($this->collection['id'], $values);
            $this->messages->add('Pomyślnie zmieniono rekord.', 'success');
        } else {
            $nonempty = [];

            foreach ($values as $key => $val) {
                if (mb_strlen($val) > 0) {
                    $nonempty[$key] = $val;
                }
            }
            $this->db->add($this->collection['id'], $nonempty);
            $this->messages->add('Pomyślnie dodano rekord.', 'success');
        }
    }

    public function deleteItem()
    {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            if (false === $this->db->delete($this->collection['id'], $id)) {
                $this->messages->add('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
            } else {
                $this->messages->add('Pomyślnie usunięto rekord.', 'success');
            }
        }
        $this->renderList();
    }

    public function renderList()
    {
        $itemList = $this->db->custom($this->collection['list']);
        $this->renderHeader( ' (', count($itemList), ')');

        include qbWpListsFindTemplate('adminPage');
    }

    private function renderHeader($subtitle)
    {
        echo '<h3>' ,$this->collection['title'] ,$subtitle ,'</h3>';
        echo  $this->messages->show();
    }

}
