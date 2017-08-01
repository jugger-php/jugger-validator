<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use jugger\validator\EmailValidator;
use jugger\validator\RangeValidator;
use jugger\validator\RegexpValidator;
use jugger\validator\CompareValidator;
use jugger\validator\RequireValidator;
use jugger\validator\DynamicValidator;

class ValidatorTest extends TestCase
{
    public function testRequire()
    {
        $validator = new RequireValidator();
        $this->assertTrue(
            $validator->validate(0)
        );
        $this->assertTrue(
            $validator->validate('0')
        );
        $this->assertTrue(
            $validator->validate("")
        );
        $this->assertTrue(
            $validator->validate("abcdef")
        );
        $this->assertTrue(
            $validator->validate(true)
        );
        $this->assertFalse(
            $validator->validate(null)
        );
        $this->assertTrue(
            $validator->validate($validator)
        );
    }

    public function testEmail()
    {
        $validator = new EmailValidator();
        $this->assertTrue(
            $validator->validate("word@word.domain")
        );
        $this->assertTrue(
            $validator->validate("123@word.domain")
        );
        $this->assertTrue(
            $validator->validate("word@123.domain")
        );
        $this->assertTrue(
            $validator->validate("123-word@word.domain")
        );
        $this->assertTrue(
            $validator->validate("word@word-123.domain")
        );
        // false
        $this->assertFalse(
            $validator->validate("word.ru")
        );
        $this->assertFalse(
            $validator->validate("@word.ru")
        );
        $this->assertFalse(
            $validator->validate("word@ru")
        );
        $this->assertFalse(
            $validator->validate("word@.ru")
        );
        $this->assertFalse(
            $validator->validate("word@word.123")
        );
        $this->assertFalse(
            $validator->validate("word@word.word-word")
        );
    }

    public function testRange()
    {
        /**
         * strings
         */
        $validator = new RangeValidator(0);
        $this->assertFalse(
            $validator->validate(null)
        );
        $this->assertFalse(
            $validator->validate("")
        );
        $this->assertTrue(
            $validator->validate("1")
        );
        $validator = new RangeValidator(5, 10);
        $this->assertFalse(
            $validator->validate("12345")
        );
        $this->assertTrue(
            $validator->validate("123456789")
        );
        $this->assertFalse(
            $validator->validate("1234567890")
        );
        /**
         * numbers
         */
         $validator = new RangeValidator(0);
         $this->assertFalse(
             $validator->validate(0)
         );
         $this->assertTrue(
             $validator->validate(0.1)
         );
         $this->assertTrue(
             $validator->validate(1)
         );
         $validator = new RangeValidator(5, 10);
         $this->assertFalse(
             $validator->validate(-2)
         );
         $this->assertFalse(
             $validator->validate(2)
         );
         $this->assertFalse(
             $validator->validate(5)
         );
         $this->assertTrue(
             $validator->validate(7)
         );
         $this->assertFalse(
             $validator->validate(10)
         );
         $this->assertFalse(
             $validator->validate(123)
         );
    }

    public function testDynamic()
    {
        $validator = new DynamicValidator(function($value) {
            return true;
        });
        $this->assertTrue(
            $validator->validate(null)
        );
        $this->assertTrue(
            $validator->validate("")
        );
        $this->assertTrue(
            $validator->validate(-100)
        );
        $this->assertTrue(
            $validator->validate(0)
        );
        $this->assertTrue(
            $validator->validate([1,2,3])
        );
        //
        $validator = new DynamicValidator(function($value) {
            return (int)($value) > 7;
        });
        $this->assertFalse(
            $validator->validate(0)
        );
        $this->assertFalse(
            $validator->validate(7)
        );
        $this->assertTrue(
            $validator->validate(10)
        );
    }

    public function testCompare()
    {
        $validator = new CompareValidator("123", '==');
        $this->assertTrue(
            $validator->validate(123)
        );
        $this->assertFalse(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '===');
        $this->assertFalse(
            $validator->validate(123)
        );
        $this->assertFalse(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '!=');
        $this->assertFalse(
            $validator->validate(123)
        );
        $this->assertTrue(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '!==');
        $this->assertTrue(
            $validator->validate(123)
        );
        $this->assertTrue(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '>');
        $this->assertFalse(
            $validator->validate(123)
        );
        $this->assertFalse(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '>=');
        $this->assertTrue(
            $validator->validate(123)
        );
        $this->assertFalse(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '<');
        $this->assertFalse(
            $validator->validate(123)
        );
        $this->assertTrue(
            $validator->validate(456)
        );

        $validator = new CompareValidator("123", '<=');
        $this->assertTrue(
            $validator->validate(123)
        );
        $this->assertTrue(
            $validator->validate(456)
        );
    }
}
