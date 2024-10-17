<?php

/* 

AppRequest::body()->toArray();
AppRequest::body()->toStdClass();

$postData = AppRequest::app()->post();
$getData = AppRequest::app()->get();
$requestData = AppRequest::app()->request();
$filesData = AppRequest::app()->files();
$cookieData = AppRequest::app()->cookie();
$sessionData = AppRequest::app()->session();
$jsonData = AppRequest::app()->json();
$allData = AppRequest::app()->any();

*/

namespace App\DTO\Request;

use Exception;

class AppRequest implements AppRequestable
{
    private static $body = null;

    /**
     * @return AppRequest
     */
    public static function app()
    {
        return new self();
    }

    public function __call($method, $args)
    {
        switch ($method) {
            case "post":
                return $_POST;
            case "get":
                return $_GET;
            case "request":
                return $_REQUEST;
            case "files":
                return $_FILES;
            case "cookie":
                return $_COOKIE;
            case "session":
                return !empty($_SESSION) ? $_SESSION : [];
            case "json":
                $json = file_get_contents("php://input");
                $data = json_decode(is_string($json) && !empty($json) ? $json : "[]", true);
                return $data;
            case "any":
                return $this->toArray();
            default:
                throw new Exception("Method {$method} does not exist");
        }
    }

    /**
     * @return AppableRequest
     */
    public static function body()
    {
        if (is_null(self::$body)) {
            $jsonInput = file_get_contents("php://input");
            $decJson = json_decode($jsonInput, true);
            self::$body = array_merge(($decJson !== null ? $decJson : []), $_REQUEST, $_POST, $_GET, $_FILES, $_COOKIE, $_SESSION ?? []);
        }

        return new self();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return self::$body;
    }

    /**
     * @return mixed
     */
    public function toStdClass()
    {
        return json_decode(json_encode(self::$body));
    }
}
