<?php

namespace App\Repository;

use App\DTO\Request\AppableRequest;

interface UserableRepository
{
    public function findAll();
    public function findOne(AppableRequest $request);
    public function createUser(AppableRequest $request);
}
