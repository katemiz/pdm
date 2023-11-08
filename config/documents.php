<?php

return [

    "list" => [
        "title" => "Documents",
        "subtitle" => "List of all Documents",
        "addButton" => [
            "text"=>"Add Document",
            "route"=>"/documents/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

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
                "title" => "Monemclature",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "max_payload_kg"=> [
                "title" => "Capacity",
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
            "r" => "/documents/view/",
            "w" => "/documents/form/",
            "x" => "/documents/delete/"
        ],
        "noitem" => "No documents found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this document from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Documents",
        "subtitle" => "Create a Document",
        "submitText" => "Add Document",
    ],

    "read" => [
        "title" => "Documents",
        "subtitle" => "View Document Parameters",
    ],

    "update" => [
        "title" => "Documents",
        "subtitle" => "Edit Document Items Properties",
        "submitText" => "Update Document",
    ],


];


