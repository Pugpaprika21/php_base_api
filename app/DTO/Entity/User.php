<?php

namespace App\DTO\Entity;

class User
{
    public function __construct(
        public int $id,
        public string $username,
        public string $password,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $address,
        public string $phone_number,
        public string $created_at,
        public string $updated_at,
    ) {}
}
