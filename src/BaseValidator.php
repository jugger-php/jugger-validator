<?php

namespace jugger\validator;

abstract class BaseValidator
{
    public $message;

    abstract public function validate($value): bool;
}
