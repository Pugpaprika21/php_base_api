<?php

namespace App\DI;

use Exception;

class Container implements Containerable
{
    /**
     * @var array
     */
    private $building = [];

    /** 
     * @param string $container
     * @param callable $fn
     * @return void
     */
    public function set($container, $fn)
    {
        $this->building[$container] = $fn->bindTo($this, $this);
    }

    /**
     * @param string $container
     * @return mixed
     */
    public function get($container)
    {
        if (isset($this->building[$container])) {
            return ($this->building[$container])();
        }
        throw new Exception("Container not found: {$container}");
    }

    /**
     * @param string $interface
     * @return object
     */
    public function repository($interface)
    {
        if (interface_exists($interface) && strpos($interface, "Repository") !== false) {
            if (!empty($this->building["repository"])) {
                $instance = $this->building["repository"]()[$interface];
                return str_or_object($instance);
            }
            throw new Exception("Repository not found: {$interface}");
        }

        throw new Exception("Invalid interface or missing 'Repository' keyword: {$interface}");
    }
}