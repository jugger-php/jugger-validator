<?php

namespace jugger\validator;

class RangeValidator extends BaseValidator
{
    protected $min;
    protected $max;

    public function __construct(int $min, int $max = null)
    {
        $this->min = $min;
        $this->max = $max ?? 0;
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function validate($value): bool
    {
        $max = $this->max;
        $length = $this->getLength($value);
        if ($max == 0) {
            $max = $length + 1;
        }
        return $this->min < $length && $length < $max;
    }

    protected function getLength($value)
    {
        if (is_null($value)) {
            $length = 0;
        }
        elseif (!is_scalar($value)) {
            throw new \Exception("How should I do it?");
        }
        elseif (is_float($value) || is_int($value)) {
            $length = (float) $value;
        }
        else {
            $length = mb_strlen("{$value}");
        }
        return $length;
    }
}
