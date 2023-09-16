<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Product and Process Notes",
        "subtitle" => "List of all Product and Process Notes",
        "addButton" => [
            "text"=>"Add Note",
            "route"=>"/notes/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "id"=> [
                "title" => "No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "category"=> [
                "title" => "Category",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "text_tr"=> [
                "title" => "Product Note",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "created_at"=> [
                "title" => "Created On",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ]

        ],
        "actions" => [
            "r" => "/notes/view/",
            "w" => "/notes/form/",
            "x" => "/notes/delete/"
        ],
        "noitem" => "No product notes found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this product note from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Product and Process Notes",
        "subtitle" => "Create a Product and Process Note",
        "submitText" => "Add Note",
    ],

    "read" => [
        "title" => "Product and Process Notes",
        "subtitle" => "View Product and Process Note Parameters",
    ],

    "update" => [
        "title" => "Product and Process Notes",
        "subtitle" => "Edit Product and Process Note Properties",
        "submitText" => "Edit Note",
    ],

    "cu_route" => "/notes/store/",

    "form" => [

        "name" => [
            "label" => "Name",
            "name" => "name",
            "placeholder" => "Enter name",
            "value" => ""
        ],


        "lastname" => [
            "label" => "Lastname",
            "name" => "lastname",
            "placeholder" => "Enter lastname",
            "value" => ""
        ],

        "email" => [
            "label" => "E-Mail",
            "name" => "email",
            "placeholder" => "Enter e-mail",
            "value" => ""
        ],

        "description" => [
            "label" => "Talep Tanımı / Request Description",
            "name" => "description",
            "placeholder" => "Talebi detaylı olarak tarif ediniz ...",
            "value" => ""
        ]
    ],




    "categories" => [
        [
            'id' => 100,
            'text_tr' => 'General Notes',
            'text_en' => 'General Notes',
            'status' => 'Active'
        ],

        [
            'id' => 200,
            'text_tr' => 'Surface Protection',
            'text_en' => 'Surface Protection',
            'status' => 'Active'
        ],

        [
            'id' => 300,
            'text_tr' => 'Surface Protection - Painting',
            'text_en' => 'Surface Protection - Painting',
            'status' => 'Active'
        ],

        [
            'id' => 400,
            'text_tr' => 'Mechanical Fastening',
            'text_en' => 'Mechanical Fastening',
            'status' => 'Active'
        ],

        [
            'id' => 500,
            'text_tr' => 'Bonding',
            'text_en' => 'Bonding',
            'status' => 'Active'
        ],

    ]
];
