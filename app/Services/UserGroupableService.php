<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface UserGroupableService
{
    public function getUserGroup(AppRequestable $request);
    public function creUserGroup(AppRequestable $request);
    public function updUserGroup(AppRequestable $request);
    public function delUserGroup(AppRequestable $request);
}
