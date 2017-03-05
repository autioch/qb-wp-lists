<?php

$zkwpForms = array(
    /* Hodowle */
    'kennel' => array(
        'title' => 'Hodowle',
        'id' => 'kennel',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'breed' => array('title' => 'Rasa *', 'db' => 'int(5)', 'required' => true),
            'description' => array('title' => 'Opis', 'db' => 'text', 'form' => 'textarea'),
            'address' => array('title' => 'Adres'),
            'city' => array('title' => 'Miasto'),
            'postal_code' => array('title' => 'Kod pocztowy'),
            'contact' => array('title' => 'Osoba kontaktowa'),
            'phone' => array('title' => 'Telefon'),
            'email' => array('title' => 'Email', 'form' => 'email'),
            'website' => array('title' => 'Strona')
        )
    ),
    /* Czempiony */
    'champion' => array(
        'title' => 'Czempiony',
        'id' => 'champion',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'nickname' => array('title' => 'Przydomek *', 'required' => true),
            'breed_id' => array('title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'),
            'title' => array('title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'),
            'owner' => array('title' => 'Właściciel'),
            'image' => array('title' => 'Zdjęcie')
        )
    ),
    /* Reproduktory */
    'reproductor' => array(
        'title' => 'Reproduktory',
        'id' => 'reproductor',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'nickname' => array('title' => 'Przydomek *', 'required' => true),
            'breed_id' => array('title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'),
            'birth' => array('title' => 'Data urodzenia *', 'required' => true, 'form' => 'date'),
            'mother' => array('title' => 'Matka *', 'required' => true),
            'father' => array('title' => 'Ojciec *', 'required' => true),
            'registration' => array('title' => 'Nr rejestracji *', 'required' => true),
            'lineage' => array('title' => 'Nr rodowodu *', 'required' => true),
            'coat' => array('title' => 'Umaszczenie'),
            'image' => array('title' => 'Zdjęcie'),
            'test' => array('title' => 'Badania', 'db' => 'text', 'form' => 'textarea'),
            'training' => array('title' => 'Wyszkolenie', 'db' => 'text', 'form' => 'textarea'),
            'title' => array('title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'),
            'person' => array('title' => 'Właściciel'),
            'address' => array('title' => 'Adres'),
            'city' => array('title' => 'Miasto'),
            'postal_code' => array('title' => 'Kod pocztowy'),
            'phone' => array('title' => 'Telefon'),
            'email' => array('title' => 'Email', 'form' => 'email'),
            'website' => array('title' => 'Strona'),
        )
    ),
    /* Wystawy */
    'show' => array(
        'title' => 'Wystawy',
        'id' => 'show',
        'fields' => array(
            'title' => array('title' => 'Tytuł *', 'db' => 'text', 'required' => true, 'form' => 'textarea'),
            'show_date' => array('title' => 'Termin wystawy *', 'db' => 'date', 'required' => true, 'form' => 'date'),
            'app_date' => array('title' => 'Termin zgłoszeń', 'db' => 'date', 'form' => 'date'),
            'app_website' => array('title' => 'Strona zgłoszeń'),
            'city' => array('title' => 'Miejscowość *', 'required' => true),
            'location' => array('title' => 'Lokalizacja'),
            'judges' => array('title' => 'Sędziowie', 'db' => 'text', 'form' => 'textarea'),
            'judges_prop' => array('title' => 'Proponowana obsada sędziowska', 'db' => 'int(1)', 'form' => 'checkbox'),
            'map' => array('title' => 'Mapa dojazdu', 'db' => 'text', 'form' => 'textarea'),
            'fees' => array('title' => 'Opłaty', 'db' => 'text', 'form' => 'textarea'),
            'breed_list' => array('title' => 'Podział ras', 'db' => 'text', 'form' => 'textarea'),
            'finals' => array('title' => 'Konkurencje finałowe', 'db' => 'text', 'form' => 'textarea'),
            'downloads' => array('title' => 'Materiały do pobrania', 'db' => 'text', 'form' => 'textarea'),
            'events' => array('title' => 'Imprezy towarzyszące', 'db' => 'text', 'form' => 'textarea')
        )
    ),
    /* Kluby i sekcje */
    'club' => array(
        'title' => 'Kluby i Sekcje',
        'id' => 'club',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'leader' => array('title' => 'Kierownik sekcji *', 'required' => true),
            'duty' => array('title' => 'Dyżury *', 'required' => true),
            'support' => array('title' => 'Działacze', 'db' => 'text', 'form' => 'textarea'),
        )
    ),
    /* Opłaty */
    'contact' => array(
        'title' => 'Kontakt',
        'id' => 'contact',
        'fields' => array(
            'name' => array('title' => 'Nazwa', 'required' => true),
            'value' => array('title' => 'Wartość', 'required' => true),
            'description' => array('title' => 'Opis'),
        )
    ),
    'poll01' => array(
        'title' => 'Ankieta',
        'id' => 'poll01',
        'fields' => array(
            'overall' => array('title' => 'Ogólna ocena strony', 'form' => 'textarea'),
            'ui' => array('title' => 'Dostępność informacji', 'form' => 'textarea'),
            'ux' => array('title' => 'Własne wrażenia', 'form' => 'textarea'),
            'layout' => array('title' => 'Układ strony', 'form' => 'textarea'),
            'needsFix' => array('title' => 'Co powinniśmy poprawić?', 'form' => 'textarea'),
            'phone' => array('title' => 'Wrażenia na małym ekranie', 'form' => 'textarea')
        )
    )
);
