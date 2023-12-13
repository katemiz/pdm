<?php

return [

    "roles" => [
        "r" => ['admin'],
        "w" => ['admin'],
        "x" => ['admin']
    ],

    "list" => [
        "title" => "Products",
        "subtitle" => "List of all products (detail parts, assemblies, buy items etc.)",
        "addButton" => [
            "text"=>"Add Product",
            "route"=>"/products/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "part_number"=> [
                "title" => "Product No",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "c_notice_id"=> [
                "title" => "ECN",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "description"=> [
                "title" => "Product Description",
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
            "r" => "/products/view/",
            "w" => "/products/form/",
            "x" => "/products/delete/"
        ],
        "noitem" => "No products found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this product from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Products",
        "subtitle" => "Create a Product (detail parts, assemblies, buy items etc.)",
        "submitText" => "Add Product",
    ],

    "read" => [
        "title" => "Products",
        "subtitle" => "View Product Parameters",
    ],

    "update" => [
        "title" => "Products",
        "subtitle" => "Edit Product Properties",
        "submitText" => "Edit Product",
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


