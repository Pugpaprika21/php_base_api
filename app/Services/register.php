<?php

use App\Services\UserableService;
use App\Services\UserService;

return [
    UserableService::class => new UserService($this),
];