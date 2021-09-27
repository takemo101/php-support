<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Path\Path;

/**
 * path test
 */
class PathTest extends TestCase
{
    public function test__Path__join__ok()
    {
        $path = Path::join('./a', 'b', 'c/d');

        $this->assertEquals(
            $path,
            './a/b/c/d'
        );
    }

    public function test__Path__split__ok()
    {
        $data = './ a//b/c/d';
        $split = Path::split($data);

        $this->assertEquals(
            count($split),
            5
        );
    }
}
