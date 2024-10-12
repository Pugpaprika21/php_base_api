<?php

namespace App\Repository;

use App\DTO\Entity\User;
use R;

class UserRepository implements UserableRepository
{
    public function findAll()
    {
        $data = [];
        $users = R::findAll("users", "order by created_at desc");
        if (count($users) > 0) {
            foreach ($users as $user) {
                $userDTO = new User(
                    id: $user->id,
                    username: $user->username,
                    password: $user->password,
                    first_name: $user->first_name,
                    last_name: $user->last_name,
                    email: $user->email,
                    address: $user->address,
                    phone_number: $user->phone_number,
                    created_at: $user->created_at,
                    updated_at: $user->updated_at
                );
                array_push($data, $userDTO);
            }
        }
        return $data;
    }
}
