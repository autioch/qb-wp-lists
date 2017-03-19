<?php

class qbWpListsContact
{
    private $form = null;
    private $collection;
    private $db;
    private $collections;
    private $nonceError = false;

    public function __construct($forms)
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->formId = QBWPLISTS_ID . 'contact';
        $this->collections = $forms;

        add_action('plugins_loaded', [$this, 'sniffForm']);
        add_shortcode(QBWPLISTS_ID . 'contact', [$this, 'shortcodeCallback']);
    }

    public function sniffForm()
    {
        $sent = filter_input(INPUT_POST, $this->formId, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if ($sent && $sent['collection']) {
            $this->setForm($sent['collection']);
            if ($this->form->validate()) {
                $this->sendEmail();
            }
        }
    }

    public function shortcodeCallback($atts)
    {
        if (filter_input(INPUT_GET, 'zcfc')) {
            return '<br>' . $this->collections[$atts['id']]['confirmation'];
        }
        if ($this->nonceError) {
            return '<br/>Przepraszamy, wygląda na to, że ten formularz był już wysłany.'
                    . '<br/>Proszę odświeżyć stronę formularza, a następnie spróbować ponownie.';
        }

        if (is_null($this->form)) {
            $this->setForm($atts['id']);
        }

        ob_start();
        $this->form->render();

        return ob_get_clean();
    }

    private function debugForm()
    {
        echo '<h1>FORM DEBUG</h1>';
        foreach ($this->form->fields as $field) {
            if ($field['id'] != 'antybot') {
                echo '<pre>#';
                echo print_r($field);
                echo '#</pre>';
            }
        }
    }

    private function serializeForm()
    {
        $rows = [];
        foreach ($this->form->fields as $field) {
            if ($field['id'] != 'antybot') {
                array_push($rows, [
                  'label' => $field['label'],
                  'value' => $field['type'] === 'select' ? $field['options'][$field['value']] : $field['value'],
                ]);
            }
        }

        return $rows;
    }

    private function sendEmail()
    {
        if (!$this->validateNonce()) {
            return;
        }
        $title = $this->collection['email']['title'];

        $content = $this->collection['email']['header'] . '<br/><br/><table>';
        $rows = $this->serializeForm();

        foreach ($rows as $row) {
            $content .= '<tr><td>' . $row['label'] . '</td><td>' . $row['value'] . '</td>';
        }

        $content .= '</table><br/><br/>' . $this->collection['email']['footer'];

        $headers = [];
        $headers[] = $this->collection['email']['from'];
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        foreach ($this->collection['email']['sendto'] as $mail) {
            wp_mail($mail, $title, $content, $headers);
        }
        foreach ($this->form->fields as $field) {
            if ($field['type'] == 'email') {
                wp_mail($field['value'], $title, $content, $headers);
            }
        }

        header('Location: ' . get_the_permalink() . '?zcfc=' . md5('qbcontacform' . rand(1, 300)));
        exit;
    }

    private function validateNonce()
    {
        $nonce = $this->form->get('nonce');

        /* is nonce ok */
        if (preg_match('/[^A-Za-z0-9]/', $nonce)) {
            $this->nonceError = true;

            return false;
        }

        /* is nonce already recorded */
        if (!is_null($this->db->get_row('SELECT * FROM ' . QBWPLISTS_TABLE . "contact_nonces WHERE nonce = '" . $nonce . "'"))) {
            $this->nonceError = true;

            return false;
        }

        /* record nonce */
        $this->db->insert(QBWPLISTS_TABLE . 'contact_nonces', ['nonce' => $nonce]);

        return true;
    }

    private function getNonce()
    {
        return md5(QBWPLISTS_ID . time());
    }

    private function setForm($id)
    {
        $this->collection = $this->collections[$id];

        $this->form = new qbWpListsForm($this->formId, '', 'post');
        if (array_key_exists('addType', $this->collection) && $this->collection['addType']) {
            $this->form->add_radio('record_type', 'Typ zgłoszenia', ['nowy' => ' Nowy wpis', 'aktualizacja' => ' Aktualizacja'], '', true);
        }
        foreach ($this->collection['fields'] as $key => $val) {
            $type = array_key_exists('form', $val) ? $val['form'] : 'text';
            $label = $val['title'];
            $defaultValue = $this->getFieldValue($val);

            $isRequired = array_key_exists('required', $val) && $val['required'] == true;
            $errorLabel = array_key_exists('error', $val) ? $val['error'] : '';

            // call_user_func_array(array($instance, "MethodName"), $myArgs);

            switch ($type) {
                case 'textarea':
                    $this->form->add_textarea($key, $label, $errorLabel, $isRequired, $defaultValue);
                    break;
                case 'email':
                    $this->form->add_email($key, $label, '', $errorLabel, $isRequired, $defaultValue);
                    break;
                case 'number':
                    $this->form->add_number($key, $label, $errorLabel, $isRequired, $defaultValue);
                    break;
                case 'select':
                    $this->form->add_select($key, $label, $this->getFieldOptions($key), $errorLabel, $isRequired, $defaultValue);
                    break;
                default:
                    $this->form->add_text($key, $label, $errorLabel, $isRequired, $defaultValue);
                    break;
            }
        }
        $this->form->add_hidden('collection', 'collection', $this->collection['id']);
        $this->form->add_hidden('nonce', 'nonce', $this->getNonce(), false);
        $this->form->add_submit('submit', $this->collection['submitLabel']);

        return $this->form;
    }

    private function getFieldValue($fieldDefinition)
    {
        if (array_key_exists('get_param', $fieldDefinition)) {
            $getParam = filter_input(INPUT_GET, $fieldDefinition['get_param']);
            if ($getParam) {
                return $getParam;
            }
        }
        if (array_key_exists('value', $fieldDefinition)) {
            return $fieldDefinition['value'];
        }

        return '';
    }

    private function getFieldOptions($key)
    {
        if (!array_key_exists('fieldOptions', $this->collection)) {
            return [];
        }
        if (!array_key_exists($key, $this->collection['fieldOptions'])) {
            return [];
        }
        $options = $this->collection['fieldOptions'][$key];
        if (is_array($options)) {
            return $options;
        }
        $query = $options;

        if (mb_substr($query, -1) == '=') {
            $query = $query . filter_input(INPUT_GET, 'product_id');
        }
        $result = $this->db->get_results($query, ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
