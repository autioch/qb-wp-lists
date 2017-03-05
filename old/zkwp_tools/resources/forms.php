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
        ),
		'addType' => true,
        'sendto' => array(
            'biuro@zkwp-koszalin.pl',
            'aleksako@interia.pl',
            'sunan@o2.pl',
            )
    ),
    /* Szczenięta */
    'pup' => array(
        'title' => 'Szczenięta',
        'id' => 'pup',
        'fields' => array(
            'club' => array('title' => 'Sekcja', 'required' => true, 'form' => 'select'),
            'name' => array('title' => 'Imię i nazwisko', 'required' => true),
            'membership' => array('title' => 'Nr legitymacji członkowskiej', 'required' => true),
            'breed' => array('title' => 'Urodzona rasa', 'required' => true),
            'kennel' => array('title' => 'Nazwa hodowli', 'required' => true),
            'birth' => array('title' => 'Data urodzin', 'required' => true),
            'females' => array('title' => 'Ilość suczek', 'required' => true, 'form' => 'number'),
            'males' => array('title' => 'Ilość piesków', 'required' => true, 'form' => 'number'),
            'father' => array('title' => 'Ojciec', 'required' => true),
            'mother' => array('title' => 'Matka', 'required' => true),
            'email' => array('title' => 'Email', 'form' => 'email'),
            'phone' => array('title' => 'Telefon', 'required' => true),
            'website' => array('title' => 'Strona')			
        ),
		'addType' => false,
        'sendto' => array(
            'biuro@zkwp-koszalin.pl',
            'radosny@gmail.com',
            'aleksako@interia.pl',
            //'sunan@o2.pl',
            ),
        'fieldOptions' => array(
            'club' => 'SELECT id, name FROM ' . ZKWP_TABLE . 'club ORDER BY name ASC'
        )
    ),
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
