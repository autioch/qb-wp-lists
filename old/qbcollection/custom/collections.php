<?php

/* ALL zkwp_tools tables, could be saved in another table...
 * but it's just easier and faster to store them in such table */

return array(
    /* Grupy */
    'group' => array(
        'title' => 'Grupy',
        'id' => 'group',
        'fields' => array(
            'name_pl' => array('title' => 'Nazwa polska *', 'required' => true),
            'name_en' => array('title' => 'Nazwa angielska'),
            'name_de' => array('title' => 'Nazwa niemiecka'),
        ),
        'listColumns' => array(
            'name_pl' => 'Nazwa polska',
            'name_en' => 'Nazwa angielska',
            'name_de' => 'Nazwa niemiecka',
        ),
        'list' => 'SELECT * FROM '.QBCOL_TABLE.'group ORDER BY name_pl',
    ),
    /* Rasy */
    'breed' => array(
        'title' => 'Rasy',
        'id' => 'breed',
        'fields' => array(
            'group_id' => array('title' => 'Grupa', 'db' => 'int(5)', 'form' => 'select', 'required' => true),
            'name' => array('title' => 'Nazwa wyświetlana *', 'required' => true),
            'name_pl' => array('title' => 'Nazwa polska'),
            'name_en' => array('title' => 'Nazwa angielska'),
            'name_de' => array('title' => 'Nazwa niemiecka'),
        ),
        'listColumns' => array(
            'group_name' => 'Grupa',
            'name' => 'Nazwa wyświetlana',
            'name_pl' => 'Nazwa polska',
            'name_en' => 'Nazwa angielska',
            'name_de' => 'Nazwa niemiecka',
        ),
        'list' => 'SELECT  b.*, g.name_pl AS group_name FROM '.QBCOL_TABLE.'breed b LEFT JOIN '.QBCOL_TABLE.'group g ON b.group_id = g.id',
    ),
    /* Hodowle */
    'kennel' => array(
        'title' => 'Hodowle',
        'id' => 'kennel',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'breed_id' => array('title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'),
            'description' => array('title' => 'Opis', 'db' => 'text', 'form' => 'textarea'),
            'address' => array('title' => 'Adres'),
            'city' => array('title' => 'Miasto'),
            'postal_code' => array('title' => 'Kod pocztowy'),
            'contact' => array('title' => 'Osoba kontaktowa'),
            'phone' => array('title' => 'Telefon'),
            'email' => array('title' => 'Email', 'form' => 'email'),
            'website' => array('title' => 'Strona'),
            'image' => array('title' => 'Zdjęcie'),
        ),
        'listColumns' => array(
            'name' => 'Nazwa',
            'breed_name' => 'Rasa',
            'phone' => 'Telefon',
            'email' => 'Email',
        ),
        'list' => 'SELECT k.*, b.name AS breed_name FROM '.QBCOL_TABLE.'kennel k LEFT JOIN '.QBCOL_TABLE.'breed b ON k.breed_id = b.id',
    ),
    /* Czempiony */
    'champion' => array(
        'title' => 'Czempiony',
        'id' => 'champion',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'nickname' => array('title' => 'Przydomek *', 'required' => true),
            'breed_id' => array('title' => 'Rasa *', 'db' => 'int(5)', 'required' => true, 'form' => 'select'),
            'group_id' => array('title' => 'Grupa', 'db' => 'int(5)', 'form' => 'select'),
            'title' => array('title' => 'Tytuły', 'db' => 'text', 'form' => 'textarea'),
            'owner' => array('title' => 'Właściciel'),
            'image' => array('title' => 'Zdjęcie'),
        ),
        'listColumns' => array(
            'name' => 'Nazwa',
            'nickname' => 'Przydomek',
            'breed_name' => 'Rasa',
            'owner' => 'Właściciel',
        ),
        'list' => 'SELECT c.*, b.name AS breed_name FROM '.QBCOL_TABLE.'champion c LEFT JOIN '.QBCOL_TABLE.'breed b ON c.breed_id = b.id',
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
            'registration' => array('title' => 'Nr rejestracji'),
            'lineage' => array('title' => 'Nr rodowodu'),
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
        ),
        'listColumns' => array(
            'name' => 'Nazwa',
            'nickname' => 'Przydomek',
            'breed_name' => 'Rasa',
        ),
        'list' => 'SELECT r.*, b.name AS breed_name FROM '.QBCOL_TABLE.'reproductor r LEFT JOIN '.QBCOL_TABLE.'breed b ON r.breed_id = b.id',
    ),
    /* Wystawy */
    'show' => array(
        'title' => 'Wystawy',
        'id' => 'show',
        'fields' => array(
            'title' => array('title' => 'Tytuł *', 'db' => 'text', 'required' => true, 'form' => 'textarea'),
            'show_date' => array('title' => 'Termin wystawy *', 'db' => 'date', 'required' => true, 'form' => 'date'),
            'app_date' => array('title' => 'Termin zgłoszeń', 'db' => 'date', 'form' => 'date'),
            'app_date_check' => array('title' => 'Pokazuj termin zgłoszeń', 'db' => 'int(1)', 'form' => 'checkbox'),
            'app_website' => array('title' => 'Strona zgłoszeń'),
            'app_website_check' => array('title' => 'Pokazuj stronę zgłoszeń', 'db' => 'int(1)', 'form' => 'checkbox'),
            'city' => array('title' => 'Miejscowość *', 'required' => true),
            'location' => array('title' => 'Lokalizacja'),
            'location_check' => array('title' => 'Pokazuj lokalizację', 'db' => 'int(1)', 'form' => 'checkbox'),
            'sponsors' => array('title' => 'Sponsorzy i Patronat', 'db' => 'text', 'form' => 'textarea'),
            'sponsors_check' => array('title' => 'Pokazuj Sponsorow', 'db' => 'int(1)', 'form' => 'checkbox'),
            'judges' => array('title' => 'Sędziowie', 'db' => 'text', 'form' => 'textarea'),
            'judges_prop' => array('title' => 'Proponowana obsada sędziowska', 'db' => 'int(1)', 'form' => 'checkbox'),
            'judges_check' => array('title' => 'Pokazuj sędziów', 'db' => 'int(1)', 'form' => 'checkbox'),
            'map' => array('title' => 'Mapa dojazdu', 'db' => 'text', 'form' => 'textarea'),
            'map_check' => array('title' => 'Pokazuj mapę dojazdu', 'db' => 'int(1)', 'form' => 'checkbox'),
            'fees' => array('title' => 'Opłaty', 'db' => 'text', 'form' => 'textarea'),
            'fees_notice' => array('title' => 'Opłaty - ostrzeżenie', 'db' => 'text', 'form' => 'textarea'),
            'fees_check' => array('title' => 'Pokazuj opłaty', 'db' => 'int(1)', 'form' => 'checkbox'),
            'breed_list' => array('title' => 'Podział ras', 'db' => 'text', 'form' => 'textarea'),
            'breed_list_check' => array('title' => 'Pokazuj podział ras', 'db' => 'int(1)', 'form' => 'checkbox'),
            'finals' => array('title' => 'Konkurencje finałowe', 'db' => 'text', 'form' => 'textarea'),
            'finals_check' => array('title' => 'Pokazuj konkurencje finałowe', 'db' => 'int(1)', 'form' => 'checkbox'),
            'downloads' => array('title' => 'Materiały do pobrania', 'db' => 'text', 'form' => 'textarea'),
            'downloads_check' => array('title' => 'Pokazuj materiały do pobrania', 'db' => 'int(1)', 'form' => 'checkbox'),
            'events' => array('title' => 'Imprezy towarzyszące', 'db' => 'text', 'form' => 'textarea'),
            'events_check' => array('title' => 'Pokazuj imprezy towarzyszące', 'db' => 'int(1)', 'form' => 'checkbox'),
        ),
        'listColumns' => array(
            'title' => 'Tytuł',
            'show_date' => 'Termin wystawy',
            'app_date' => 'Termin zgłoszeń',
        ),
        'list' => 'SELECT * FROM '.QBCOL_TABLE.'show ORDER BY show_date DESC',
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
        ),
        'listColumns' => array(
            'name' => 'Nazwa',
            'leader' => 'Kierownik sekcji',
            'duty' => 'Dyżury',
        ),
        'list' => 'SELECT * FROM '.QBCOL_TABLE.'club ORDER BY name ASC',
    ),
    /* Opłaty */
    'fee' => array(
        'title' => 'Opłaty',
        'id' => 'fee',
        'fields' => array(
            'name' => array('title' => 'Rodzaj *', 'required' => true),
            'value' => array('title' => 'Cena *', 'required' => true),
            'description' => array('title' => 'Dotyczy'),
        ),
        'listColumns' => array(
            'name' => 'Rodzaj',
            'value' => 'Cena',
            'description' => 'Dotyczy',
        ),
        'list' => 'SELECT * FROM '.QBCOL_TABLE.'fee ORDER BY name',
    ),
    /* Galerie */
    'gallery' => array(
        'title' => 'Galerie',
        'id' => 'gallery',
        'fields' => array(
            'name' => array('title' => 'Nazwa *', 'required' => true),
            'event_date' => array('title' => 'Data *', 'required' => true, 'db' => 'date', 'form' => 'date'),
            'location' => array('title' => 'Katalog *', 'required' => true),
            'city' => array('title' => 'Miejscowość'),
            'description' => array('title' => 'Opis', 'db' => 'text', 'form' => 'textarea'),
            'outside' => array('title' => 'Zewnętrzna', 'db' => 'int(1)', 'form' => 'checkbox'),
            'thumbnail' => array('title' => 'Podgląd (thumbnail.jpg)', 'db' => 'int(1)', 'form' => 'checkbox'),
        ),
        'listColumns' => array(
            'name' => 'Nazwa',
            'event_date' => 'Data',
            'city' => 'Miejscowość',
            'location' => 'Katalog',
        ),
        'list' => 'SELECT * FROM '.QBCOL_TABLE.'gallery ORDER BY event_date DESC, name ASC',
    ),
);
