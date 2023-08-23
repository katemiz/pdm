<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Projects",
        "subtitle" => "List of all Projects",
        "addButton" => [
            "text"=>"Add Project",
            "route"=>"/admin/projects/form"
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
        "title" => "Projects",
        "subtitle" => "Create a Project",
        "submitText" => "Add Project",
    ],

    "read" => [
        "title" => "Projects",
        "subtitle" => "View Project Parameters",
        "submitText" => "Add Project",
    ],

    "update" => [
        "title" => "Projects",
        "subtitle" => "Edit Project Properties",
        "submitText" => "Update Project",
    ],

    "cu_route" => "/admin/projects/store/",

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


