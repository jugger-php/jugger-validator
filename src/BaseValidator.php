<?php

namespace jugger\validator;

abstract class BaseValidator
{
    abstract public function validate($value): bool;
}
