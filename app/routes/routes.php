<?php

use App\Controllers\UserController;
use App\Controllers\UserGroupController;
use App\Controllers\UserGroupSettingController;

return [
    "api_v1" => [
        "user" => [
            "get_users" => [UserController::class, "getUsers"],
            "cre_users" => [UserController::class, "creUsers"],
            "upd_users" => [UserController::class, "updUsers"],
            "del_users" => [UserController::class, "delUsers"],
        ],
        "users_group" => [
            "get_usergroup" => [UserGroupController::class, "getUserGroup"],
            "cre_usergroup" => [UserGroupController::class, "creUserGroup"],
            "upd_usergroup" => [UserGroupController::class, "updUserGroup"],
            "del_usergroup" => [UserGroupController::class, "delUserGroup"],
        ],
        "users_group_setting" => [
            "get_usergroupsetting" => [UserGroupSettingController::class, "getUsersGroupSetting"],
            "cre_usergroupsetting" => [UserGroupSettingController::class, "creUsersGroupSetting"],
            "del_usergroupsetting" => [UserGroupSettingController::class, "delUsersGroupSetting"],
        ]
    ],
    "api_v2" => []
];
