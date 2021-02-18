<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'activated' => 'Activated',
            'email' => 'Email',
            'first_name' => 'First name',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
            'last_name' => 'Last name',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'activated' => 'Activated',
            'address' => 'Address',
            'avatar' => 'Avatar',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'job' => 'Job',
            'name' => 'Name',
            'password' => 'Password',
            'phone' => 'Phone',
            'uuid' => 'Uuid',
            
        ],
    ],

    'request' => [
        'title' => 'Requests',

        'actions' => [
            'index' => 'Requests',
            'create' => 'New Request',
            'edit' => 'Edit :name',
            'export' => 'Export',
        ],

        'columns' => [
            'id' => 'ID',
            'activated' => 'Activated',
            'message' => 'Message',
            'sender_id' => 'Sender',
            'user_id' => 'User',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];