<?php

return [
    'title' => 'Pomoc',
    'id' => 'support',
    'fields' => [
        'question' => ['title' => 'Pytanie', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'answer' => ['title' => 'Odpowiedź', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'link' => ['title' => 'Strona', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
    ],
    'listColumns' => [
        'question' => 'Pytanie',
        'link' => 'Strona',
    ],
    'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'support',
    'shortcode' => [
      'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'support',
      'item' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'support WHERE id=',
    ],
];
