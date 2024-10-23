<?php

namespace App\Repository;

use Exception;
use R;

class GenerateObjRepository implements GenerateObjableRepository
{
    public function generate($tbName, $className)
    {
        try {
            R::begin();
            $rows = R::inspect($tbName);
            R::commit();

            return $rows;
        } catch (Exception $e) {
            R::rollback();
            throw new Exception("Error generate " . $e->getMessage(), 500);
        }
    }
}
