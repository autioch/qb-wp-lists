<?php

include './__formWrapper.php';



class qbWpListsAdminControl
{
    protected $db;
    protected $messages;

    public function __construct()
    {
        $this->id = 'definitions';
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
        $form = $this->getForm();
        if ($form->validate()) {
            $this->saveItem($form->getAll());
            $this->renderList();
        } else {
            if ($form->sent) {
                $this->messages->add('Proszę poprawnie wypełnić wszystkie pola');
                $form->stripSlashes();
            }

            $this->renderHeader($mode == 'edit' ? ' - Edycja' : ' - Dodawanie');
            $form->render();
        }
    }

    public function saveItem($values)
    {
        if (isset($values['id']) && is_numeric($values['id'])) {
            $this->db->update($this->id, $values);
            $this->messages->add('Pomyślnie zmieniono rekord.', 'success');
        } else {
            $nonempty = [];

            foreach ($values as $key => $val) {
                if (mb_strlen($val) > 0) {
                    $nonempty[$key] = $val;
                }
            }
            $this->db->add($this->id, $nonempty);
            $this->messages->add('Pomyślnie dodano rekord.', 'success');
        }
        /* TODO We have to update the database structure. */
    }

    public function deleteItem()
    {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            if (false === $this->db->delete($this->id, $id)) {
                $this->messages->add('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
            } else {
                $this->messages->add('Pomyślnie usunięto rekord.', 'success');
            }
        }
        $this->renderList();
    }

    public function renderList()
    {
        $itemList = $this->db->getList($this->id);
        $this->renderHeader(' (', count($itemList), ')');

        include qbWpListsFindTemplate('adminPage');
    }

    private function renderHeader($subtitle)
    {
        echo '<h3>Definitions' ,$subtitle ,'</h3>';
        echo  $this->messages->show();
    }

    private function getForm()
    {
        qbWpListsLoadClass('Form');

        $isEdit = false;
        $id = filter_input(INPUT_GET, 'id');

        if (is_numeric($id)) {
            $item = $this->db->getItem($this->table, $id);
            if (!is_null($item)) {
                $form->add_hidden('id', 'id', $item->id);
                $isEdit = true;
            }
        }

        $target = '?page=' . $this->id. '&action=' . ($isEdit ? 'edit&id=' . $item->id : 'add');

        $form = new qbWpListsForm('qbca_form', $target, 'post');
        /* TODO Define the fields. They should be the same as the database definition. */

        $form->add_submit('submit', 'Zapisz');

        return $form;
    }
}
