<?php

namespace App\Repository;

use App\DTO\Entity\User;

interface UserableRepository
{
    public function getUsers($sqlstmt, $bindParams);
    public function creUser(User $paramDto);
    public function updUsers(User $paramDto, $whereClauseStr, $bindParams);
    public function delUsers($whereClauseStr, $bindParams);
}
