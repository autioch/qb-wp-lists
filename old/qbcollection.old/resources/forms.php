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
    ],
    /* Czempiony */
    'champion' => [
        'title' => 'Czempiony',
        'id' => 'champion',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'nickname' => ['title' => 'Przydomek *', 'required' => true],
            'breed_id' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'],
            'title' => ['title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'],
            'owner' => ['title' => 'Właściciel'],
            'image' => ['title' => 'Zdjęcie'],
        ],
    ],
    /* Reproduktory */
    'reproductor' => [
        'title' => 'Reproduktory',
        'id' => 'reproductor',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'nickname' => ['title' => 'Przydomek *', 'required' => true],
            'breed_id' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'],
            'birth' => ['title' => 'Data urodzenia *', 'required' => true, 'form' => 'date'],
            'mother' => ['title' => 'Matka *', 'required' => true],
            'father' => ['title' => 'Ojciec *', 'required' => true],
            'registration' => ['title' => 'Nr rejestracji *', 'required' => true],
            'lineage' => ['title' => 'Nr rodowodu *', 'required' => true],
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
    ],
    /* Wystawy */
    'show' => [
        'title' => 'Wystawy',
        'id' => 'show',
        'fields' => [
            'title' => ['title' => 'Tytuł *', 'db' => 'text', 'required' => true, 'form' => 'textarea'],
            'show_date' => ['title' => 'Termin wystawy *', 'db' => 'date', 'required' => true, 'form' => 'date'],
            'app_date' => ['title' => 'Termin zgłoszeń', 'db' => 'date', 'form' => 'date'],
            'app_website' => ['title' => 'Strona zgłoszeń'],
            'city' => ['title' => 'Miejscowość *', 'required' => true],
            'location' => ['title' => 'Lokalizacja'],
            'judges' => ['title' => 'Sędziowie', 'db' => 'text', 'form' => 'textarea'],
            'judges_prop' => ['title' => 'Proponowana obsada sędziowska', 'db' => 'int(1)', 'form' => 'checkbox'],
            'map' => ['title' => 'Mapa dojazdu', 'db' => 'text', 'form' => 'textarea'],
            'fees' => ['title' => 'Opłaty', 'db' => 'text', 'form' => 'textarea'],
            'breed_list' => ['title' => 'Podział ras', 'db' => 'text', 'form' => 'textarea'],
            'finals' => ['title' => 'Konkurencje finałowe', 'db' => 'text', 'form' => 'textarea'],
            'downloads' => ['title' => 'Materiały do pobrania', 'db' => 'text', 'form' => 'textarea'],
            'events' => ['title' => 'Imprezy towarzyszące', 'db' => 'text', 'form' => 'textarea'],
        ],
    ],
    /* Kluby i sekcje */
    'club' => [
        'title' => 'Kluby i Sekcje',
        'id' => 'club',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'leader' => ['title' => 'Kierownik sekcji *', 'required' => true],
            'duty' => ['title' => 'Dyżury *', 'required' => true],
            'support' => ['title' => 'Działacze', 'db' => 'text', 'form' => 'textarea'],
        ],
    ],
    /* Opłaty */
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
