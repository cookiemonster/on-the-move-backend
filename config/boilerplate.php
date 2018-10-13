<?php

return [

    'sign_up' => [
        'release_token' => 'false',
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required',
            'voornaam' => 'required',
            'achternaam' => 'required',
            'rctoken' => 'required',
            'rcusername' => 'required',
            'rcid' => 'required'
        ]
    ],

    'login' => [
        'validation_rules' => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ],

    'forgot_password' => [
        'validation_rules' => [
            'email' => 'required|email'
        ]
    ],

    'reset_password' => [
        'release_token' => env('PASSWORD_RESET_RELEASE_TOKEN', false),
        'validation_rules' => [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]
    ],

    'get_chat' => [
        'validation_rules' => [
            'token' => 'required'
        ]
    ],

    'get_profiles' => [
        'validation_rules' => [
            'token' => 'required'
        ]
    ]

];
