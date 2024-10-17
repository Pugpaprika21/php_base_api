<?php

namespace App\DTO\Respone;

class AppResponeMessage
{
    /**
     * @param integer $status
     * @param array|object $data
     */
    private function __construct(
        public $status,
        public $message,
        public $data,
        public $total_rows
    ) {
        $this->status = $status;
        $this->data = $data;
        $this->total_rows = $total_rows;
    }

    /**
     * @param integer $status
     * @param string $message
     * @param array|object $data
     * @return self
     */
    public static function create($status, $message, $data)
    {
        return new self($status, $message, $data, self::totalRows($data));
    }

    /**
     * @param array|object $data
     * @return integer
     */
    private static function totalRows($data): int
    {
        if (is_array($data)) {
            return count($data);
        }
        if (is_object($data)) {
            return method_exists($data, 'toArray') ? count($data->toArray()) : count(get_object_vars($data));
        }
        return 0;
    }
}