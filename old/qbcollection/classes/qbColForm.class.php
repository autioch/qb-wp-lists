<?php

qbColLoadClass('qbWebForm');

class qbColForm extends qbWebForm
{
    /**
     * Retrieves an array of values for every standard and hidden field.
     *
     * @return array pairs of identificators and values for each field
     */
    public function getAll() {
        $values = [];
        foreach ($this->fields as $key => $value) {
            if ($value['type'] != 'submit') {
                $values[$key] = stripslashes($this->get($key));
            }
        }
        foreach ($this->hidden as $key => $value) {
            $values[$key] = $this->hidden[$key]['value'];
        }

        return $values;
    }

    public function stripSlashes() {
        foreach ($this->fields as $key => $value) {
            $this->set($key, stripslashes($this->get($key)));
        }
        foreach ($this->hidden as $key => $value) {
            $this->set($key, stripslashes($this->get($key)));
        }
    }

    /**
     * Retrieves an array of values for every standard and hidden field.
     *
     * @return array pairs of identificators and values for each field
     */
    public function getAllDb() {
        $values = [];
        foreach ($this->fields as $key => $value) {
            if ($value['type'] != 'submit') {
                $values[$key] = stripslashes($this->get($key));
                if (mb_strlen($values[$key]) == 0) {
                    $values[$key] = 'NULL';
                }
            }
        }
        foreach ($this->hidden as $key => $value) {
            $values[$key] = $this->hidden[$key]['value'];
            if (mb_strlen($values[$key]) == 0) {
                $values[$key] = 'NULL';
            }
        }

        return $values;
    }

    private function getForm($item) {
        $target = '?page=' . $this->page . '&action=';

        if (is_null($item)) {
            $target .= 'add';
        } else {
            $target .= 'edit&id=' . $item->id;
        }

        $form = new qbWebForm('zkwp_form', $target, 'post');
        $this->fillForm($form, $item);
        $form->add_checkbox('active', 'Aktywny', '', false, $this->getItemVal($item, 'active'));

        if (is_null($item)) {
            $form->add_submit('submit', 'Dodaj');
        } else {
            $form->add_hidden('id', 'id', $item->id);
            $form->add_submit('submit', 'Zapisz');
            //$form->add_submit('submitreturn', 'Zapisz i wróc do edycji');
            //$form->add_submit('delete', 'Usuń');
        }

        return $form;
    }

    private function fillForm($form, $item) {
        foreach ($this->fields as $key => $val) {
            $type = array_key_exists('form', $val) ? $val['form'] : 'text';
            $req = array_key_exists('required', $val) ? $val['required'] : false;
            switch ($type) {
                case 'select':
                    $form->add_select($key, $val['title'], $this->getFieldOptions($key), '', $req, $this->getItemVal($item, $key));
                    break;
                case 'radio':
                    $form->add_radio($key, $val['title'], $this->getFieldOptions($key), '', $req, $this->getItemVal($item, $key));
                    break;
                case 'email':
                    $form->add_email($key, $val['title'], '', '', $req, $this->getItemVal($item, $key));
                    break;
                default:
                    $method = 'add_' . $type;
                    $form->$method($key, $val['title'], '', $req, $this->getItemVal($item, $key));
                    break;
            }
        }
    }

    private function getItemVal($item, $id) {
        if (!is_null($item) && isset($item->$id)) {
            return $item->$id;
        }

        return '';
    }

    private function getFieldOptions($key) {
        if (!array_key_exists($key, $this->fieldOptions)) {
            return [];
        }
        if (is_array($this->fieldOptions[$key])) {
            return $this->fieldOptions[$key];
        }
        $result = $this->db->get_results($this->fieldOptions[$key], ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
