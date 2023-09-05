<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Değişiklik Talebi - Change Requests",
        "subtitle" => "Değişiklik Talepleri / List of all CRs",
        "addButton" => [
            "text"=>"Add CR",
            "route"=>"/cr/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "id"=> [
                "title" => "CR No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "topic"=> [
                "title" => "CR Topic / Konu",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "status"=> [
                "title" => "Status / Durum",
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
            "r" => "/cr/view/",
            "w" => "/cr/form/",
            "x" => "/cr/delete/"
        ],
        "noitem" => "No CRs found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this CR from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Değişiklik Talebi - Change Requests",
        "subtitle" => "Create a CR",
        "submitText" => "Add CR",
    ],

    "read" => [
        "title" => "Değişiklik Talebi - Change Requests",
        "subtitle" => "View CR Parameters",
        "submitText" => "Add CR",
    ],

    "update" => [
        "title" => "Değişiklik Talebi - Change Requests",
        "subtitle" => "Edit CR Properties",
        "submitText" => "Edit CR",
    ],

    "cu_route" => "/cr/store/",

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


