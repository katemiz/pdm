<?php

return [

    'index' => [
        'title' => 'Documents',
        'subtitle' => 'List of All Documents',
    ],

    'form_add' => [
        'title' => 'Documents',
        'subtitle' => 'Add New Document',
    ],

    'form_edit' => [
        'title' => 'Documents',
        'subtitle' => 'Update Existing Document Parameters',
    ],

    'show' => [
        'title' => 'Documents',
        'subtitle' => 'Document Details and Properties',
    ],


    'addBtn' => [
        'title' => 'Add Document',
        'redirect' => '/docs/form'
    ],

    'viewBtn' => [
        'redirect' => '/docs/'
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

    'noItemText' => 'No docuemnts found in the database!',



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