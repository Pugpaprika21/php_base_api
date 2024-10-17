<?php

namespace App\DTO\Request;

interface AppRequestable
{
    /**
     * @return AppRequest
     */
    public static function app();

    /**
     * @return AppRequestable
     */
    public static function body();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return mixed
     */
    public function toStdClass();
}
