<?php

declare(strict_types=1);

use App\DTO\Request\AppRequest;
use App\DTO\Respone\AppRespone;

try {
    require_once __DIR__ . "../app/util/helper.php";
    require_once __DIR__ . "../config/app_load_class.php";
    require_once __DIR__ . "../config/app_container_register.php";

    $app = route_parse_urls();

    $route = trim($app["route"]);
    $controller = trim($app["controller"]);
    $method = trim($app["method"]);

    $paths = require __DIR__ . "../app/routes/routes.php";

    if (isset($paths[$route][$controller][$method])) {
        $handler = $paths[$route][$controller][$method];
        unset($contrloler, $method);

        $request = new AppRequest();
        $respone = new AppRespone();

        if (is_callable($handler)) {
            call_user_func($handler, $request, $respone);
        }

        if (is_array($handler)) {
            if ((is_array($handler) && class_exists($handler[0]) && method_exists($handler[0], $handler[1]))) {
                call_user_func([new $handler[0]($container), $handler[1]], $request, $respone);
            } else {
                throw new Exception("Class or method not found.", 500);
            }
        }
    } else {
        throw new Exception("Route not found.", 404);
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(["message" => $e->getMessage(), "code" => $e->getCode()], JSON_PRETTY_PRINT);
}
