<?php

return [
    'title' => 'Opakowania',
    'id' => 'package',
    'fields' => [
        'label' => ['title' => 'Nazwa', 'required' => true],
        'weight' => ['title' => 'Waga w gramach', 'required' => true],
        'description' => ['title' => 'Opis', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
    ],
    'listColumns' => [
        'label' => 'Nazwa',
        'weight' => 'Waga w gramach',
        'description' => 'Opis',
    ],
    'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'package',
    'shortcode' => [
      'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'package',
      'item' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'package WHERE id=',
    ],
];
