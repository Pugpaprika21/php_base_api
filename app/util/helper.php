<?php

define("APP_CONTROLLER_NAMESPACE", "App\\Controllers\\");
define("APP_DI", "App\\DI\\");
define("APP_FOUNDTION", "App\\Foundation\\");
define("APP_REPOSITORY", "App\\Repository\\");
define("APP_HELPERS", "App\\Helpers\\");
define("APP_TYPE_WEB", "web");
define("APP_TYPE_API", "api");
define("ARR_UPPER_CASE", false);
define("URL_SCHEME", $_SERVER["REQUEST_SCHEME"] . "://" .  $_SERVER["SERVER_NAME"] . ":"  . $_SERVER["SERVER_PORT"] . "/");

function arr_upr($input, $case = MB_CASE_TITLE)
{
    $convToCamel = function ($str) {
        return str_replace(" ", "", ucwords(str_replace("_", " ", $str)));
    };

    if (is_object($input)) {
        $input = json_decode(json_encode($input), true);
    }

    $newArray = array();
    foreach ($input as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $newArray[$convToCamel($key)] = arr_upr($value, $case);
        } else {
            $newArray[$convToCamel($key)] = $value;
        }
    }
    return $newArray;
}

function dd($data)
{
    echo "<pre>";
    print_r($data);
    exit;
}

function conText($input)
{
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    return $input;
}

function route_parse_urls()
{
    $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off" || $_SERVER["SERVER_PORT"] == 443) ? "https://" : "http://";
    $host = $_SERVER["HTTP_HOST"];
    $requestUri = $_SERVER["REQUEST_URI"];

    $url = conText($protocol . $host . $requestUri);
    $queryAction = parse_url($url, PHP_URL_QUERY);
    $parts = explode("/", $queryAction);

    $route = isset($parts[1]) ? conText($parts[1]) : "";
    $controller = isset($parts[2]) ? conText($parts[2]) : "";
    $method = isset($parts[3]) ? conText($parts[3]) : "";
    //$path = $controller . "/" . $method;

    return [
        "route" => $route,
        "controller" => $controller,
        "method" => $method,
        //"path" => $path,
    ];
}

function str_or_object($instance)
{
    if (is_string($instance)) {
        if (class_exists($instance)) {
            return new $instance();
        } else {
            throw new InvalidArgumentException("Class $instance does not exist.");
        }
    }

    if (is_object($instance)) {
        return $instance;
    }

    throw new InvalidArgumentException("Argument must be a string or an object.");
}

function header_cors()
{
    $origin = array_key_exists("HTTP_ORIGIN", $_SERVER) ? $_SERVER["HTTP_ORIGIN"] : "";

    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Origin: " . $origin);
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

function env($key)
{
    $env = parse_ini_file("config/.env-local");
    return !empty($env[$key]) ? $env[$key] : "";
}