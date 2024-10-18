<?php

namespace App\Foundation\Validator;

interface Validable
{
    /**
     * @param array $data
     * @param array $rules
     * @return boolean
     */
    public function validate($data, $rules);

    /**
     * @return array
     */
    public function errors();

    /**
     * @return boolean
     */
    public function hasErrors();
}
