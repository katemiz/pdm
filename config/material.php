<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Materials",
        "subtitle" => "List of all raw materials",
        "addButton" => [
            "text"=>"Add Material",
            "route"=>"/material/form"
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

            "family_name"=> [
                "title" => "Family",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "form_name"=> [
                "title" => "Form",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "description"=> [
                "title" => "Material Description",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "specification"=> [
                "title" => "Material Specification",
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
            "r" => "/material/view/",
            "w" => "/material/form/",
            "x" => "/material/delete/"
        ],
        "noitem" => "No material definition found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this material from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Materials",
        "subtitle" => "Create a Material Definition",
        "submitText" => "Add Material",
    ],

    "read" => [
        "title" => "Materials",
        "subtitle" => "View Material Parameters",
    ],

    "update" => [
        "title" => "Materials",
        "subtitle" => "Edit Material Properties",
        "submitText" => "Edit Material",
    ],

    "cu_route" => "/material/store/",

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

    "family" => [

        "100" => "Aluminum",
        "200" => "Steel",
        "300" => "Composite",
        "400" => "Plastics",
        "500" => "Other"
    ],

    "form" => [

        "100" => "Sheet/Plate",
        "200" => "Rod/Bar",
        "300" => "Tube/Profile",
    ]
];
