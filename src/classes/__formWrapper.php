<?php
/*
  TODO This is temporary solution to creating form.
 */


/* Load support class for forms */
qbWpListsLoadClass('Form');

function getItem()
{
    $id = filter_input(INPUT_GET, 'id');
    if (is_numeric($id)) {
        return $this->db->getItem($this->table, $id);
    }

    return false;
}

function getVal($item, $valueId)
{
    if (isset($item) && !is_null($item)) {
        return $item->$valueId;
    }

    return '';
}

function getSelectValues($key)
{
    $result = $this->db->custom('SELECT id, label FROM ' . QBWPLISTS_TABLE . mb_substr($key, 0, -3) . ' ORDER BY label', ARRAY_N);
    $list = [];
    foreach ($result as $val) {
        $list[$val[0]] = $val[1];
    }

    return $list;
}

function formWrapper($item, $fields){
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

        return $form;
}
