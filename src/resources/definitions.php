<?php

return [
    'alliance' => [
        'title' => 'Aluchy',
        'id' => 'alliance',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'nickname' => ['title' => 'Przydomek *', 'required' => true],
            'horde_id' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'],
            'title' => ['title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'],
            'image' => ['title' => 'Zdjęcie'],
        ],
        'listColumns' => [
            'name' => 'Nazwa',
            'nickname' => 'Przydomek',
            'image' => 'Zdjęcie',
        ],
        'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'alliance',
        'shortcode' => [
          'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'alliance',
        ],
    ],
    'horde' => [
        'title' => 'Hordziaki',
        'id' => 'horde',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'nickname' => ['title' => 'Przydomek *', 'required' => true],
            'birth' => ['title' => 'Data urodzenia *', 'required' => true, 'form' => 'date'],
            'mother' => ['title' => 'Matka *', 'required' => true],
            'father' => ['title' => 'Ojciec *', 'required' => true],
            'registration' => ['title' => 'Nr rejestracji'],
            'lineage' => ['title' => 'Nr rodowodu'],
            'coat' => ['title' => 'Umaszczenie'],
            'image' => ['title' => 'Zdjęcie'],
            'test' => ['title' => 'Badania', 'db' => 'text', 'form' => 'textarea'],
            'training' => ['title' => 'Wyszkolenie', 'db' => 'text', 'form' => 'textarea'],
            'title' => ['title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'],
            'person' => ['title' => 'Właściciel'],
            'address' => ['title' => 'Adres'],
            'city' => ['title' => 'Miasto'],
            'postal_code' => ['title' => 'Kod pocztowy'],
            'phone' => ['title' => 'Telefon'],
            'email' => ['title' => 'Email', 'form' => 'email'],
            'website' => ['title' => 'Strona'],
        ],
        'listColumns' => [
            'name' => 'Nazwa',
            'nickname' => 'Przydomek',
            'image' => 'Zdjęcie',
        ],
        'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'horde',
        'shortcode' => [
          'list' => 'SELECT * FROM ' . QBWPLISTS_TABLE . 'horde',
        ],
    ],
];
