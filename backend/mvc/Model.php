<?php

namespace Mvc;

use PDO;

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') .';dbname=' . getenv('DB_NAME') . ';charset=utf8';
            $db = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));
        }

        return $db;
    }

    private static function validateInt($value) {
        if(!filter_var($value, FILTER_VALIDATE_INT)) {
            return "field must be an integer";
        }
    }

    private static function validateText($value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT)) {
            return "field must be text";
        }

        return false;
    }

    private static function validateEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "field must be email";
        }

        return false;
    }

    private static function validateLength($value, $max)
    {
        if (strlen($value) > $max) {
            return "length cannot be more than $max";
        }

        return false;
    }

    public static function validate($required, $request)
    {
        $invalid = [];

        foreach ($required as $field => $rules) {
            $fieldKey = ucfirst($field);
            if (!array_key_exists($field, $request) || empty($request[$field])) {
                $invalid[$fieldKey] = ['field is missing'];
            } else {
                $messages = [];
                $rules = explode("|", $rules);

                foreach ($rules as $rule) {
                    $nameAndParam = explode(":", $rule);
                    $name = array_shift($nameAndParam);
                    $param = array_pop($nameAndParam);
                    $method = 'validate' . ucfirst($name);

                    if ($param) {
                        $validated = self::$method($request[$field], $param);
                    } else {
                        $validated = self::$method($request[$field]);
                    }

                    if ($validated) {
                        array_push($messages, $validated);
                    }
                }
                if ($messages) $invalid[$fieldKey] = $messages;
            }
        }

        return $invalid;
    }
}
