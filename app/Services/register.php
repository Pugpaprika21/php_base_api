<?php

use App\Services\UserableService;
use App\Services\UserGroupableService;
use App\Services\UserGroupService;
use App\Services\UserGroupSettingableService;
use App\Services\UserGroupSettingService;
use App\Services\UserService;

return [
    UserableService::class => new UserService($this),
    UserGroupableService::class => new UserGroupService($this),
    UserGroupSettingableService::class => new UserGroupSettingService($this)
];