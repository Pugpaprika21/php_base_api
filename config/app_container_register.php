<?php

use App\DI\Container;

$container = new Container();

$container->set("env", function () {
    return env();
});

$container->set("database", function () {
    require_once __DIR__ . "../../app/Libs/RedBean.php";

    $env = $this->get("env");

    if (!R::testConnection()) {
        $dsn = sprintf(
            "%s:host=%s;dbname=%s",
            $env["DB_DRIVER"],
            $env["DB_HOST"],
            $env["DB_NAME"]
        );

        R::setup($dsn, $env["DB_USER"], $env["DB_PASS"]);
        R::debug($env["DB_DEBUG"]);
        R::ext("xdispense", function ($type) {
            return R::getRedBean()->dispense($type);
        });
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
