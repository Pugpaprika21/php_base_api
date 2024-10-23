<?php

namespace App\Services;

use App\DTO\Request\AppRequestable;

interface GenerateObjableSarvice
{
    public function generate(AppRequestable $request);
}
