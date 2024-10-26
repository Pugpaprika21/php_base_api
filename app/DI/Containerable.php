<?php

namespace App\DI;

interface Containerable
{
    /**
     * @param string $container
     * @param callable $fn
     * @return void
     */
    public function set($container, $fn);

    /**
     * @param string $container
     * @return boolean
     */
    public function has($container);

    /**
     * @param string $container
     * @return mixed
     * @throws Exception
     */
    public function get($container);

    /**
     * @param string $interface
     * @return object
     * @throws Exception
     */
    public function repository($interface);

    /**
     * @param string $interface
     * @return object
     * @throws Exception
     */
    public function service($interface);
}
