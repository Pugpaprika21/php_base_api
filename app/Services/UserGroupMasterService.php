<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Request\AppRequestable;
use App\Repository\UserGroupMasterableRepository;

class UserGroupMasterService implements UserGroupMasterableService
{
    private ?UserGroupMasterableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserGroupMasterableRepository::class);
    }

    public function getUserGroupMaster(AppRequestable $request) {}

    public function creUserGroupMaster(AppRequestable $request) {}

    public function updUserGroupMaster(AppRequestable $request) {}

    public function delUserGroupMaster(AppRequestable $request) {}
}
