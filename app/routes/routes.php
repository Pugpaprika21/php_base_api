<?php

use App\Controllers\UserController;

return [
    'api_v1' => [
        'user' => [
            'user_list' => [UserController::class, "getUsers"],
        ]
    ],
    'api_v2' => [

    ]
];