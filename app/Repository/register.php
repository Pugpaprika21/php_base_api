<?php

use App\Repository\UserableRepository;
use App\Repository\UserGroupMasterableRepository;
use App\Repository\UserGroupMasterRepository;
use App\Repository\UserRepository;

return [
    UserableRepository::class => UserRepository::class,
    UserGroupMasterableRepository::class => UserGroupMasterRepository::class,
];