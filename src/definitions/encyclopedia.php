<?php

return [
    'title' => 'Encyklopedia traw',
    'id' => 'encyclopedia',
    'fields' => [
        'species' => ['title' => 'Gatunek', 'required' => true],
        'label' => ['title' => 'Nazwa', 'required' => true],
        'label_latin' => ['title' => 'Nazwa łacińska', 'required' => true],
        'description_short' => ['title' => 'Krótka charakterystyka', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'description' => ['title' => 'Charakterystyka', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'link' => ['title' => 'Strona', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'usage' => ['title' => 'Wykorzystanie', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        'source' => ['title' => 'Źródło', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
    ],
    'listColumns' => [
        'species' => 'Gatunek',
        'label' => 'Nazwa',
        'link' => 'Strona',
        'description_short' => 'Krótki opis',
    ],
    'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'encyclopedia',
    'shortcode' => [
      'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'encyclopedia',
      'item' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'encyclopedia WHERE id=',
    ],
];
