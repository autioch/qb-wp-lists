<?php

/* ALL zkwp_tools tables, could be saved in another table...
 * but it's just easier and faster to store them in such table */

return [
    /* Grupy */
    'group' => [
        'title' => 'Grupy',
        'id' => 'group',
        'fields' => [
            'name_pl' => ['title' => 'Nazwa polska *', 'required' => true],
            'name_en' => ['title' => 'Nazwa angielska'],
            'name_de' => ['title' => 'Nazwa niemiecka'],
        ],
        'listColumns' => [
            'name_pl' => 'Nazwa polska',
            'name_en' => 'Nazwa angielska',
            'name_de' => 'Nazwa niemiecka',
        ],
        'list' => 'SELECT * FROM ' . QBCOL_TABLE . 'group ORDER BY name_pl',
    ],
    /* Rasy */
    'breed' => [
        'title' => 'Rasy',
        'id' => 'breed',
        'fields' => [
            'group_id' => ['title' => 'Grupa', 'db' => 'int(5)', 'form' => 'select', 'required' => true],
            'name' => ['title' => 'Nazwa wyświetlana *', 'required' => true],
            'name_pl' => ['title' => 'Nazwa polska'],
            'name_en' => ['title' => 'Nazwa angielska'],
            'name_de' => ['title' => 'Nazwa niemiecka'],
        ],
        'listColumns' => [
            'group_name' => 'Grupa',
            'name' => 'Nazwa wyświetlana',
            'name_pl' => 'Nazwa polska',
            'name_en' => 'Nazwa angielska',
            'name_de' => 'Nazwa niemiecka',
        ],
        'list' => 'SELECT  b.*, g.name_pl AS group_name FROM ' . QBCOL_TABLE . 'breed b LEFT JOIN ' . QBCOL_TABLE . 'group g ON b.group_id = g.id',
    ],
    /* Hodowle */
    'kennel' => [
        'title' => 'Hodowle',
        'id' => 'kennel',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'breed_id' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'],
            'description' => ['title' => 'Opis', 'db' => 'text', 'form' => 'textarea'],
            'address' => ['title' => 'Adres'],
            'city' => ['title' => 'Miasto'],
            'postal_code' => ['title' => 'Kod pocztowy'],
            'contact' => ['title' => 'Osoba kontaktowa'],
            'phone' => ['title' => 'Telefon'],
            'email' => ['title' => 'Email', 'form' => 'email'],
            'website' => ['title' => 'Strona'],
            'image' => ['title' => 'Zdjęcie'],
        ],
        'listColumns' => [
            'name' => 'Nazwa',
            'breed_name' => 'Rasa',
            'phone' => 'Telefon',
            'email' => 'Email',
        ],
        'list' => 'SELECT k.*, b.name AS breed_name FROM ' . QBCOL_TABLE . 'kennel k LEFT JOIN ' . QBCOL_TABLE . 'breed b ON k.breed_id = b.id',
    ],
    /* Czempiony */
    'champion' => [
        'title' => 'Czempiony',
        'id' => 'champion',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'nickname' => ['title' => 'Przydomek *', 'required' => true],
            'breed_id' => ['title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'],
            'group_id' => ['title' => 'Grupa', 'db' => 'int(5)', 'form' => 'select'],
            'title' => ['title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'],
            'owner' => ['title' => 'Właściciel'],
            'image' => ['title' => 'Zdjęcie'],
        ],
        'listColumns' => [
            'name' => 'Nazwa',
            'nickname' => 'Przydomek',
            'breed_name' => 'Rasa',
            'owner' => 'Właściciel',
        ],
        'list' => 'SELECT c.*, b.name AS breed_name FROM ' . QBCOL_TABLE . 'champion c LEFT JOIN ' . QBCOL_TABLE . 'breed b ON c.breed_id = b.id',
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
            'breed_name' => 'Rasa',
        ],
        'list' => 'SELECT r.*, b.name AS breed_name FROM ' . QBCOL_TABLE . 'reproductor r LEFT JOIN ' . QBCOL_TABLE . 'breed b ON r.breed_id = b.id',
    ],
    /* Wystawy */
    'show' => [
        'title' => 'Wystawy',
        'id' => 'show',
        'fields' => [
            'title' => ['title' => 'Tytuł *', 'db' => 'text', 'required' => true, 'form' => 'textarea'],
            'show_date' => ['title' => 'Termin wystawy *', 'db' => 'date', 'required' => true, 'form' => 'date'],
            'app_date' => ['title' => 'Termin zgłoszeń', 'db' => 'date', 'form' => 'date'],
            'app_date_check' => ['title' => 'Pokazuj termin zgłoszeń', 'db' => 'int(1)', 'form' => 'checkbox'],
            'app_website' => ['title' => 'Strona zgłoszeń'],
            'app_website_check' => ['title' => 'Pokazuj stronę zgłoszeń', 'db' => 'int(1)', 'form' => 'checkbox'],
            'city' => ['title' => 'Miejscowość *', 'required' => true],
            'location' => ['title' => 'Lokalizacja'],
            'location_check' => ['title' => 'Pokazuj lokalizację', 'db' => 'int(1)', 'form' => 'checkbox'],
            'sponsors' => ['title' => 'Sponsorzy i Patronat', 'db' => 'text', 'form' => 'textarea'],
            'sponsors_check' => ['title' => 'Pokazuj Sponsorow', 'db' => 'int(1)', 'form' => 'checkbox'],
            'judges' => ['title' => 'Sędziowie', 'db' => 'text', 'form' => 'textarea'],
            'judges_prop' => ['title' => 'Proponowana obsada sędziowska', 'db' => 'int(1)', 'form' => 'checkbox'],
            'judges_check' => ['title' => 'Pokazuj sędziów', 'db' => 'int(1)', 'form' => 'checkbox'],
            'map' => ['title' => 'Mapa dojazdu', 'db' => 'text', 'form' => 'textarea'],
            'map_check' => ['title' => 'Pokazuj mapę dojazdu', 'db' => 'int(1)', 'form' => 'checkbox'],
            'fees' => ['title' => 'Opłaty', 'db' => 'text', 'form' => 'textarea'],
            'fees_notice' => ['title' => 'Opłaty - ostrzeżenie', 'db' => 'text', 'form' => 'textarea'],
            'fees_check' => ['title' => 'Pokazuj opłaty', 'db' => 'int(1)', 'form' => 'checkbox'],
            'breed_list' => ['title' => 'Podział ras', 'db' => 'text', 'form' => 'textarea'],
            'breed_list_check' => ['title' => 'Pokazuj podział ras', 'db' => 'int(1)', 'form' => 'checkbox'],
            'finals' => ['title' => 'Konkurencje finałowe', 'db' => 'text', 'form' => 'textarea'],
            'finals_check' => ['title' => 'Pokazuj konkurencje finałowe', 'db' => 'int(1)', 'form' => 'checkbox'],
            'downloads' => ['title' => 'Materiały do pobrania', 'db' => 'text', 'form' => 'textarea'],
            'downloads_check' => ['title' => 'Pokazuj materiały do pobrania', 'db' => 'int(1)', 'form' => 'checkbox'],
            'events' => ['title' => 'Imprezy towarzyszące', 'db' => 'text', 'form' => 'textarea'],
            'events_check' => ['title' => 'Pokazuj imprezy towarzyszące', 'db' => 'int(1)', 'form' => 'checkbox'],
        ],
        'listColumns' => [
            'title' => 'Tytuł',
            'show_date' => 'Termin wystawy',
            'app_date' => 'Termin zgłoszeń',
        ],
        'list' => 'SELECT * FROM ' . QBCOL_TABLE . 'show ORDER BY show_date DESC',
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
        'listColumns' => [
            'name' => 'Nazwa',
            'leader' => 'Kierownik sekcji',
            'duty' => 'Dyżury',
        ],
        'list' => 'SELECT * FROM ' . QBCOL_TABLE . 'club ORDER BY name ASC',
    ],
    /* Opłaty */
    'fee' => [
        'title' => 'Opłaty',
        'id' => 'fee',
        'fields' => [
            'name' => ['title' => 'Rodzaj *', 'required' => true],
            'value' => ['title' => 'Cena *', 'required' => true],
            'description' => ['title' => 'Dotyczy'],
        ],
        'listColumns' => [
            'name' => 'Rodzaj',
            'value' => 'Cena',
            'description' => 'Dotyczy',
        ],
        'list' => 'SELECT * FROM ' . QBCOL_TABLE . 'fee ORDER BY name',
    ],
    /* Galerie */
    'gallery' => [
        'title' => 'Galerie',
        'id' => 'gallery',
        'fields' => [
            'name' => ['title' => 'Nazwa *', 'required' => true],
            'event_date' => ['title' => 'Data *', 'required' => true, 'db' => 'date', 'form' => 'date'],
            'location' => ['title' => 'Katalog *', 'required' => true],
            'city' => ['title' => 'Miejscowość'],
            'description' => ['title' => 'Opis', 'db' => 'text', 'form' => 'textarea'],
            'outside' => ['title' => 'Zewnętrzna', 'db' => 'int(1)', 'form' => 'checkbox'],
            'thumbnail' => ['title' => 'Podgląd (thumbnail.jpg)', 'db' => 'int(1)', 'form' => 'checkbox'],
        ],
        'listColumns' => [
            'name' => 'Nazwa',
            'event_date' => 'Data',
            'city' => 'Miejscowość',
            'location' => 'Katalog',
        ],
        'list' => 'SELECT * FROM ' . QBCOL_TABLE . 'gallery ORDER BY event_date DESC, name ASC',
    ],
];
