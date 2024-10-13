<?php

namespace App\DTO\Request;

interface AppableRequest
{
    /**
     * @return AppRequest
     */
    public static function app();

    /**
     * @return AppableRequest
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
