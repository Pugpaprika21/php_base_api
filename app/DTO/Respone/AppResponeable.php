<?php

namespace App\DTO\Respone;

use App\DTO\Http;

interface AppResponeable
{
    /**
     * @param integer $status
     * @return Responeable
     */
    public function status($status = Http::OK);

    /**
     * @param string $msg
     * @return Responeable
     */
    public function message($msg);

    /**
     * @param array|object $data
     * @return Responeable
     */
    public function data($data);

    /**
     * @return string|false
     */
    public function toJSON();

    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    public function view($path, $data = []);

    /**
     * @param array $headers
     * @return void
     */
    public function headers($headers);
}
