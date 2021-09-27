<?php


namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\File\System;
use Takemo101\PHPSupport\Path\Path;

/**
 * file test
 */
class FileTest extends TestCase
{
    public function test__System__exists__ok()
    {
        $path = $this->path('exists');
        System::write($path, 'content');

        $this->assertTrue(System::exists($path));

        System::delete($path);
    }

    public function test__System__read__ok()
    {
        $path = $this->path('read');
        $content = 'content';
        System::write($path, $content);

        $this->assertEquals(System::read($path), $content);

        System::delete($path);
    }

    public function test__System__write__ok()
    {
        $path = $this->path('write');

        $this->assertTrue(System::write($path, 'content'));

        System::delete($path);
    }

    public function test__System__prepend__ok()
    {
        $path = $this->path('prepend');
        $content = 'content';
        $prepend = 'prepend';
        System::write($path, $content);

        System::prepend($path, $prepend);
        System::prepend($path, $prepend);

        $this->assertEquals(System::read($path), $prepend . $prepend . $content);

        System::delete($path);
    }

    public function test__System__append__ok()
    {
        $path = $this->path('append');
        $content = 'content';
        $append = 'append';
        System::write($path, $content);

        System::append($path, $append);
        System::append($path, $append);

        $this->assertEquals(System::read($path), $content . $append . $append);

        System::delete($path);
    }

    public function test__System__delete__ok()
    {
        $path = $this->path('delete');
        System::write($path, 'content');

        $this->assertTrue(System::exists($path));

        System::delete($path);

        $this->assertTrue(!System::exists($path));
    }

    public function test__System__chmod__ok()
    {
        $path = $this->path('chmod');
        System::write($path, 'content');
        System::chmod($path, 0777);

        $this->assertEquals(System::permission($path) & 0777, 0777);

        System::delete($path);
    }

    public function test__System__copy__ok()
    {
        $directory = $this->path('copy-directory');
        System::deleteDirectory($directory, false);
        System::makeDirectory($directory);

        $path = $this->path('copy');
        System::write($path, 'content');
        $copy = $directory . '/copy';
        System::copy($path, $copy);

        $this->assertTrue(System::exists($copy));

        System::delete($path);
        System::deleteDirectory($directory, false);
    }

    public function test__System__move__ok()
    {
        $directory = $this->path('move-directory');
        System::deleteDirectory($directory, false);
        System::makeDirectory($directory);

        $path = $this->path('move');
        System::write($path, 'content');
        $move = $directory . '/move';
        System::move($path, $move);

        $this->assertTrue(!System::exists($path));
        $this->assertTrue(System::exists($move));

        System::deleteDirectory($directory, false);
    }

    public function test__System__symlink__ok()
    {
        $directory = $this->path('link-directory');
        System::deleteDirectory($directory, false);
        System::makeDirectory($directory);

        $path = $this->path('link');
        System::delete($path);
        System::symlink($directory, $path);

        $this->assertTrue(System::isLink($path));

        System::delete($path);
        System::deleteDirectory($directory, false);
    }

    public function test__System__glob__ok()
    {
        $files = [
            'a',
            'b',
            'c',
        ];

        foreach ($files as $file) {
            $path = $this->path($file);
            System::write($path, 'content');
        }

        $glob = System::glob($this->path('*'));

        foreach ($files as $index => $file) {
            $path = $this->path($file);
            System::delete($path);

            $this->assertEquals($glob[$index], $path);
        }
    }

    public function test__System__makeDirectory__ok()
    {
        $directory = $this->path('make-directory');
        System::makeDirectory($directory);

        $this->assertTrue(System::isDirectory($directory));

        System::deleteDirectory($directory, false);
    }

    public function test__System__moveDirectory__ok()
    {
        $directory = $this->path('move-directory');
        System::makeDirectory($directory);

        $files = [
            'a',
            'b',
            'c',
        ];

        foreach ($files as $file) {
            $path = Path::join($directory, $file);
            System::write($path, 'content');
        }

        $toDirectory = $this->path('to-directory');

        System::moveDirectory($directory, $toDirectory);

        foreach ($files as $file) {
            $ph = Path::join($toDirectory, $file);
            $this->assertTrue(System::exists($ph));
        }

        System::deleteDirectory($directory, false);
        System::deleteDirectory($toDirectory, false);
    }

    public function test__System__copyDirectory__ok()
    {
        $directory = $this->path('copy-directory');
        System::makeDirectory($directory);

        $files = [
            'a',
            'b',
            'c',
        ];

        foreach ($files as $file) {
            $path = Path::join($directory, $file);
            System::write($path, 'content');
        }

        $toDirectory = $this->path('to-directory');

        System::copyDirectory($directory, $toDirectory);

        foreach ($files as $file) {
            $ph = Path::join($toDirectory, $file);
            $this->assertTrue(System::exists($ph));
            $ph = Path::join($directory, $file);
            $this->assertTrue(System::exists($ph));
        }

        System::deleteDirectory($directory, false);
        System::deleteDirectory($toDirectory, false);
    }

    public function path(string $file = ''): string
    {
        $path = Path::join(__DIR__, 'file');
        return $file ? Path::join($path, $file) : $path;
    }
}
