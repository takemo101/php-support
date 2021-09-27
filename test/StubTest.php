<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\{
    Path\Path,
    Stub\Creator,
    File\System,
};

/**
 * stub test
 */
class StubTest extends TestCase
{
    public function test__Path__create__ok()
    {
        $from = $this->path('test.stub');
        $toA = $this->path('Stub/{{ name }}/Classes/StubA.php');
        $toB = $this->path('Stub/{{ name }}/Classes/StubB.php');
        $data = [
            'name' => 'Name',
        ];
        $creator = Creator::ofPaths([
            $from => [
                $toA,
                $toB,
            ],
        ])
            ->create($data);

        $toAPath = $creator->parse($toA, $data);
        $toBPath = $creator->parse($toB, $data);

        $this->assertTrue(System::exists($toAPath));
        $this->assertTrue(System::exists($toBPath));

        System::deleteDirectory($this->path('Stub'), false);
    }

    public function path(string $file = ''): string
    {
        $path = Path::join(__DIR__, 'stub');
        return $file ? Path::join($path, $file) : $path;
    }
}
