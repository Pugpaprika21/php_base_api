<?php

namespace App\DTO\Respone;

use App\DTO\Http;

class AppRespone extends Http implements AppResponeable
{
    /**
     * @var integer
     */
    private $status = self::OK;

    /**
     * @var array|object
     */
    private $data = [];

    /**
     * @var string
     */
    private $message = "";

    /**
     * @param integer $status
     * @return Responeable
     */
    public function status($status = self::OK)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $message
     * @return Responeable
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param array|object $data
     * @return Responeable
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string|false
     */
    public function toJSON()
    {
        http_response_code($this->status);
        header("Content-Type: application/json; charset=utf-8");

        return json_encode(AppResponeMessage::create($this->status, $this->message, $this->data));
    }

    /**
     * @param string $path
     * @param array $data
     * @return string
     */
    public function view($path, $data = [])
    {
        $realpath = "views/" . $path;

        extract($data);

        ob_start();
        require $realpath;
        $output = ob_get_clean();

        return $output;
    }

    /**
     * @param array $headers
     * @return void
     */

    /* 
    $respone->headers([
        "Access-Control-Allow-Credentials: true",
        "Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization",
        "Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS",
        "Cache-Control: no-store, no-cache, must-revalidate, max-age=0",
        "Pragma: no-cache",
        "X-Custom-Header: Value"
    ]);
    */

    public function headers($headers)
    {
        header_remove();

        foreach ($headers as $header) {
            header($header);
        }

        return $this;
    }
}