<?php

namespace App\Repository;

use App\DTO\Entity\UserGroupSetting;

interface UserGroupSettingableRepository
{
    public function getCountHasGroupSetting($sqlstmt, $bindParams);
    public function getUsersGroup($sqlstmt, $bindParams);
    public function getUsersGroupSetting($sqlstmt, $bindParams);
    public function creUsersGroupSetting(UserGroupSetting $paramDto);
    public function delUsersGroupSetting($whereClauseStr, $bindParams);
}
