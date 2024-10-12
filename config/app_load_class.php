<?php

spl_autoload_register(function ($classname) {
    $app_config_paths = include "config/app_path_config_class.php";
    $class_parts = explode("\\", $classname);
    $class_filename = end($class_parts);

    foreach ($app_config_paths["app"] as $folder) {
        $class_filepath = $folder . $class_filename . ".php";
        if (file_exists($class_filepath)) {
            include_once $class_filepath;
            return;
        }
    }
});