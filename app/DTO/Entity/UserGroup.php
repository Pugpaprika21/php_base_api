<?php

namespace App\DTO\Entity;

class UserGroup
{
    public int $id;
    public string $group_name;
    public string $group_code;
    public string $group_description;
    public int $has_in_group;
    public string $created_at;
    public string $updated_at;
}
