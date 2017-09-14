<?php

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
        $this->renderHeader(' (', count($itemList), ')');

        include qbWpListsFindTemplate('adminPage');
    }

    private function renderHeader($subtitle)
    {
        echo '<h3>' ,$this->collection['title'] ,$subtitle ,'</h3>';
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

        $target = '?page=' . $this->page . '&action=' . ($isEdit ? 'edit&id=' . $item->id : 'add');

        $form = new qbWpListsForm('qbca_form', $target, 'post');
        foreach ($this->fields as $key => $val) {
            $type = array_key_exists('form', $val) ? $val['form'] : 'text';
            $isRequired = array_key_exists('required', $val) ? $val['required'] : false;
            switch ($type) {
                case 'select':
                    $form->add_select($key, $val['title'], $this->getSelectValues($key), '', $isRequired, $isEdit ? $item->$key : false);
                    break;
                case 'email':
                    $form->add_email($key, $val['title'], '', '', $isRequired, $isEdit ? $item->$key : false);
                    break;
                default:
                    $method = 'add_' . $type;
                    $form->$method($key, $val['title'], '', $isRequired, $isEdit ? $item->$key : false);
                    break;
            }
        }

        $form->add_checkbox('active', 'Aktywny', '', false, $isEdit ? $item->active : false);
        $form->add_submit('submit', 'Zapisz');

        return $form;
    }

    private function getSelectOptions($key)
    {
        $result = $this->db->custom('SELECT id, label FROM ' . QBWPLISTS_TABLE . mb_substr($key, 0, -3) . ' ORDER BY label', ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
