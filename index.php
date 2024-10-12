<?php

declare(strict_types=1);

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

        if (is_callable($handler)) {
            call_user_func($handler);
        }

        if (is_array($handler)) {
            if ((is_array($handler) && class_exists($handler[0]) && method_exists($handler[0], $handler[1]))) {
                call_user_func([new $handler[0]($container), $handler[1]]);
            } else {
                throw new Exception("Class or method not found.", 500);
            }
        }
    } else {
        throw new Exception("Route not found.", 404);
    }
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage(), "code" => $e->getCode()));
    exit;
}
