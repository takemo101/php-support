<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Bootstrap\Bootstrap;
use Takemo101\PHPSupport\Contract\Bootstrap\Loader;

/**
 * bootstrap test
 */
class BootstrapTest extends TestCase
{
    public function test__Bootstrap__boot__ok()
    {
        $dataA = LoaderA::$data;
        $dataB = LoaderB::$data;

        $boot = new Bootstrap;
        $boot->addLoader([
            LoaderA::class,
            LoaderB::class,
        ]);
        $boot->boot();

        $this->assertNotEquals(LoaderA::$data, $dataA);
        $this->assertNotEquals(LoaderB::$data, $dataB);
    }
}

class LoaderA implements Loader
{
    public static $data = 'a';

    public function load()
    {
        self::$data = 'c';
    }
}

class LoaderB implements Loader
{
    public static $data = 'b';

    public function load()
    {
        self::$data = 'c';
    }
}
