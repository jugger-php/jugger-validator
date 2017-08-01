<?php

namespace jugger\validator;

class CompareValidator extends BaseValidator
{
    protected $operator;
    protected $compareValue;

    public function __construct($compareValue, string $operator)
    {
        $this->operator = $operator;
        $this->compareValue = $compareValue;
    }

    public function validate($a): bool
    {
        $b = $this->compareValue;
        switch ($this->operator) {
            case '==':
                return $b == $a;
            case '===':
                return $b === $a;
            case '!=':
                return $b != $a;
            case '!==':
                return $b !== $a;
            case '>':
                return $b > $a;
            case '>=':
                return $b >= $a;
            case '<':
                return $b < $a;
            case '<=':
                return $b <= $a;
            default:
                throw new \Exception("Invalide operator is '{$this->operator}'");
        }
    }
}
