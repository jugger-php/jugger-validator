<?php

namespace jugger\validator;

class EmailValidator extends RegexpValidator
{
    public function __construct()
    {
        parent::__construct('/^[0-9a-z\-]+\@[0-9a-z\-]+\.[a-z]+$/i');
    }
}
