<?php

use App\Controllers\UserController;

return [
    "api_v1" => [
        "user" => [
            "user_list" => [UserController::class, "getUsers"],
            "user_create" => [UserController::class, "createUser"],
            "user_one" => [UserController::class, "getUser"],

        ]
    ],
    "api_v2" => []
];
