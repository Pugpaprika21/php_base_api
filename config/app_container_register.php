<?php

use App\DI\Container;
use App\Repository\UserableRepository;
use App\Repository\UserRepository;

$container = new Container();

$container->set("database", function () {
    try {
        require_once __DIR__ . "../../app/Libs/RedBean.php";
        R::setup("" . env("DB_DRIVER") . ":host=" .  env("DB_HOST") . ";dbname=" . env("DB_NAME") . "", env("DB_USER"), env("DB_PASS"));
        R::debug(false);
        R::ext("xdispense", function ($type) {
            return R::getRedBean()->dispense($type);
        });
    } catch (Exception $e) {
        throw new Exception($e->getMessage(), 500);
    }
});

$container->set("repository", function () {
    $this->get("database");
    return [
        UserableRepository::class => UserRepository::class,
    ];
});

$container->set("middleware", function () {
    return null;
});
