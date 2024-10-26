<?php

namespace App\Foundation\Env;

interface DotEnvEnvironmentable
{
    /**
     * @param string $path
     * @return DotEnvEnvironmentable
     */
    public function load($path);

    /**
     * @return array
     */
    public function all();
}
