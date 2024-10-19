<?php

namespace App\Services;

use App\DI\Containerable;
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

    public function getUsersGroupSetting(AppRequestable $request) {}

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
