<?php

/*
    modelTitle          : Variable to be used in javascript confirm dialogs. [Delete, Freeze, Release etc Confirm]
*/

return [

    'modelTitle' => 'Users',


    'index' => [
        'title' => 'Users',
        'subtitle' => 'List of All Users',
        'route' => '/usrs',
        'addBtnTitle' => 'Add User',
        'noItemText' => 'No users found in the database!'
    ],

    'form_create' => [
        'title' => 'Users',
        'subtitle' => 'Add New User',
        'route' => '/usrs/create'
    ],


    'form_edit' => [
        'title' => 'Users',
        'subtitle' => 'Modify User Attributes',
        'route' => '/usrs/{id}/edit'
    ],

    'show' => [
        'title' => 'Users',
        'subtitle' => 'User Details and Properties',
        'route' => '/usrs/{id}'
    ],

    'store' => [
        'route' => '/usrs'
    ],

    'update' => [
        'route' => '/usrs/{id}'
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

];
