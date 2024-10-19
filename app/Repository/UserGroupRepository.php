<?php

namespace App\Repository;

use App\DTO\Entity\UserGroup;
use Exception;
use R;

class UserGroupRepository implements UserGroupableRepository
{
    public function getUserGroup($sqlstmt, $bindParams)
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

    public function creUserGroup(UserGroup $paramDto)
    {
        try {
            $userBean = R::xdispense("users_group");
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

    public function updUserGroup(UserGroup $paramDto, $whereClauseStr, $bindParams)
    {
        try {
            R::begin();

            $setClause = [];
            $localBindParam = [];

            foreach ($paramDto as $property => $value) {
                $setClause[] = "{$property} = ?";
                $localBindParam[] = $value;
            }

            if (!empty($bindParams)) {
                $localBindParam = array_merge($localBindParam, $bindParams);
            }

            $res = R::exec("update users_group set " . join(", ", $setClause) . " {$whereClauseStr}", $localBindParam);
            R::commit();

            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error updating " . $e->getMessage(), 500);
        }
    }

    public function delUserGroup($whereClauseStr, $bindParams)
    {
        try {
            R::begin();

            $res = R::exec("delete from users_group {$whereClauseStr}", $bindParams);
            R::commit();

            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error deleting " . $e->getMessage(), 500);
        }
    }
}
