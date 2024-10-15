<?php

namespace App\Repository;

use App\DTO\Entity\User;

interface UserableRepository
{
    public function getUsers($sqlstmt, $bindParam);
    public function creUser($tableName, User $user);
    public function updUsers($tableName, User $user, $whereClauseStr, $bindParam);
}
