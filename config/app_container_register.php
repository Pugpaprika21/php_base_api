<?php

use App\DI\Container;
use App\Foundation\Env\DotEnvEnvironment;

$container = new Container();

$container->set(DotEnvEnvironment::class, function () {
    (new DotEnvEnvironment)->load("config/.env-local");
});

$container->set("database", function () {
    require_once __DIR__ . "../../app/Libs/RedBean.php";

    $this->get(DotEnvEnvironment::class);
    
    if (!R::testConnection()) {
        $dsn = sprintf(
            "%s:host=%s;dbname=%s",
            $_ENV["DB_DRIVER"],
            $_ENV["DB_HOST"],
            $_ENV["DB_NAME"]
        );

        R::setup($dsn, $_ENV["DB_USER"], $_ENV["DB_PASS"]);
        R::debug(false);
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
