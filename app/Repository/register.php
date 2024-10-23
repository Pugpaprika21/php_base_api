<?php

use App\Repository\GenerateObjableRepository;
use App\Repository\GenerateObjRepository;
use App\Repository\UserableRepository;
use App\Repository\UserGroupableRepository;
use App\Repository\UserGroupRepository;
use App\Repository\UserGroupSettingableRepository;
use App\Repository\UserGroupSettingRepository;
use App\Repository\UserRepository;

return [
    UserableRepository::class => UserRepository::class,
    UserGroupableRepository::class => UserGroupRepository::class,
    UserGroupSettingableRepository::class => UserGroupSettingRepository::class,
    GenerateObjableRepository::class => GenerateObjRepository::class,
];