<?php

/*
    modelTitle          : Variable to be used in javascript confirm dialogs. [Delete, Freeze, Release etc Confirm]
*/

return [

    'modelTitle' => 'Document',

    'index' => [
        'title' => 'Documents',
        'subtitle' => 'List of All Documents',
        'route' => '/docs',
        'addBtnTitle' => 'Add Document',
        'noItemText' => 'No documents found in the database!',
    ],

    'formCreate' => [
        'title' => 'Documents',
        'subtitle' => 'Add New Document',
        'route' => '/docs/create'
    ],

    'formEdit' => [
        'title' => 'Documents',
        'subtitle' => 'Update Existing Document Parameters',
        'route' => '/docs/{id}/edit'
    ],

    'show' => [
        'title' => 'Documents',
        'subtitle' => 'Document Details and Properties',
        'route' => '/docs/{id}'
    ],

    'store' => [
        'route' => '/docs'
    ],

    'update' => [
        'route' => '/docs/{id}'
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

        'DocNo' => [
            'label' => 'No',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => false,
            'hasViewLink' => true,
        ],

        'company_id' => [
            'label' => 'Company',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'title' => [
            'label' => 'Title',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => false,
        ],


        'Author' => [
            'label' => 'Author',
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


    'docTypes' => [
        'GR' => 'General Document',
        'TR' => 'Test Report',
        'AR' => 'Analysis Report',
        'MN' => 'User Manual',
        'ME' => 'Memo',
        'PR' => 'Presentation'
    ],

    'languages' => [
        'EN' => 'English',
        'TR' => 'Türkçe'
    ]



];
