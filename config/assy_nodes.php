<?php

return [


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

            "part_type"=> [
                "title" => "Part Type",
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

    ],




];


