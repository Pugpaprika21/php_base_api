<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Entity\UserGroup;
use App\DTO\Request\AppRequestable;
use App\Repository\UserGroupableRepository;

class UserGroupService implements UserGroupableService
{
    private ?UserGroupableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserGroupableRepository::class);
    }

    public function getUserGroup(AppRequestable $request)
    {
        $body = $request::app()->json();

        $sqlstmt = "";
        $whereClause = [];
        $bindParams = [];

        $sqlstmt = "
            select id, group_name, group_code, group_description, created_at, updated_at
            from users_group 
        ";

        if (!empty($body["user_group_id"])) {
            $whereClause[] = " id = ? ";
            $bindParams[] = $body["user_group_id"];
        }

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= " order by created_at desc";

        $data = [];
        $rows = $this->repository->getUserGroup($sqlstmt, $bindParams);
        if (count($rows)) {
            foreach ($rows as $row) {
                $user = new UserGroup();
                $user->id = $row["id"];
                $user->group_name = conText($row["group_name"]);
                $user->group_code = conText($row["group_code"]);
                $user->group_description = conText($row["group_description"]);
                $user->created_at = $row["created_at"];
                $user->updated_at = $row["updated_at"];
                $data[] = $user;
            }
        }

        return $data;
    }

    public function creUserGroup(AppRequestable $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        if (!empty($body["users_group_rows"])) {
            foreach ($body["users_group_rows"] as $row) {
                $user = new UserGroup();
                $user->group_name = conText($row["group_name"]);
                $user->group_code = conText($row["group_code"]);
                $user->group_description = conText($row["group_description"]);
                $user->created_at = date("Y-m-d H:i:s");
                $user->updated_at = date("Y-m-d H:i:s");

                $this->repository->creUserGroup($user);
                $rows++;
            }
        }

        return ["created_rows" => $rows];
    }

    public function updUserGroup(AppRequestable $request)
    {
        $rows = 0;
        $body = $request::app()->json();

        $whereClause = [];
        $whereClauseStr = "";
        $bindParams = [];

        if (!empty($body["users_group_rows"])) {
            foreach ($body["users_group_rows"] as $row) {
                $user = new UserGroup();
                $user->group_name = conText($row["group_name"]);
                $user->group_code = conText($row["group_code"]);
                $user->group_description = conText($row["group_description"]);
                $user->updated_at = date("Y-m-d H:i:s");

                if (!empty($row["user_group_id"])) {
                    $whereClause[] = "id = ?";
                    $bindParams[] = (int)$row["user_group_id"];
                }

                if (count($whereClause)) {
                    $whereClauseStr = "where " . join(" and ", $whereClause);
                }

                $this->repository->updUserGroup($user, $whereClauseStr, $bindParams);
                $rows++;
            }
        }

        return ["updated_rows" => $rows];
    }

    public function delUserGroup(AppRequestable $request)
    {
        $body = $request::app()->get();

        $whereClause = [];
        $whereClauseStr = "";
        $bindParams = [];

        if (!empty($body["user_group_id"])) {
            $whereClause[] = " id = ? ";
            $bindParams[] = (int)conText($body["user_group_id"]);
        }

        if (count($whereClause)) {
            $whereClauseStr = "where " . join(" and ", $whereClause);
        }

        $rows = $this->repository->delUserGroup($whereClauseStr, $bindParams);

        return ["deleted_rows" => $rows];
    }
}
