<?php

namespace App\Services;

use App\DTO\Request\AppRequest;

interface UserableService
{
    public function getUsers(AppRequest $request);
}
