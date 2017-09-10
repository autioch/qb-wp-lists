<?php


return [
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
      'item_extra' => 'SELECT box.*, pro.label AS product_label, pack.weight AS package_weight, pack.label AS package_label ' .
                'FROM ' . QBWPLISTS_TABLE . 'box box ' .
                'LEFT JOIN ' . QBWPLISTS_TABLE . 'product pro ON box.product_id = pro.id ' .
                'LEFT JOIN ' . QBWPLISTS_TABLE . 'package pack ON box.package_id = pack.id WHERE pro.id=',
    ],
];
