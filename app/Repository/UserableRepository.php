<?php

namespace App\Repository;

use App\DTO\Entity\User;

interface UserableRepository
{
    public function getUsers($sqlstmt, $bindParams);
    public function creUser(User $user);
    public function updUsers(User $user, $whereClauseStr, $bindParams);
    public function delUsers($whereClauseStr, $bindParams);
}
