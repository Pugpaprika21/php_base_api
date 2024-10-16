<?php

namespace App\Services;

use App\DTO\Request\AppRequest;

interface UserableService
{
    public function getUsers(AppRequest $request);
    public function creUsers(AppRequest $request);
    public function updUsers(AppRequest $request);
    public function delUsers(AppRequest $request);
}