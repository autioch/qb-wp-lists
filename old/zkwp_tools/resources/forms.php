<?php

$zkwpForms = [
    /* Hodowle */
    'kennel' => [
        'title' => 'Hodowle',
        'id' => 'kennel',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'breed' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true],
            'description' => ['title' => 'Opis', 'db' => 'text', 'form' => 'textarea'],
            'address' => ['title' => 'Adres'],
            'city' => ['title' => 'Miasto'],
            'postal_code' => ['title' => 'Kod pocztowy'],
            'contact' => ['title' => 'Osoba kontaktowa'],
            'phone' => ['title' => 'Telefon'],
            'email' => ['title' => 'Email', 'form' => 'email'],
            'website' => ['title' => 'Strona'],
        ],
        'addType' => true,
        'sendto' => [
            'biuro@zkwp-koszalin.pl',
            'aleksako@interia.pl',
            'sunan@o2.pl',
            ],
    ],
    /* Szczenięta */
    'pup' => [
        'title' => 'Szczenięta',
        'id' => 'pup',
        'fields' => [
            'club' => ['title' => 'Sekcja', 'required' => true, 'form' => 'select'],
            'name' => ['title' => 'Imię i nazwisko', 'required' => true],
            'membership' => ['title' => 'Nr legitymacji członkowskiej', 'required' => true],
            'breed' => ['title' => 'Urodzona rasa', 'required' => true],
            'kennel' => ['title' => 'Nazwa hodowli', 'required' => true],
            'birth' => ['title' => 'Data urodzin', 'required' => true],
            'females' => ['title' => 'Ilość suczek', 'required' => true, 'form' => 'number'],
            'males' => ['title' => 'Ilość piesków', 'required' => true, 'form' => 'number'],
            'father' => ['title' => 'Ojciec', 'required' => true],
            'mother' => ['title' => 'Matka', 'required' => true],
            'email' => ['title' => 'Email', 'form' => 'email'],
            'phone' => ['title' => 'Telefon', 'required' => true],
            'website' => ['title' => 'Strona'],
        ],
        'addType' => false,
        'sendto' => [
            'biuro@zkwp-koszalin.pl',
            'radosny@gmail.com',
            'aleksako@interia.pl',
            //'sunan@o2.pl',
            ],
        'fieldOptions' => [
            'club' => 'SELECT id, name FROM ' . ZKWP_TABLE . 'club ORDER BY name ASC',
        ],
    ],
    'contact' => [
        'title' => 'Kontakt',
        'id' => 'contact',
        'fields' => [
            'name' => ['title' => 'Nazwa', 'required' => true],
            'value' => ['title' => 'Wartość', 'required' => true],
            'description' => ['title' => 'Opis'],
        ],
    ],
    'poll01' => [
        'title' => 'Ankieta',
        'id' => 'poll01',
        'fields' => [
            'overall' => ['title' => 'Ogólna ocena strony', 'form' => 'textarea'],
            'ui' => ['title' => 'Dostępność informacji', 'form' => 'textarea'],
            'ux' => ['title' => 'Własne wrażenia', 'form' => 'textarea'],
            'layout' => ['title' => 'Układ strony', 'form' => 'textarea'],
            'needsFix' => ['title' => 'Co powinniśmy poprawić?', 'form' => 'textarea'],
            'phone' => ['title' => 'Wrażenia na małym ekranie', 'form' => 'textarea'],
        ],
    ],
];
