<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Entity\User;
use App\DTO\Request\AppRequestable;
use App\Repository\UserableRepository;

class UserService implements UserableService
{
    private ?UserableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserableRepository::class);
    }

    public function getUsers(AppRequestable $request)
    {
        $body = $request::app()->json();

        $sqlstmt = "";
        $whereClause = [];
        $bindParams = [];

        $sqlstmt = "
            select id, username, password, first_name, last_name, email, address, phone_number, created_at, updated_at
            from users 
        ";

        if (!empty($body["user_id"])) {
            $whereClause[] = " id = ? ";
            $bindParams[] = $body["user_id"];
        }

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= " order by created_at desc";

        $data = [];
        $rows = $this->repository->getUsers($sqlstmt, $bindParams);
        if (count($rows)) {
            foreach ($rows as $row) {
                $user = new User();
                $user->id = $row["id"];
                $user->username = $row["username"];
                $user->password = $row["password"];
                $user->first_name = $row["first_name"];
                $user->last_name = $row["last_name"];
                $user->email = $row["email"];
                $user->address = $row["address"];
                $user->phone_number = $row["phone_number"];
                $user->created_at = $row["created_at"];
                $user->updated_at = $row["updated_at"];
                $data[] = $user;
            }
        }

        return $data;
    }

    public function creUsers(AppRequestable $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        if (!empty($body["users_rows"])) {
            foreach ($body["users_rows"] as $row) {
                $user = new User();
                $user->username = conText($row["username"]);
                $user->password = conText($row["password"]);
                $user->first_name = conText($row["first_name"]);
                $user->last_name = conText($row["last_name"]);
                $user->email = conText($row["email"]);
                $user->address = conText($row["address"]);
                $user->phone_number = conText($row["phone_number"]);
                $user->created_at = date("Y-m-d H:i:s");
                $user->updated_at = date("Y-m-d H:i:s");

                $this->repository->creUser($user);
                $rows++;
            }
        }

        return ["created_rows" => $rows];
    }

    public function updUsers(AppRequestable $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        $whereClause = [];
        $whereClauseStr = "";
        $bindParams = [];

        if (!empty($body["users_rows"])) {
            foreach ($body["users_rows"] as $row) {
                $user = new User();
                $user->username = conText($row["username"]);
                $user->password = conText($row["password"]);
                $user->first_name = conText($row["first_name"]);
                $user->last_name = conText($row["last_name"]);
                $user->email = conText($row["email"]);
                $user->address = conText($row["address"]);
                $user->phone_number = conText($row["phone_number"]);
                $user->updated_at = date("Y-m-d H:i:s");

                if (!empty($row["user_id"])) {
                    $whereClause[] = "id = ?"; 
                    $bindParams[] = (int)$row["user_id"]; 
                }

                if (count($whereClause)) {
                    $whereClauseStr = "where " . join(" and ", $whereClause);
                }

                $this->repository->updUsers($user, $whereClauseStr, $bindParams);
                $rows++;
            }
        }

        return ["updated_rows" => $rows];
    }

    public function delUsers(AppRequestable $request)
    {
        $body = $request::app()->get();

        $whereClause = [];
        $whereClauseStr = "";
        $bindParams = [];

        if (!empty($body["user_id"])) {
            $whereClause[] = " id = ? ";
            $bindParams[] = (int)conText($body["user_id"]);
        }

        if (count($whereClause)) {
            $whereClauseStr = "where " . join(" and ", $whereClause);
        }

        $rows = $this->repository->delUsers($whereClauseStr, $bindParams);

        return ["deleted_rows" => $rows];
    }
}
