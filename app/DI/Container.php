<?php

namespace App\DI;

use Throwable;

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
        throw new Throwable("Container not found: {$container}");
    }

    /**
     * @param string $interface
     * @param string $type
     * @return object
     * @throws Throwable
     */
    private function getInstance($interface, $type)
    {
        if (interface_exists($interface) && strpos($interface, ucfirst($type)) !== false) {
            if (!empty($this->building[$type])) {
                $instance = $this->building[$type]()[$interface];
                return str_or_object($instance);
            }
            throw new Throwable(ucfirst($type) . " not found: {$interface}");
        }
        throw new Throwable("Invalid interface or missing '{$type}' keyword: {$interface}");
    }
    
    /**
     * @param string $interface
     * @return object
     */
    public function repository($interface)
    {   
        return $this->getInstance($interface, "repository");
    }

    /**
     * @param string $interface
     * @return object
     */
    public function service($interface)
    {
        return $this->getInstance($interface, "service");
    }
}