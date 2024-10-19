<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface UserGroupSettingableService
{
    public function getUsersGroupSetting(AppRequestable $request);
    public function creUsersGroupSetting(AppRequestable $request);
    public function delUsersGroupSetting(AppRequestable $request);
}