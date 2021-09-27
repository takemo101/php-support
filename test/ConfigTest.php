<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Config\Config;
use Takemo101\PHPSupport\Path\Path;

/**
 * config test
 */
class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        Config::instance(Path::join(
            __DIR__,
            'Config'
        ));
    }

    public function test__Config__load__ok()
    {
        $namespace = 'config';
        Config::load(Path::join(
            __DIR__,
            'Config'
        ), $namespace);

        $get = Config::get($namespace . '::config1.a.b1');

        $this->assertEquals($get, 'b1');
    }

    public function test__Config__loadBy__ok()
    {
        $key = 'config3';
        Config::loadBy($key, function () {
            return [
                'a' => [
                    'c1' => 'c1',
                    'c2' => 'c2',
                ]
            ];
        });

        $get = Config::get($key . '.a.c1');

        $this->assertEquals($get, 'c1');
    }

    public function test__Config__get__ok()
    {
        $get = Config::get('config1.a.b1');

        $this->assertEquals($get, 'b1');
    }

    public function test__Config__set__ok()
    {
        $data = 'c1';
        $key = 'config1.a.b1';
        Config::set($key, $data);
        $get = Config::get($key);

        $this->assertEquals($get, $data);
    }
}
