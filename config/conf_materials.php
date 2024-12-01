<?php
/*
    modelTitle          : Variable to be used in javascript confirm dialogs. [Delete, Freeze, Release etc Confirm]
*/

return [

    'modelTitle' => 'Material',

    'index' => [
        'title' => 'Materials',
        'subtitle' => 'List of All Materials',
        'route' => '/materials',
        'addBtnTitle' => 'Add Material',
        'noItemText' => 'No materials found in the database!',
    ],

    'formCreate' => [
        'title' => 'Materials',
        'subtitle' => 'Add New Material',
        'route' => '/materials/create'
    ],

    'formEdit' => [
        'title' => 'Materials',
        'subtitle' => 'Update Existing Material Parameters',
        'route' => '/materials/{id}/edit'
    ],

    'show' => [
        'title' => 'Materials',
        'subtitle' => 'Material Details and Properties',
        'route' => '/materials/{id}'
    ],

    'store' => [
        'route' => '/materials'
    ],

    'update' => [
        'route' => '/materials/{id}'
    ],


    'table' =>  [

        'id' => [
            'label' => 'No',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'user_id' => [
            'label' => 'Prepared By',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'family' => [
            'label' => 'Family',
            'visibility' => false,
            'sortable' => true,
            'wrapText' => false,
            'hasViewLink' => false,
        ],


        'familyName' => [
            'label' => 'Material Family',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => false,
            'hasViewLink' => false,
        ],


        'form' => [
            'label' => 'Form',
            'visibility' => false,
            'sortable' => true,
            'wrapText' => false,
            'hasViewLink' => false,
        ],




        'description' => [
            'label' => 'Material',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => true,
        ],


        'specification' => [
            'label' => 'Specification',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'created_at' => [
            'label' => 'Created At',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'updated_at' => [
            'label' => 'Updated At',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

    ],

    "families" => [

        "100" => "Aluminum",
        "200" => "Steel",
        "300" => "Composite",
        "400" => "Plastics",
        "500" => "Other"
    ],

    "formTypes" => [

        "100" => "Sheet/Plate",
        "200" => "Rod/Bar",
        "300" => "Tube/Profile",
    ]

];
