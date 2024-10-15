<?php

use App\DI\Container;

$container = new Container();

$container->set("database", function () {
    try {
        $env = env();

        $dsn = sprintf(
            "%s:host=%s;dbname=%s",
            $env["DB_DRIVER"],
            $env["DB_HOST"],
            $env["DB_NAME"]
        );

        require_once __DIR__ . "../../app/Libs/RedBean.php";

        R::setup($dsn, $env["DB_USER"], $env["DB_PASS"]);
        R::debug(false);
        R::ext("xcreate", function ($type) {
            return R::getRedBean()->dispense($type);
        });
    } catch (Exception $e) {
        throw new Exception("Database connection error: " . $e->getMessage(), 500);
    }
});

$container->set("repository", function () {
    $this->get("database");
    return require __DIR__ . "../../app/Repository/register.php";
});

$container->set("service", function () {
    return require __DIR__ . "../../app/Services/register.php";
});

$container->set("middleware", function () {
    return null;
});
