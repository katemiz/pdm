<?php

return [

    "list" => [
        "title" => "End Products",
        "subtitle" => "List of all End Products",
        "addButton" => [
            "text"=>"Add Project",
            "route"=>"/endproducts/form"
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
                "title" => "Short Name",
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
        "title" => "End Products",
        "subtitle" => "Create a End Product",
        "submitText" => "Add End Product",
    ],

    "read" => [
        "title" => "End Products",
        "subtitle" => "View End Product Parameters",
    ],

    "update" => [
        "title" => "End Products",
        "subtitle" => "Edit End Product Properties",
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


