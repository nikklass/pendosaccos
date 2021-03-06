<?php

$api_domain_url = "http://127.0.0.1:8000/";
$api_version_url = "api/v1/";
$api_path_url = $api_domain_url . $api_version_url;

//$remote_api_url = "http://mschools.co.ke/api/v1/";
$remote_api_url = "http://41.215.126.10/api2/";

$remote_test_mpesa_api_url = "https://sandbox.safaricom.co.ke/";

$remote_mpesa_api_url = "https://api.safaricom.co.ke/";

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
        'consumer_key_1' => env('MPESA_CONSUMER_KEY_1'),
        'consumer_secret_1' => env('MPESA_CONSUMER_SECRET_1'),
        'consumer_key_2' => env('MPESA_CONSUMER_KEY_2'),
        'consumer_secret_2' => env('MPESA_CONSUMER_SECRET_2'),
        'short_code' => env('MPESA_SHORT_CODE'),
        'lipa_mpesa_password' => env('LIPA_NA_MPESA_PASSWORD'),
        'get_mpesa_token_url' => $remote_mpesa_api_url . "oauth/v1/generate?grant_type=client_credentials",
        'c2b_simulate_trans_url' => $remote_mpesa_api_url . "mpesa/c2b/v1/simulate",
        'c2b_register_url' => $remote_mpesa_api_url . "mpesa/c2b/v1/registerurl",
        'b2b_payment_request_url' => $remote_mpesa_api_url . "mpesa/b2b/v1/paymentrequest",
        'b2c_payment_request_url' => $remote_mpesa_api_url . "mpesa/b2c/v1/paymentrequest",
        'account_balance_url' => $remote_mpesa_api_url . "mpesa/accountbalance/v1/query",
        'lipa_mpesa_online_query_url' => $remote_mpesa_api_url . "mpesa/stkpushquery/v1/query",
        'lipa_mpesa_online_payment_url' => $remote_mpesa_api_url . "mpesa/stkpush/v1/processrequest"
    ],

    'oauth' => [
        'token_url' => $remote_api_url . "oauth/token",
        'username' => env('OAUTH_USERNAME'),
        'password' => env('OAUTH_PASSWORD'),
        'client_id' => env('OAUTH_CLIENT_ID'),
        'client_secret' => env('OAUTH_CLIENT_SECRET')
    ],
    
    'bulk_sms' => [
        'send_sms_url' => $remote_api_url . "api/sms/sendBulkSms",
        'get_sms_data_url' => $remote_api_url . "api/sms/getBulkSmsAccount",
        'get_sms_inbox_url' => $remote_api_url . "get_sms_inbox",
        'get_sms_inbox' => $remote_api_url . "get_sms_inbox",
        'src' => env('BULK_SMS_SRC'),
        'usr' => env('BULK_SMS_USR'),
        'pass' => env('BULK_SMS_PASS'),
    ]

];