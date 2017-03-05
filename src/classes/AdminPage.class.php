<?php

/* TODO sort out title, messages, names used overall and in views */

class qbWpListsAdminPage
{
    /**
     * @var wpdb
     */
    protected $db;
    protected $table;
    protected $page;
    protected $title;
    protected $titleBackup;
    protected $listColumns;
    protected $fields;
    protected $messages;

    public function __construct($collection)
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->db->show_errors();
        $this->title = $collection['title'];
        $this->table = QBWPLISTS_TABLE . $collection['id'];
        $this->page = QBWPLISTS_ID . $collection['id'];
        $this->fields = $collection['fields'];
        $this->listColumns = $collection['listColumns'];
        $this->list = $collection['list'];

        $this->titleBackup = $collection['title'];
        $this->messages = [];
    }

    public function getPage()
    {
        switch (filter_input(INPUT_GET, 'action')) {
            case 'add':
                $this->title .= ' - dodawanie';
                $this->editItem();
                break;
            case 'edit':
                $this->title .= ' - edycja';
                $this->editItem();
                break;
            case 'delete':
                $this->deleteItem();
                break;
            default:
                $this->getItemList();
                break;
        }
    }

    public function editItem()
    {
        if (isset($_POST['qbca_form']) && isset($_POST['qbca_form']['delete'])) {
            return $this->deleteItem();
        }
        $form = $this->getForm();
        if ($form->validate()) {
            $this->saveItem($form->getAll());
            if (isset($_POST['qbca_form']) && isset($_POST['qbca_form']['submitreturn'])) {
                $form->stripSlashes();
                echo $this->getTitle();

                return $form->render();
            } else {
                $this->getItemList();
            }
        } else {
            if ($form->sent) {
                $this->addMessage('Proszę poprawnie wypełnić wszystkie pola');
                $form->stripSlashes();
            }
            echo $this->getTitle();

            return $form->render();
        }
    }

    public function addMessage($message, $type = 'error')
    {
        $this->messages[] = ['type' => $type, 'message' => $message];
    }

    public function showMessages()
    {
        if (count($this->messages) > 0) {
            $result = '';
            foreach ($this->messages as $message) {
                $result .= '<div class="qbca-message qbca-' . $message['type'] . '">' . $message['message'] . '</div>';
            }

            return $result;
        }

        return '';
    }

    public function saveItem($values)
    {
        if (isset($values['id']) && is_numeric($values['id'])) {
            $this->db->update($this->table, $values, ['id' => $values['id']]);
            $this->addMessage('Pomyślnie zmieniono rekord.', 'success');
        } else {
            $nonempty = [];

            foreach ($values as $key => $val) {
                if (mb_strlen($val) > 0) {
                    $nonempty[$key] = $val;
                }
            }
            $this->db->insert($this->table, $nonempty);
            $this->addMessage('Pomyślnie dodano rekord.', 'success');
        }
    }

    public function getTitle()
    {
        return '<h3>' . $this->title . '</h3>' . $this->showMessages();
    }

    public function getItemList()
    {
        $this->title = $this->titleBackup;
        $itemList = $this->db->get_results($this->list);
        include qbWpListsFindTemplate('adminPage');
    }

    public function deleteItem()
    {
        $id = filter_input(INPUT_GET, 'id');
        if (is_numeric($id)) {
            if (false === $this->db->delete($this->table, ['id' => $id])) {
                $this->addMessage('Nie można usunąć wybranego rekordu. Upewnij się, że nigdzie nie jest wykorzystywany.');
            } else {
                $this->addMessage('Pomyślnie usunięto rekord.', 'success');
            }
        }
        $this->getItemList();
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
            $item = $this->db->get_row('SELECT * FROM ' . $this->table . ' WHERE id = ' . $id);
            if (!is_null($item)) {
                $this->item = $item;

                return true;
            }
        }

        return false;
    }

    public function getSelectValues($key)
    {
        $result = $this->db->get_results('SELECT id, name FROM ' . QBWPLISTS_TABLE . mb_substr($key, 0, -3) . ' ORDER BY name', ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
