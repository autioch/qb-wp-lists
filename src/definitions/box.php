<?php

return [
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
];
