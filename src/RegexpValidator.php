<?php

namespace jugger\validator;

class RegexpValidator extends BaseValidator
{
    protected $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function validate($value): bool
    {
        return !empty($value) && preg_match($this->pattern, $value) === 1;
    }
}
