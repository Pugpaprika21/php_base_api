<?php

namespace App\Repository;

use App\DTO\Entity\User;
use Exception;
use R;

class UserRepository implements UserableRepository
{
    public function getUsers($sqlstmt, $bindParamss)
    {
        try {
            R::begin();
            $rows = R::getAll($sqlstmt, $bindParamss);
            R::commit();
      
            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error get data : " . $e->getMessage(), 500);
        }
    }

    public function creUser(User $paramDto)
    {
        try {
            $userBean = R::xdispense("users");
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

    public function updUsers(User $paramDto, $whereClauseStr, $bindParams)
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

            $res = R::exec("update users set " . join(", ", $setClause) . " {$whereClauseStr}", $localBindParam);
            R::commit();

            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error updating " . $e->getMessage(), 500);
        }
    }

    public function delUsers($whereClauseStr, $bindParams)
    {
        try {
            R::begin();

            $res = R::exec("delete from users {$whereClauseStr}", $bindParams);
            R::commit();

            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error deleting " . $e->getMessage(), 500);
        }
    }
}
