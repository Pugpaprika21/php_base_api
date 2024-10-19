<?php

namespace App\Repository;

use App\DTO\Entity\UserGroup;

interface UserGroupableRepository
{
    public function getUserGroup($sqlstmt, $bindParams);
    public function creUserGroup(UserGroup $paramDto);
    public function updUserGroup(UserGroup $paramDto, $whereClauseStr, $bindParams);
    public function delUserGroup($whereClauseStr, $bindParams);
}