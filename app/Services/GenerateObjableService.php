<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface GenerateObjableService
{
    public function generate(AppRequestable $request);
}
