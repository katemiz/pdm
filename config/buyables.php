<?php

return [

    "list" => [
        "title" => "Buyable Products",
        "subtitle" => "List of all Buyable Products",
        "addButton" => [
            "text"=>"Add Project",
            "route"=>"/buyables/form"
        ],
        "filterText" => "Search ...",

        "headers" => [

            "part_no"=> [
                "title" => "PN",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "mast_family_mt"=> [
                "title" => "Family",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "nomenclature"=> [
                "title" => "Labeling",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "max_payload_kg"=> [
                "title" => "Capacity (kg)",
                "sortable" => true,
                "align" => "right",
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
            "r" => "/admin/projects/view/",
            "w" => "/admin/projects/form/",
            "x" => "/admin/projects/delete/"
        ],
        "noitem" => "No buyable products found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this project from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Buyable Products",
        "subtitle" => "Create a Buyable Product",
        "submitText" => "Add Buyable Product",
    ],

    "read" => [
        "title" => "Buyable Products",
        "subtitle" => "View Buyable Product Parameters",
    ],

    "update" => [
        "title" => "Buyable Products",
        "subtitle" => "Edit Buyable Product Properties",
        "submitText" => "Update Buyable Product",
    ],

    "cu_route" => "/endproducts",

    "form" => [

        "name" => [
            "label" => "Name",
            "name" => "name",
            "placeholder" => "Enter name",
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


