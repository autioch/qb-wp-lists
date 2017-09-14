<?php

return  [
    'lists' => [
      'label' => [
        'title' => 'Label',
        'db_representation' => 'varchar(128)',
        'form_representation' => 'input',
        'required' => true
      ],
      'admin_list_query' => [
        'title' => 'List query',
        'db_representation' => 'text',
        'form_representation' => 'textarea',
        'required' => true
      ],
      'shortcode_list_query' => [
        'title' => 'Shortcode list query',
        'db_representation' => 'text',
        'form_representation' => 'textarea',
        'required' => true
      ],
      'shortcode_item_query' => [
        'title' => 'Shortcode item query',
        'db_representation' => 'text',
        'form_representation' => 'textarea',
        'required' => true
      ]
    ],
    'fields' => [
      'list_id' => [
        'title' => 'Label',
        'db_representation' => 'int(5)',
        'form_representation' => 'hidden',
        'required' => true
      ],
      'label' => [
        'title' => 'Label',
        'db_representation' => 'varchar(128)',
        'form_representation' => 'input',
        'required' => true
      ],
      'db_representation' => [
        'title' => 'Database representation',
        'db_representation' => 'text',
        'form_representation' => 'textarea',
        'required' => true
      ],
      'form_representation' => [
        'title' => 'Form representation',
        'db_representation' => 'text',
        'form_representation' => 'textarea',
        'required' => true
      ],
      'required' => [
        'title' => 'Is required',
        'db_representation' => 'int(1)',
        'form_representation' => 'checkbox',
        'required' => false
      ]
    ]
];
