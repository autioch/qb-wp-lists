<?php

return [
    'contact' => [
        'title' => 'Kontakt',
        'id' => 'contact',
        'submitLabel' => 'Wyślij',
        'fields' => [
            'name' => ['title' => 'Nazwa', 'required' => true],
            'value' => ['title' => 'Wartość', 'required' => true],
            'description' => ['title' => 'Opis'],
        ],
        'sendto' => [
          'autioch@gmail.com',
        ],
    ],
    'order' => [
        'confirmation' => 'Dziękujemy za złożenie zamówienia. Na podany adres email zostało wysłane potwierdzenie.',
        'id' => 'order',
        'submitLabel' => 'Zamów',
        'fields' => [
            'product' => ['title' => 'Produkt', 'form' => 'select', 'required' => true, 'get_param' => 'product_id'],
            'box' => ['title' => 'Opakowanie', 'form' => 'select', 'required' => true],
            'amount' => ['title' => 'Ilość opakowań', 'form' => 'select', 'required' => true, 'value' => '1'],
            'payment' => ['title' => 'Sposób zapłaty', 'form' => 'select', 'required' => true, 'value' => 'cash'],
            'delivery' => ['title' => 'Sposób dostawy', 'form' => 'select', 'required' => true, 'value' => 'personal'],
            'notes' => ['title' => 'Uwagi dodatkowe', 'form' => 'textarea'],
            'invoice' => ['title' => 'Faktura', 'form' => 'select', 'required' => true, 'value' => 'no'],
            'phone' => ['title' => 'Numer telefonu', 'form' => 'number', 'required' => true, 'error' => 'Proszę wprowadzić numer telefonu'],
            'email' => ['title' => 'Email', 'form' => 'email', 'required' => true],
        ],
        'fieldOptions' => [
          'invoice' => ['yes' => 'Tak', 'no' => 'Nie'],
          'payment' => ['cash' => 'Gotówka przy odbiorze', 'transfer' => 'Przelew'],
          'delivery' => ['personal' => 'Odbiór osobisty', 'mail' => 'Poczta', 'courier' => 'Kurier'],
          'amount' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'],
          'product' => 'SELECT id, label FROM ' . QBWPLISTS_TABLE . 'product',
          'box' => 'SELECT pack.id AS option_key, CONCAT(pack.label, \' (\', pack.weight,  \'g)\') AS option_value ' .
                    'FROM ' . QBWPLISTS_TABLE . 'box box ' .
                    'LEFT JOIN ' . QBWPLISTS_TABLE . 'product pro ON box.product_id = pro.id ' .
                    'LEFT JOIN ' . QBWPLISTS_TABLE . 'package pack ON box.package_id = pack.id WHERE pro.id=',
        ],
        'email' => [
          'title' => 'Kemiplast - zamówienie',
          'header' => 'Potwierdzenie złożenia zamówienia.',
          'footer' => 'Data wysłania zgłoszenia: ' . date('Y.m.d, h:i'),
          'from' => 'From: Kemiplast <no-reply@kemiplast.pl>',
          'sendto' => [
            'autioch@gmail.com',
          ],
        ],
    ],
];
