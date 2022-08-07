<?php

return [
    'role_structure' => [
        'admin' => [
            'admin_users'       => 'c,r,u,d',
            'roles'             => 'c,r,u,d',
            'users'             => 'c,r,u,d',
            'sliders'           => 'c,r,u,d',
            'static_pages'      => 'c,r,u,d',
            'countries'         => 'c,r,u,d',
            'languages'         => 'c,r,u,d',
            'teams'             => 'c,r,u,d',
            'matches'           => 'c,r,u,d',
            'api_credentials'   => 'r,u',
            'email_configurations'=> 'r,u',
            'global_settings'   => 'r,u',
            'social_media_links'=> 'r,u',
            'metas'             => 'r,u',
            'reports'           => 'm',
            'email_to_users'    => 'm',
            'guesses'           => 'm',
        ],
    ],
    'user_roles' => [
        'admin' => [
            [
                'full_name' => "Admin",
                'username' => "admin",
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'user_currency' => 'en',
                'status' => 1,
                'primary' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'view',
        'u' => 'update',
        'd' => 'delete',
        'm' => 'manage',
    ],
];