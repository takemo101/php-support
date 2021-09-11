<?php


namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Arr\Arr;

/**
 * arr test
 */
class ArrTest extends TestCase
{
    public function test__Arr__get__ok()
    {
        $data = 'data';
        $array = [
            'a' => [
                'b' => [
                    'c' => $data,
                ],
            ],
        ];

        $get = Arr::get($array, 'a.b.c');

        $this->assertEquals($get, $data);
    }

    public function test__Arr__set__ok()
    {
        $data = 'data';
        $array = [
            'a' => [
                'b' => [
                    'c' => 'c',
                ],
            ],
        ];

        Arr::set($array, 'a.b.c', $data);

        $this->assertEquals(Arr::get($array, 'a.b.c'), $data);
    }

    public function test__Arr__forget__ok()
    {
        $key = 'a.b.c';
        $array = [
            'a' => [
                'b' => [
                    'c' => 'c',
                ],
            ],
        ];

        Arr::forget($array, $key);

        $this->assertTrue(!Arr::has($array, $key));
    }

    public function test__Arr__dot__ok()
    {
        $key = 'a.b.c';
        $array = [
            'a' => [
                'b' => [
                    'c' => 'c',
                ],
            ],
            'b' => 'b',
        ];

        $dot = Arr::dot($array);

        $this->assertEquals(count($dot), 2);
        $this->assertTrue(array_key_exists($key, $dot));
    }

    public function test__Arr__undot__ok()
    {
        $key = 'a.b.c';

        $undot = Arr::undot([
            $key => 'c',
        ]);

        $this->assertTrue(Arr::has($undot, $key));
    }
}
