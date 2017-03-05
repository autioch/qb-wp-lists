<?php

/* One form per page */

class zkwpContactForm {

    /**
     * @var qbWebForm 
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
    private $formId = 'zkwp_tools_contact_form';
    private $nonceError = false;

    public function __construct($forms) {
        global $wpdb;
        $this->db = $wpdb;
        $this->collections = $forms;

        add_action('plugins_loaded', array($this, 'sniffForm'));
        add_shortcode('zkwp_tools_contact', array($this, 'shortcodeCallback'));
    }

    public function sniffForm() {
        $sent = filter_input(INPUT_POST, $this->formId, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if ($sent && $sent['collection']) {
            $this->setForm($sent['collection']);
            if ($this->form->validate()) {
                $this->sendEmail();
            }
        }
    }

    public function shortcodeCallback($atts) {
        if (filter_input(INPUT_GET, 'zcfc')) {
            return '<br>Dziękujemy, zgłoszenie zostało wysłane do administracji.';
        }
        if ($this->nonceError) {
            return '<br/>Przepraszamy, wygląda na to, że ten formularz był już wysłany.'
                    . '<br/>Proszę odświeżyć stronę formularza, a następnie spróbować ponownie.';
        }

        if (is_null($this->form)) {
            $a = shortcode_atts(array('collection' => false), $atts);
            $this->setForm($a['collection']);
        }

        ob_start();
        $this->form->render();
        return ob_get_clean();
    }

    private function sendEmail() {
        if (!$this->validateNonce()) {
            return;
        }
        $title = 'ZKwP Koszalin - ' . $this->collection['title'] . ' (zgłoszenie)';

        $content = 'Zostało wysłane zgłoszenie.<br/><br/><table>';
        foreach ($this->form->fields as $field) {
            if ($field['id'] != 'antybot') {
                $content .= '<tr><td>' . $field['label'] . '</td><td>' . $field['value'] . '</td>';
            }
        }
        $content .= '<tr><td>Nonce (dev)</td><td>' . $this->form->get('nonce') . '</td>';
        $content .='</table><br/><br/>Data wysłania zgłoszenia: ' . date('Y.m.d, h:i:s');

        $headers = array();
        $headers[] = 'From: ZKwP Koszalin <no-reply@zkwp-koszalin.pl>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        wp_mail('autioch@gmail.com', $title, $content, $headers);
        wp_mail('sunan@o2.pl', $title, $content, $headers);


        header('Location: ' . get_the_permalink() . '?zcfc=' . md5('qbcontacform' . rand(1, 300)));
        exit;
    }

    private function validateNonce() {
        $nonce = $this->form->get('nonce');

        /* is nonce ok */
        if (preg_match('/[^A-Za-z0-9]/', $nonce)) {
            $this->nonceError = true;
            return false;
        }

        /* is nonce already recorded */
        if (!is_null($this->db->get_row('SELECT * FROM ' . ZKWP_TABLE . "contact_nonces WHERE nonce = '" . $nonce . "'"))) {
            $this->nonceError = true;
            return false;
        }

        /* record nonce */
        $this->db->insert(ZKWP_TABLE . 'contact_nonces', array('nonce' => $nonce));
        return true;
    }

    private function getNonce() {
        return md5('qb_zkwp' . time());
    }

    private function setForm($id) {
        $this->setCollection($id);
        $this->enqueueResources();

        $this->form = new qbWebForm($this->formId, '', 'post');
        $this->form->add_radio('record_type', 'Typ zgłoszenia', array('nowy' => 'Nowy wpis', 'aktualizacja' => 'Aktualizacja'), '', true);
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
                default:
                    $this->form->add_text($key, $val['title'], '', array_key_exists('required', $val));
                    break;
            }
        }
        $this->form->add_hidden('collection', 'collection', $this->collection['id']);
        $this->form->add_hidden('nonce', 'nonce', $this->getNonce(), false);
        $this->form->add_antybot('antybot', 'Proszę wpisać nasze miasto', 'Koszalin', 'Proszę podać, w jakim mieście znajduje się nasz oddział');
        $this->form->add_submit('submit', 'Wyślij zgłoszenie');
        return $this->form;
    }

    private function setCollection($id) {
        if ($id && array_key_exists($id, $this->collections)) {
            $this->collection = $this->collections[$id];
        } else {
            $this->collection = $this->collections['contact'];
        }
    }

    private function enqueueResources() {
        //wp_enqueue_style('zkwp_tools', ZKWP_TOOLS_URL . 'public/zkwp_tools.css');
    }

}
