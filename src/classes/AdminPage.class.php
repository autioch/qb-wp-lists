<?php

qbWpListsLoadClass('AdminPageView');

class qbWpListsAdminPage
{
    protected $db;
    protected $table;
    protected $page;
    protected $fields;
    protected $messages;

    public function __construct($collection)
    {
        $this->table = $collection['id'];
        $this->page = QBWPLISTS_ID . $collection['id'];
        $this->fields = $collection['fields'];
        $this->list = $collection['list'];

        $this->db = qbWpListsLoadClass('Database', true);
        $this->messages = qbWpListsLoadClass('AdminMessage', true);
        $this->view = new qbWpListsAdminPageView($collection, $this->messages);
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
        if (isset($_POST['qbca_form']) && isset($_POST['qbca_form']['delete'])) {
            return $this->deleteItem();
        }
        $form = $this->getForm();
        if ($form->validate()) {
            $this->saveItem($form->getAll());
            if (isset($_POST['qbca_form']) && isset($_POST['qbca_form']['submitreturn'])) {
                $form->stripSlashes();
                $this->view->renderForm($form, $mode);

                return;
            } else {
                $this->renderList();
            }
        } else {
            if ($form->sent) {
                $this->messages->add('Proszę poprawnie wypełnić wszystkie pola');
                $form->stripSlashes();
            }

            $this->view->renderForm($form, $mode);
        }
    }

    public function saveItem($values)
    {
        if (isset($values['id']) && is_numeric($values['id'])) {
            $this->db->update($this->table, $values);
            $this->messages->add('Pomyślnie zmieniono rekord.', 'success');
        } else {
            $nonempty = [];

            foreach ($values as $key => $val) {
                if (mb_strlen($val) > 0) {
                    $nonempty[$key] = $val;
                }
            }
            $this->db->add($this->table, $nonempty);
            $this->messages->add('Pomyślnie dodano rekord.', 'success');
        }
    }

    public function renderList()
    {
        $itemList = $this->db->custom($this->list);
        $this->view->renderList($itemList);
    }

    public function deleteItem()
    {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            if (false === $this->db->delete($this->table, $id)) {
                $this->messages->add('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
            } else {
                $this->messages->add('Pomyślnie usunięto rekord.', 'success');
            }
        }
        $this->renderList();
    }

    public function getVal($valueId)
    {
        if (isset($this->item) && !is_null($this->item)) {
            return $this->item->$valueId;
        }

        return '';
    }

    public function getForm()
    {
        $target = '?page=' . $this->page . '&action=';

        if ($this->getItem() && $this->getVal('id')) {
            $target .= 'edit&id=' . $this->getVal('id');
            $state = 'edit';
        } else {
            $target .= 'add';
            $state = 'add';
        }

        $form = new qbWpListsForm('qbca_form', $target, 'post');
        foreach ($this->fields as $key => $val) {
            $type = array_key_exists('form', $val) ? $val['form'] : 'text';
            $req = array_key_exists('required', $val) ? $val['required'] : false;
            switch ($type) {
                case 'select':
                    $form->add_select($key, $val['title'], $this->getSelectValues($key), '', $req, $this->getVal($key));
                    break;
                // case 'radio':
                //     $form->add_radio($key, $val['title'], $this->queries[$key . '_options'], '', $req, $this->getVal($key));
                //     break;
                case 'email':
                    $form->add_email($key, $val['title'], '', '', $req, $this->getVal($key));
                    break;
                case 'email':
                    $form->add_email($key, $val['title'], '', '', $req, $this->getVal($key));
                    break;
                default:
                    $method = 'add_' . $type;
                    $form->$method($key, $val['title'], '', $req, $this->getVal($key));
                    break;
            }
        }

        $form->add_checkbox('active', 'Aktywny', '', false, $this->getVal('active'));

        if ($this->getVal('id')) {
            $form->add_hidden('id', 'id', $this->getVal('id'));
        }

        $form->add_submit('submit', 'Zapisz');
        $form->add_submit('submitreturn', 'Zapisz i wróc do edycji');

        if ($state == 'edit') {
            $form->add_submit('delete', 'Usuń');
        }

        return $form;
    }

    public function getItem()
    {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            return $this->db->getItem($this->table, $id);
        }

        return false;
    }

    public function getSelectValues($key)
    {
        $result = $this->db->custom('SELECT id, label FROM ' . QBWPLISTS_TABLE . mb_substr($key, 0, -3) . ' ORDER BY label', ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
