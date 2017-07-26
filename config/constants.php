<?php

$api_domain_url = "http://127.0.0.1:8000/";
$api_version_url = "api/v1/";
$api_path_url = $api_domain_url . $api_version_url;

$remote_api_url = "http://mschools.co.ke/api/v1/";

return [
    'options' => [
        'option_attachment' => '13',
        'option_email' => '14',
        'option_monetery' => '15',
        'option_ratings' => '16',
        'option_textarea' => '17',
    ],
    'error' => [
        'invalid_phone_number' => 'Please enter a valid phone number in any of these formats: <br> 07XXXXXXXX <br> or 2547XXXXXXXX <br> or +2547XXXXXXXX'
    ],
    'routes' => [
        'get_users_url' => $api_path_url . 'users/index',
        'create_user_url' => $api_path_url . 'users/create',
        'create_message_url' => $api_path_url . 'smsoutbox/create'
    ],
    'passport' => [
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
        'login_url' => $api_domain_url . 'oauth/token',
        'user_url' => $api_domain_url . 'api/user'
    ],
    'bulk_sms' => [
        'send_sms_url' => $remote_api_url . "send_bulk_sms",
        'get_sms_data' => $remote_api_url . "get_bulk_sms_data",
        'get_sms_inbox' => $remote_api_url . "get_sms_inbox",
        'get_sms_inbox' => $remote_api_url . "get_sms_inbox",
        'src' => env('BULK_SMS_SRC'),
        'usr' => env('BULK_SMS_USR'),
        'pass' => env('BULK_SMS_PASS'),
    ]
];