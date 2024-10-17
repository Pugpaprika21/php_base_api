<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface UserableService
{
    public function getUsers(AppRequestable $request);
    public function creUsers(AppRequestable $request);
    public function updUsers(AppRequestable $request);
    public function delUsers(AppRequestable $request);
}