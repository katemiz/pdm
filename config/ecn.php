<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "ECN - Engineering Change Notice",
        "subtitle" => "Mühendislik Değişiklikleri / List of ECNs",
        "addButton" => [
            "text"=>"Add ECN",
            "route"=>"/ecn/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "ecn_no"=> [
                "title" => "ECN No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "cr_no"=> [
                "title" => "CR No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "cr_topic"=> [
                "title" => "CR Title",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "status"=> [
                "title" => "Status",
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
            "r" => "/ecn/view/",
            "w" => "/ecn/form/",
            "x" => "/ecn/delete/"
        ],
        "noitem" => "No ECNs found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this ECN from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "ECN - Engineering Change Notice",
        "subtitle" => "Create a CR",
        "submitText" => "Add CR",
    ],

    "read" => [
        "title" => "ECN - Engineering Change Notice",
        "subtitle" => "View ECN Parameters",
        "submitText" => "Add ECN",
    ],

    "update" => [
        "title" => "ECN - Engineering Change Notice",
        "subtitle" => "Edit ECN Properties",
        "submitText" => "Edit ECN",
    ],

    "cu_route" => "/ecn/store/",

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
    ]
];


