<?php

use App\Services\UserableService;
use App\Services\UserGroupMasterableService;
use App\Services\UserGroupMasterService;
use App\Services\UserService;

return [
    UserableService::class => new UserService($this),
    UserGroupMasterableService::class => new UserGroupMasterService($this),
];