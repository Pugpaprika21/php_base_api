<?php

namespace App\DTO\Respone;

class AppResponeMessage
{
    /**
     * @param integer $status
     * @param array|object $data
     */
    private function __construct(
        public int $status,
        public string $message,
        public array|object $data,
        public int $totalRows
    ) {
        $this->status = $status;
        $this->data = $data;
        $this->totalRows = $totalRows;
    }

    /**
     * @param integer $status
     * @param string $message
     * @param array|object $data
     * @return self
     */
    public static function create(int $status, string $message, array|object $data): self
    {
        return new self($status, $message, $data, self::totalRows($data));
    }

    /**
     * @param array|object $data
     * @return integer
     */
    private static function totalRows(array|object $data): int
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