<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Entity\UserGroup;
use App\DTO\Entity\UserGroupSetting;
use App\DTO\Request\AppRequestable;
use App\Repository\UserGroupSettingableRepository;

class UserGroupSettingService implements UserGroupSettingableService
{
    private ?UserGroupSettingableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserGroupSettingableRepository::class);
    }

    public function getCountHasGroupSetting(AppRequestable $request)
    {
        $body = $request::app()->get();

        $sqlstmt = "";
        $whereClause = [];
        $bindParams = [];

        $sqlstmt = " select count(1) AS has_group from users_group_setting ";

        if (!empty($body["user_id"])) {
            $whereClause[] = " user_id = ?";
            $bindParams[] = $body["user_id"];
        }

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= " order by created_at desc;";

        $rows = $this->repository->getCountHasGroupSetting($sqlstmt, $bindParams);
        return $rows[0]["has_group"];
    }

    public function getUsersGroup(AppRequestable $request)
    {
        $sqlstmt = "";
        $whereClause = [];
        $bindParams = [];

        $sqlstmt = " select id, group_name, group_code, group_description, created_at, updated_at from users_group ";

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= "order by created_at desc;";

        $data = [];
        $rows = $this->repository->getUsersGroup($sqlstmt, $bindParams);
        if (count($rows)) {
            foreach ($rows as $row) {
                $paramDto = new UserGroup();
                $paramDto->id = $row["id"];
                $paramDto->group_name = $row["group_name"];
                $paramDto->group_code = $row["group_code"];
                $paramDto->group_description = $row["group_description"];
                $paramDto->created_at = $row["created_at"];
                $paramDto->updated_at = $row["updated_at"];
                $data[] = $paramDto;
            }
        }

        return $data;
    }

    public function getUsersGroupSetting(AppRequestable $request)
    {
        $body = $request::app()->get();

        $sqlstmt = "";
        $whereClause = [];
        $bindParams = [];

        $sqlstmt = "
            select distinct ug.id, ug.group_name, case when ugs.user_id is not null then 1 else 0 end as has_in_group
            from users_group as ug
            left join (select group_id, user_id from users_group_setting where user_id = ?) as ugs on ug.id = ugs.group_id
        ";

        if (!empty($body["user_id"])) {
            $bindParams[] = $body["user_id"];
        }

        if (count($whereClause)) {
            $sqlstmt .= "where " . join(" and ", $whereClause);
        }

        $sqlstmt .= "order by ug.created_at desc;";

        $data = [];
        $groupHas = "Y";
        $groupSettCount = $this->getCountHasGroupSetting($request);
        if ($groupSettCount) {
            $rows = $this->repository->getUsersGroupSetting($sqlstmt, $bindParams);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $paramDto = new UserGroupSetting();
                    $paramDto->id = $row["id"];
                    $paramDto->group_name = $row["group_name"];
                    $paramDto->has_in_group = $row["has_in_group"];
                    $data[] = $paramDto;
                }
            }
        } else {
            $data = $this->getUsersGroup($request);
            $groupHas = "N";
        }

        return ["group_rows" => $data, "group_has_rows" => $groupHas];
    }

    public function creUsersGroupSetting(AppRequestable $request)
    {
        $rows = 0;
        $whereClause = [];
        $whereClauseStr = "";
        $bindParams = [];
        $body = $request::app()->json();

        if (!empty($body["users_group_setting_rows"])) {
            $userGroupSettRows = $body["users_group_setting_rows"];
            if (!empty($userGroupSettRows["group_in"])) {
                foreach ($userGroupSettRows["group_in"] as $row) {
                    if (!empty($row["user_id"]) && !empty($row["group_id"])) {
                        $paramDto = new UserGroupSetting();
                        $paramDto->user_id = conText($row["user_id"]);
                        $paramDto->group_id = conText($row["group_id"]);
                        $paramDto->created_at = date("Y-m-d H:i:s");
                        $paramDto->updated_at = date("Y-m-d H:i:s");

                        $this->repository->creUsersGroupSetting($paramDto);
                        $rows++;
                    }
                }
            }

            if (!empty($userGroupSettRows["group_out"])) {
                foreach ($userGroupSettRows["group_out"] as $row) {
                    if (!empty($row["user_id"]) && !empty($row["group_id"])) {
                        if (!empty($body["user_id"])) {
                            $whereClause[] = " user_id = ? ";
                            $bindParams[] = (int)conText($body["user_id"]);
                        }

                        if (!empty($body["group_id"])) {
                            $whereClause[] = " group_id = ? ";
                            $bindParams[] = (int)conText($body["group_id"]);
                        }

                        if (count($whereClause)) {
                            $whereClauseStr = "where " . join(" and ", $whereClause);
                        }

                        $this->repository->delUsersGroupSetting($whereClauseStr, $bindParams);
                    }
                }
            }
        }

        return ["created_rows" => $rows];
    }
}
