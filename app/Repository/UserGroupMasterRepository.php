<?php

namespace App\Repository;

use App\DTO\Entity\UserGroupMaster;

class UserGroupMasterRepository implements UserGroupMasterableRepository
{
    public function getUserGroupMaster($sqlstmt, $bindParams) {}

    public function creUserGroupMaster(UserGroupMaster $request) {}

    public function updUserGroupMaster(UserGroupMaster $request, $whereClauseStr, $bindParams) {}

    public function delUserGroupMaster($whereClauseStr, $bindParams) {}
}
