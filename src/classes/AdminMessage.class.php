<?php

class qbWpListsMessage
{
    public function add($message, $type = 'error')
    {
        if (empty($this->messages)) {
            $this->messages = [];
        }
        $this->messages[] = ['type' => $type, 'message' => $message];
    }

    public function show()
    {
        if (count($this->messages) > 0) {
            $result = '';
            foreach ($this->messages as $message) {
                $result .= '<div class="' . $message['type'] . '">' . $message['message'] . '</div>';
            }

            return $result;
        }

        return '';
    }
}
