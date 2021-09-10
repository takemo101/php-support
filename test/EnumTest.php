<?php


namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Enum\AbstractEnum;

/**
 * enum test
 */
class EnumTest extends TestCase
{
    public function test__Enum__value__ok()
    {
        $enum = Enum::One();
        $ofEnum = Enum::of($enum->value());

        $this->assertTrue($enum->equals($ofEnum));
        $this->assertEquals($enum->value(), $ofEnum->value());
    }

    public function test__Enum__asArry__ok()
    {
        $values = Enum::asArray();

        $this->assertTrue(is_array($values));
    }
}

/**
 * test enum class
 */
class Enum extends AbstractEnum
{
    const One = 'one';
    const Two = 'two';
    const Three = 'three';
}
