<?php

namespace Core;

class Validator {
    protected $errors = [];

    public function validate(array $data, array $rules) {
        foreach ($rules as $field => $rule) {
            $rule = explode('|', $rule);
            foreach ($rule as $r) {
                $r = explode(':', $r);
                switch ($r[0]) {
                    case 'required':
                        if (!array_key_exists($field, $data) || empty($data[$field])) {
                            $this->errors[$field][] = "$field is required";
                        }
                        break;
                    case 'integer':
                        if (!is_numeric($data[$field])) {
                            $this->errors[$field][] = "$field must be integer";
                        }
                        break;
                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$field][] = "$field is not a valid email address";
                        }
                        break;
                    case 'min':
                        if (strlen($data[$field]) < $r[1]) {
                            $this->errors[$field][] = "$field must be at least $r[1] characters long";
                        }
                        break;
                    case 'max':
                        if (strlen($data[$field]) > $r[1]) {
                            $this->errors[$field][] = "$field can't be longer than $r[1] characters";
                        }
                        break;
                }
            }
        }
        return $this;
    }

    public function fails() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}