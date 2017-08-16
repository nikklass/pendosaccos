<?php

return [

    'role_structure' => [
        
        'superadministrator' => [
            
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u',
            'sms' => 'c,r,u,d',
            'scheduled_sms' => 'c,r,u,d',
            'groups' => 'c,r,u,d',
            'withdrawal' => 'c,r,u,d',
            'deposit' => 'c,r,u,d',
            'repayment' => 'c,r,u,d',
            'account' => 'c,r,u,d',
            'loan' => 'c,r,u,d'

        ],  

        'administrator' => [
            
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'sms' => 'c,r,u,d',
            'scheduled_sms' => 'c,r,u,d',
            'groups' => 'c,r,u,d',
            'withdrawal' => 'c,r,u,d',
            'deposit' => 'c,r,u,d',
            'repayment' => 'c,r,u,d',
            'account' => 'c,r,u,d',
            'loan' => 'c,r,u,d'

        ],

        'groupdministrator' => [
            
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'sms' => 'c,r,u,d',
            'scheduled_sms' => 'c,r,u,d',
            'groups' => 'c,r,u,d',
            'withdrawal' => 'c,r,u,d',
            'deposit' => 'c,r,u,d',
            'repayment' => 'c,r,u,d',
            'account' => 'c,r,u,d',
            'loan' => 'c,r,u,d'

        ],

        'manager' => [

            'profile' => 'r,u'

        ],

        'supervisor' => [

            'profile' => 'r,u'

        ]

    ],

    'permission_structure' => [
        
        /*'cru_user' => [
            'profile' => 'c,r,u'
        ],*/

    ],

    'permissions_map' => [

        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'

    ]

];
