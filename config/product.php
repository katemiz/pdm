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
                "title" => "Part Number",
                "sortable" => true,
                "align" => "left",
                "column_name" => "part_number",
                "direction" => "asc"
            ],

            "part_type"=> [
                "title" => "Type",
                "sortable" => true,
                "align" => "left",
                "column_name" => "part_type",
                "direction" => "asc"
            ],

            "c_notice_id"=> [
                "title" => "ECN",
                "sortable" => true,
                "align" => "left",
                "column_name" => "c_notice_id",
                "direction" => "asc"
            ],

            "description"=> [
                "title" => "Product Description",
                "sortable" => true,
                "align" => "left",
                "column_name" => "description",
                "direction" => "asc"
            ],

            "created_at"=> [
                "title" => "Created On",
                "sortable" => true,
                "align" => "left",
                "column_name" => "created_at",
                "direction" => "desc"
            ]
        ]
    ]
];


