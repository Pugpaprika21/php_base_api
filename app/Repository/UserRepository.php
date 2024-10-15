<?php

namespace App\Repository;

use App\DTO\Entity\User;
use Exception;
use R;

class UserRepository implements UserableRepository
{
    public function getUsers($sqlstmt, $bindParam)
    {
        try {
            R::begin();
            $rows = R::getAll($sqlstmt, $bindParam);

            R::commit();
            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error get data : " . $e->getMessage(), 500);
        }
    }

    public function creUser($tableName, User $user)
    {
        try {
            $userBean = R::xcreate($tableName);
            foreach ($user as $property => $value) {
                $userBean->$property = $value;
            }

            $lastId = R::store($userBean);
            return (int)$lastId;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception('Error storing in ' . $tableName . ': ' . $e->getMessage(), 500);
        }
    }

    public function updUsers($tableName, User $user, $whereClauseStr, $bindParam)
    {
        try {
            R::begin();
    
            $setClause = [];
            $localBindParam = []; 
    
            foreach ($user as $property => $value) {
                $setClause[] = "{$property} = ?";
                $localBindParam[] = $value; 
            }

            if (!empty($bindParam)) {
                $localBindParam = array_merge($localBindParam, $bindParam);
            }
    
            $res = R::exec("update {$tableName} set " . join(", ", $setClause) . " {$whereClauseStr}", $localBindParam);
            R::commit();
    
            return (int)$res;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception('Error updating in ' . $tableName . ': ' . $e->getMessage(), 500);
        }
    }
    
}
