<?php

return [

    "list" => [
        "title" => "Documents",
        "subtitle" => "List of all Documents",
        "addButton" => [
            "text"=>"Add Document",
            "route"=>"/document/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "doc_no"=> [
                "title" => "Doc No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],


            "language"=> [
                "title" => "Lang",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "is_html"=> [
                "title" => "HTML",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],


            "title"=> [
                "title" => "Doc Title",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "author"=> [
                "title" => "Author",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "created_at"=> [
                "title" => "Datetime",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ]

        ],
        "actions" => [
            "r" => "/document/view/",
            "w" => "/document/form/",
            "x" => "/document/delete/"
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


