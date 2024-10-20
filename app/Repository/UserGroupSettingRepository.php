<?php

namespace App\Repository;

use App\DTO\Entity\UserGroupSetting;
use Exception;
use R;

class UserGroupSettingRepository implements UserGroupSettingableRepository
{
    public function getCountHasGroupSetting($sqlstmt, $bindParams)
    {
        try {
            R::begin();
            $rows = R::getAll($sqlstmt, $bindParams);
            R::commit();

            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error get data : " . $e->getMessage(), 500);
        }
    }

    public function getUsersGroup($sqlstmt, $bindParams)
    {
        try {
            R::begin();
            $rows = R::getAll($sqlstmt, $bindParams);
            R::commit();

            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error get data : " . $e->getMessage(), 500);
        }
    }

    public function getUsersGroupSetting($sqlstmt, $bindParams)
    {
        try {
            R::begin();
            $rows = R::getAll($sqlstmt, $bindParams);
            R::commit();

            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error get data : " . $e->getMessage(), 500);
        }
    }

    public function creUsersGroupSetting(UserGroupSetting $paramDto)
    {
        try {
            $userBean = R::xdispense("users_group_setting");
            foreach ($paramDto as $property => $value) {
                $userBean->$property = $value;
            }

            $lastId = R::store($userBean);
            return (int)$lastId;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error storing in " . $e->getMessage(), 500);
        }
    }

    public function delUsersGroupSetting($whereClauseStr, $bindParams)
    {
        try {
            R::begin();

            $res = R::exec("delete from users_group_setting {$whereClauseStr}", $bindParams);
            R::commit();

            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error deleting " . $e->getMessage(), 500);
        }
    }
}
