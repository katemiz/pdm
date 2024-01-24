<?php

return [

    "list" => [
        "title" => "End Products / Sellable Items",
        "subtitle" => "List of all End Products/Sellable Items",
        "addButton" => [
            "text"=>"Add Project",
            "route"=>"/endproducts/form"
        ],
        "filterText" => "Search ...",

        "headers" => [

            "part_number"=> [
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
                "direction" => "desc"
            ]

        ],
        "actions" => [
            "r" => "/admin/projects/view/",
            "w" => "/admin/projects/form/",
            "x" => "/admin/projects/delete/"
        ],
        "noitem" => "No projects found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this project from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "End Products / Sellable Items",
        "subtitle" => "Create a End Product/Sellable Items",
        "submitText" => "Add End Product",
    ],

    "read" => [
        "title" => "End Products / Sellable Items",
        "subtitle" => "View End Product Parameters",
    ],

    "update" => [
        "title" => "End Products / Sellable Items",
        "subtitle" => "Edit End Product/Sellable Items Properties",
        "submitText" => "Update End Products",
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


