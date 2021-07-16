<?php


namespace App\Http\Services;


use JetBrains\PhpStorm\Pure;

class TypeService
{
    public const STRING = 'string';
    public const INT = 'int';
    public const FLOAT = 'float';
    public const BOOL = 'bool';
    public const DATETIME = 'datetime';

    /**
     * Get data type of the value.
     *
     * @param $value
     * @return string
     */
    #[Pure]
    public function getType($value): string
    {
        $type = self::STRING;

        if ($this->isInt($value)) {
            $type = self::INT;
        } elseif ($this->isFloat($value)) {
            $type = self::FLOAT;
        } elseif ($this->isBool($value)) {
            $type = self::BOOL;
        } elseif ($this->isDate($value)) {
            $type = self::DATETIME;
        }

        return $type;
    }

    public function isInt($value): bool
    {
        $trimmed = trim($value);
        return !empty($trimmed) && ctype_digit($trimmed);
    }

    public function isFloat($value): bool
    {
        $trimmed = trim($value);
        return is_numeric($trimmed) && !ctype_digit($trimmed);
    }

    public function isBool($value): bool
    {
        $lower = strtolower($value);

        return $lower == 'true' || $lower == 'false';
    }

    public function isDate($value): bool
    {
        return strtotime($value) && strlen($value) > 1;
    }
}
