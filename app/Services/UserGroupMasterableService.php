<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface UserGroupMasterableService
{
    public function getUserGroupMaster(AppRequestable $request);
    public function creUserGroupMaster(AppRequestable $request);
    public function updUserGroupMaster(AppRequestable $request);
    public function delUserGroupMaster(AppRequestable $request);
}
