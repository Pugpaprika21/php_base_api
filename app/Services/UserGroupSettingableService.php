<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface UserGroupSettingableService
{
    public function getCountHasGroupSetting(AppRequestable $request);
    public function getUsersGroup(AppRequestable $request);
    public function getUsersGroupSetting(AppRequestable $request);
    public function creUsersGroupSetting(AppRequestable $request);
}