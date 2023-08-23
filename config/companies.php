<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Companies",
        "subtitle" => "List of all Companies",
        "addButton" => [
            "text"=>"Add Company",
            "route"=>"/admin/companies/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "id"=> [
                "title" => "#",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "shortname"=> [
                "title" => "Company Name",
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
            "r" => "/admin/companies/view/",
            "w" => "/admin/companies/form/",
            "x" => "/admin/companies/delete/"
        ],
        "noitem" => "No companies found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this company from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Companies",
        "subtitle" => "Create a Company",
        "submitText" => "Add Company",
    ],

    "read" => [
        "title" => "Companies",
        "subtitle" => "View Company Parameters",
        "submitText" => "Add Company",
    ],

    "update" => [
        "title" => "Companies",
        "subtitle" => "Edit Company Properties",
        "submitText" => "Update Company",
    ],

    "cu_route" => "/admin/companies/store/",

    "form" => [

        "shortname" => [
            "label" => "Company Name",
            "name" => "shortname",
            "placeholder" => "Enter name",
            "value" => ""
        ],

        "email" => [
            "label" => "E-Mail",
            "name" => "email",
            "placeholder" => "Enter e-mail",
            "value" => ""
        ],

        "remarks" => [
            "label" => "Remarks",
            "name" => "remarks",
            "placeholder" => "notes ...",
            "value" => ""
        ]

    ]
];


