<?php

namespace App\Foundation\Env;

class DotEnvEnvironment implements DotEnvEnvironmentable
{
    /**
     * @var array
     */
    private $allEnvSetting = [];
    /**
     * @param string $path
     * @return DotEnvEnvironmentable
     */
    public function load($path)
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) || strpos($line, "#") === 0) {
                continue;
            }

            $parts = explode("=", $line, 2);
            if (count($parts) < 2) {
                continue;
            }

            list($key, $value) = $parts;
            $key = trim($key);
            $value = trim($value);

            putenv(sprintf("%s=%s", $key, $value));
            $_ENV[$key] = $value;

            $this->allEnvSetting[$key] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->allEnvSetting;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function key($key)
    {
        return $this->allEnvSetting[$key];
    }
}
