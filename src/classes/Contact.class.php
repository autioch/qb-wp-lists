<?php

class qbWpListsContact
{
    /**
     * @var qbWpListsForm
     */
    private $form = null;

    /**
     * @var array
     */
    private $collection;

    /**
     * @var wpdb
     */
    private $db;

    /**
     * @var array
     */
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
            return '<br>Dziękujemy, zgłoszenie zostało wysłane do administracji.';
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

    /* TODO Make this part more generic */
    private function sendEmail()
    {
        if (!$this->validateNonce()) {
            return;
        }
        $title = 'Kemiplast - ' . $this->collection['title'] . ' (zgłoszenie)';

        $content = 'Zostało wysłane zgłoszenie.<br/><br/><table>';
        foreach ($this->form->fields as $field) {
            if ($field['id'] != 'antybot') {
                $content .= '<tr><td>' . $field['label'] . '</td><td>' . $field['value'] . '</td>';
            }
        }
        $content .= '<tr><td>Nonce (dev)</td><td>' . $this->form->get('nonce') . '</td>';
        $content .= '</table><br/><br/>Data wysłania zgłoszenia: ' . date('Y.m.d, h:i:s');

        $headers = [];
        $headers[] = 'From: Kemiplast <no-reply@kemiplast.pl>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        /*
         * Wysyłamy maila na każdy adres wpisany w tablicy
         * "sendto" w resources/forms.php
         */
        foreach ($this->collection['sendto'] as $mail) {
            wp_mail($mail, $title, $content, $headers);
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
            //$this->form->add_text($key, $val['title'], '', array_key_exists('required', $val));
            $type = array_key_exists('form', $val) ? $val['form'] : 'text';
            switch ($type) {
                case 'textarea':
                    $this->form->add_textarea($key, $val['title'], '', '', array_key_exists('required', $val));
                    break;
                case 'email':
                    $this->form->add_email($key, $val['title'], '', '', array_key_exists('required', $val));
                    break;
                case 'number':
                    $this->form->add_number($key, $val['title'], '', array_key_exists('required', $val));
                    break;
                case 'select':
                    $this->form->add_select($key, $val['title'], $this->getFieldOptions($key), '', array_key_exists('required', $val));
                    break;
                default:
                    $this->form->add_text($key, $val['title'], '', array_key_exists('required', $val));
                    break;
            }
        }
        $this->form->add_hidden('collection', 'collection', $this->collection['id']);
        $this->form->add_hidden('nonce', 'nonce', $this->getNonce(), false);
        $this->form->add_submit('submit', $this->collection['submitLabel']);

        return $this->form;
    }

    private function getFieldOptions($key)
    {
        if (!array_key_exists('fieldOptions', $this->collection)) {
            return [];
        }
        if (!array_key_exists($key, $this->collection['fieldOptions'])) {
            return [];
        }
        $options = $this->collection['fieldOptions'];
        if (is_array($options)) {
            return $options;
        }
        $result = $this->db->get_results($options, ARRAY_N);
        $list = [];
        foreach ($result as $val) {
            $list[$val[0]] = $val[1];
        }

        return $list;
    }
}
