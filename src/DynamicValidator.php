<?php

namespace jugger\validator;

class DynamicValidator extends BaseValidator
{
    protected $callback;

    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    public function validate($value): bool
    {
        return ($this->callback)($value);
    }
}
