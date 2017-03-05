<?php

class qbColMessage {

    public function add($message, $type = 'error') {
        if (empty($this->messages)) {
            $this->messages = array();
        }
        $this->messages[] = array('type' => $type, 'message' => $message);
    }

    public function show() {
        if (count($this->messages) > 0) {
            $result = '';
            foreach ($this->messages as $message) {
                $result .= '<div class="zkwp-tools-message zkwp-' . $message['type'] . '">' . $message['message'] . '</div>';
            }
            return $result;
        }
        return '';
    }

}
