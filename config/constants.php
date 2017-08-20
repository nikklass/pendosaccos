<?php

$api_domain_url = "http://127.0.0.1:8000/";
$api_version_url = "api/v1/";
$api_path_url = $api_domain_url . $api_version_url;

$remote_api_url = "http://mschools.co.ke/api/v1/";

$remote_mpesa_api_url = "https://sandbox.safaricom.co.ke/";

return [
    'options' => [
        'option_attachment' => '13',
        'option_email' => '14',
        'option_monetery' => '15',
        'option_ratings' => '16',
        'option_textarea' => '17',
    ],
    'error' => [
        'invalid_phone_number' => 'Please enter a valid phone number in any of these formats: <br>7XXXXXXXX,  <br>07XXXXXXXX, <br>2547XXXXXXXX, <br>+2547XXXXXXXX',
        'excess_withdrawal' => 'Withdrawal amount <strong>%s</strong> is more than your account balance: <strong>%s</strong>',
        'excess_loan_repayment' => 'Repayment amount <strong>%s</strong> is more than your loan balance: <strong>%s</strong>',
        'excess_withdrawal_amount' => 'Withdrawal amount <strong>%s</strong> is more than your account balance: <strong>%s</strong>',
        'excess_loan' => 'Loan amount <strong>%s</strong> is more than <strong>%s</strong> group account balance: <strong>%s</strong>',
        'invalid_access' => 'Invalid access',
    ],
    'success' => [
        'insert' => '%s successfully added',
        'update' => '%s successfully updated',
        'delete' => '%s successfully deleted',
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
    'mpesa' => [
        'consumer_key' => env('MPESA_CONSUMER_KEY'),
        'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
        'security_credentials' => env('MPESA_SECURITY_CREDENTIALS'),
        'short_code' => env('MPESA_SHORT_CODE'),
        'get_mpesa_token_url' => $remote_mpesa_api_url . "oauth/v1/generate?grant_type=client_credentials",
        'c2b_simulate_trans_url' => $remote_mpesa_api_url . "mpesa/c2b/v1/simulate",
        'c2b_register_url' => $remote_mpesa_api_url . "mpesa/c2b/v1/registerurl",
        
    ],
    'bulk_sms' => [
        'send_sms_url' => $remote_api_url . "send_bulk_sms",
        'get_sms_data_url' => $remote_api_url . "get_bulk_sms_data",
        'get_sms_inbox_url' => $remote_api_url . "get_sms_inbox",
        'get_sms_inbox' => $remote_api_url . "get_sms_inbox",
        'src' => env('BULK_SMS_SRC'),
        'usr' => env('BULK_SMS_USR'),
        'pass' => env('BULK_SMS_PASS'),
    ]
];