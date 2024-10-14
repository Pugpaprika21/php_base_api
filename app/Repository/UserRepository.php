<?php

namespace App\Repository;

use App\DTO\Entity\User;
use App\DTO\Request\AppableRequest;
use R;

class UserRepository implements UserableRepository
{
    private $tableName = "users";

    public function findAll()
    {
        $data = [];
        $users = R::findAll($this->tableName, "order by created_at desc");
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

    public function findOne(AppableRequest $request)
    {
        $body = $request::app()->get();
        if (!empty($body["user_id"])) {
            $userId = (int)$body["user_id"];
            return R::getAll("select * from users where id = ?", [$userId]);
        }
        return [];
    }

    public function createUser(AppableRequest $request)
    {
        $body = $request::app()->json();
        $user = R::xcreate($this->tableName);
        $user->username = conText($body["username"]);
        $user->password = conText($body["password"]);
        $user->first_name = conText($body["first_name"]);
        $user->last_name = conText($body["last_name"]);
        $user->email = conText($body["email"]);
        $user->address = conText($body["address"]);
        $user->phone_number = conText($body["phone_number"]);
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");
        $userId = R::store($user);
        R::close();

        return $userId;
    }
}
