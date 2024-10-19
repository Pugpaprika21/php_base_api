<?php

namespace App\DTO\Entity;

class UserGroupSetting
{
    public int $id;
    public int $user_id;
    public int $group_id;
    public string $created_at;
    public string $updated_at;
}
