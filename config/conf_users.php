<?php

return [

    'index' => [
        'title' => 'Users',
        'subtitle' => 'List of All Users',
    ],

    'form_add' => [
        'title' => 'Users',
        'subtitle' => 'Add New User',
    ],

    'form_edit' => [
        'title' => 'Users',
        'subtitle' => 'Modify User Attributes',
    ],

    'show' => [
        'title' => 'Users',
        'subtitle' => 'User Details and Properties',
    ],

    'addBtn' => [
        'title' => 'Add User',
        'redirect' => '/usrs/form'
    ],

    'viewBtn' => [
        'redirect' => '/usrs/'
    ],

    'statusArr' => [
        'Active' => 'Active',
        'Inactive' => 'Inactive'
    ],

    'table' =>  [

        'id' => [
            'label' => 'No',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'name' => [
            'label' => 'Name',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => false,
            'hasViewLink' => true,
        ],

        'lastname' => [
            'label' => 'Lastname',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => true,
        ],

        'company_id' => [
            'label' => 'Company',
            'visibility' => false,
            'sortable' => false,
            'wrapText' => true,
            'hasViewLink' => false,
        ],

        'email' => [
            'label' => 'E-Mail',
            'visibility' => true,
            'sortable' => true,
            'wrapText' => true,
            'hasViewLink' => false,
        ],


        'status' => [
            'label' => 'Status',
            'visibility' => true,
            'sortable' => false,
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

    'noItemText' => 'No users found in the database!'
];