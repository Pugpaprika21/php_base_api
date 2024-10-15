<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Entity\User;
use App\DTO\Request\AppRequest;
use App\Repository\UserableRepository;

class UserService implements UserableService
{
    private ?UserableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserableRepository::class);
    }

    public function getUsers(AppRequest $request)
    {
        $body = $request::app()->json();

        $sqlstmt = "";
        $whereClause = [];
        $bindParam = [];

        $sqlstmt = "
            select id, username, password, first_name, last_name, email, address, phone_number, created_at, updated_at
            from users 
        ";

        if (!empty($body["id"])) {
            $whereClause[] = " id = ? ";
            $bindParam[] = $body["id"];
        }

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= " order by created_at desc";

        $data = [];
        $rows = $this->repository->getUsers($sqlstmt, $bindParam);
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

    public function creUsers(AppRequest $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        if (!empty($body["users_rows"])) {
            foreach ($body["users_rows"] as $i => $row) {
                $user = new User();
                $user->username = conText($row[$i]["username"]);
                $user->password = conText($row[$i]["password"]);
                $user->first_name = conText($row[$i]["first_name"]);
                $user->last_name = conText($row[$i]["last_name"]);
                $user->email = conText($row[$i]["email"]);
                $user->address = conText($row[$i]["address"]);
                $user->phone_number = conText($row[$i]["phone_number"]);
                $user->created_at = date("Y-m-d H:i:s");
                $user->updated_at = date("Y-m-d H:i:s");

                $this->repository->creUser("users", $user);
                $rows++;
            }
        }

        return ["created_rows" => $rows];
    }

    public function updUsers(AppRequest $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        $whereClause = [];
        $whereClauseStr = "";
        $bindParam = [];

        if (!empty($body["users_rows"])) {
            foreach ($body["users_rows"] as $i => $row) {
                $user = new User();
                $user->username = conText($row[$i]["username"]);
                $user->password = conText($row[$i]["password"]);
                $user->first_name = conText($row[$i]["first_name"]);
                $user->last_name = conText($row[$i]["last_name"]);
                $user->email = conText($row[$i]["email"]);
                $user->address = conText($row[$i]["address"]);
                $user->phone_number = conText($row[$i]["phone_number"]);
                $user->updated_at = date("Y-m-d H:i:s");

                if (!empty($row[$i]["id"])) {
                    $whereClause[] = "id = ?"; 
                    $bindParam[] = (int)$row[$i]["id"]; 
                }

                if (count($whereClause)) {
                    $whereClauseStr = "where " . join(" and ", $whereClause);
                }

                $this->repository->updUsers("users", $user, $whereClauseStr, $bindParam);
                $rows++;
            }
        }

        return ["updated_rows" => $rows];
    }
}
