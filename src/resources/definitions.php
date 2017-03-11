<?php

return [
    'encyclopedia' => [
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
    ],
    'support' => [
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
    ],
    'product' => [
        'title' => 'Produkty',
        'id' => 'product',
        'fields' => [
            'label' => ['title' => 'Nazwa', 'required' => true],
            'description_short' => ['title' => 'Krótki opis', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
            'description' => ['title' => 'Opis', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
            'image' => ['title' => 'Zdjęcie opakowania'],
            'link' => ['title' => 'Strona', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
            'composition' => ['title' => 'Skład', 'required' => true, 'db' => 'text', 'form' => 'textarea'],
        ],
        'listColumns' => [
            'label' => 'Nazwa',
            'description_short' => 'Krótki opis',
        ],
        'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'product',
        'shortcode' => [
          'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'product',
          'item' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'product WHERE id=',
        ],
    ],
    'package' => [
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
    ],
    'box' => [
        'title' => 'Pudełka',
        'id' => 'box',
        'fields' => [
            'product_id' => ['title' => 'Produkt', 'db' => 'int(5)', 'form' => 'select', 'required' => true],
            'package_id' => ['title' => 'Opakowanie', 'db' => 'int(5)', 'form' => 'select', 'required' => true],
            'price' => ['title' => 'Cena w zł'],
            'description' => ['title' => 'Opis', 'db' => 'text', 'form' => 'textarea'],
        ],
        'listColumns' => [
            'product_label' => 'Produkt',
            'package_label' => 'Opakowanie',
            'price' => 'Cena w zł',
            'description' => 'Opis',
        ],
        'list' => 'SELECT box.*, pro.label AS product_label, pack.label AS package_label ' .
                  'FROM ' . QBWPLISTS_TABLE . 'box box ' .
                  'LEFT JOIN ' . QBWPLISTS_TABLE . 'product pro ON box.product_id = pro.id ' .
                  'LEFT JOIN ' . QBWPLISTS_TABLE . 'package pack ON box.package_id = pack.id',
        'shortcode' => [
          'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'box',
          'item' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'box WHERE id=',
        ],
    ],
];
