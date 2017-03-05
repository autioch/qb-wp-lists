<?php

return [
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
