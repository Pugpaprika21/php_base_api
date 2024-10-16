<?php

use App\Controllers\UserController;

return [
    "api_v1" => [
        "user" => [
            "get_users" => [UserController::class, "getUsers"],
            "cre_users" => [UserController::class, "creUsers"],
            "upd_users" => [UserController::class, "updUsers"],
            "del_users" => [UserController::class, "delUsers"],
        ]
    ],
    "api_v2" => []
];
