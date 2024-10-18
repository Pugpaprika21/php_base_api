<?php

/* 

$data = [
    "name" => "John Doe",
    "email" => "john@example.com",
    "age" => "30",
    "website" => "http://example.com"
];

$rules = [
    "name" => ["required", "min:3", "max:50"],
    "email" => ["required", "email"],
    "age" => ["required", "numeric", "min:18"],
    "website" => ["url"]
];

*/

namespace App\Foundation\Validator;

class Validator implements Validable
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param array $data
     * @param array $rules
     * @return boolean
     */
    public function validate($data, $rules)
    {
        foreach ($rules as $field => $rulesArray) {
            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $data[$field] ?? null, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $rule
     * @return void
     */
    private function applyRule($field, $value, $rule)
    {
        [$ruleName, $parameter] = $this->parseRule($rule);

        $method = "validate" . ucfirst($ruleName);
        if (method_exists($this, $method)) {
            $this->$method($field, $value, $parameter);
        } else {
            $this->addError($field, "$ruleName is not a valid rule.");
        }
    }

    /**
     * @param string $rule
     * @return array
     */
    private function parseRule($rule)
    {
        if (strpos($rule, ":") !== false) {
            return explode(":", $rule, 2);
        }

        return [$rule, null];
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateRequired($field, $value, $parameter)
    {
        if ($value === null || $value === "") {
            $this->addError($field, "$field is required.");
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateEmail($field, $value, $parameter)
    {
        if ($value !== null && $value !== "" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "$field must be a valid email address.");
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateMin($field, $value, $parameter)
    {
        if ($value !== null && $value !== "" && strlen($value) < (int)$parameter) {
            $this->addError($field, "$field must be at least $parameter characters.");
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateMax($field, $value, $parameter)
    {
        if ($value !== null && strlen($value) > (int)$parameter) {
            $this->addError($field, "$field must not exceed $parameter characters.");
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateNumeric($field, $value, $parameter)
    {
        if ($value !== null && $value !== "" && !is_numeric($value)) {
            $this->addError($field, "$field must be a numeric value.");
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|null $parameter
     * @return void
     */
    private function validateType(string $field, $value, ?string $type): void
    {
        if ($value !== null && !$this->checkType($value, $type)) {
            $this->addError($field, "$field must be of type $type.");
        }
    }

    /**
     * @param mixed $value
     * @param string|null $type
     * @return boolean
     */
    private function checkType($value, $type)
    {
        if ($type === null) {
            return false;
        }

        $typeCheckers = [
            "string" => "is_string",
            "integer" => "is_int",
            "boolean" => "is_bool",
            "array" => "is_array",
            "float" => "is_float",
            "object" => "is_object",
            "resource" => "is_resource"
        ];

        return isset($typeCheckers[$type]) && $typeCheckers[$type]($value);
    }

    /**
     * @param string $field
     * @param string $message
     * @return void
     */
    private function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @return boolean
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }
}
