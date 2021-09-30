<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Facade\{
    AbstractFacade,
    Injector,
};

/**
 * facade test
 */
class FacadeTest extends TestCase
{
    public function test__Container__bind_string__ok()
    {
        Injector::bind(FacadeTargetA::class);
        $a = Injector::make(FacadeTargetA::class);

        $this->assertEquals(get_class($a), FacadeTargetA::class);

        $data = 'c';
        $a->setA($data);

        $a = Injector::make(FacadeTargetA::class);

        $this->assertNotEquals($a->getA(), $data);

        Injector::singleton(FacadeTargetB::class);
        $b = Injector::make(FacadeTargetB::class);

        $this->assertEquals(get_class($b), FacadeTargetB::class);

        $data = 'g';
        $b->setB($data);

        $b = Injector::make(FacadeTargetB::class);

        $this->assertEquals($b->getB(), $data);

        $alias = 'b';
        Injector::alias(FacadeTargetB::class, $alias);

        $b = Injector::make($alias);

        $this->assertEquals(get_class($b), FacadeTargetB::class);
        $this->assertEquals($b->getB(), $data);

        $this->assertTrue(Injector::has(FacadeTargetB::class));
        $this->assertTrue(Injector::has($alias));

        $c = Injector::make(FacadeTargetC::class);
        $this->assertEquals(get_class($c), FacadeTargetC::class);
        $this->assertTrue(Injector::has(FacadeTargetC::class));


        $data = 'hello';
        /**
         * @var FacadeTargetC $c
         */
        $c = Injector::make(FacadeTargetC::class, ['c' => $data]);
        $this->assertEquals($c->getC(), $data);

        Injector::clear();

        $this->assertTrue(!Injector::has(FacadeTargetB::class));
        $this->assertTrue(!Injector::has($alias));
    }

    public function test__Container__bind_Closure__ok()
    {
        Injector::bind(FacadeTargetA::class, function ($c) {
            return new FacadeTargetA;
        });
        $a = Injector::make(FacadeTargetA::class);

        $this->assertEquals(get_class($a), FacadeTargetA::class);

        $data = 'c';
        $a->setA($data);

        $a = Injector::make(FacadeTargetA::class);

        $this->assertNotEquals($a->getA(), $data);

        Injector::singleton(FacadeTargetB::class, function ($c) {
            return new FacadeTargetB;
        });

        $b = Injector::make(FacadeTargetB::class);

        $this->assertEquals(get_class($b), FacadeTargetB::class);

        $data = 'g';
        $b->setB($data);

        $b = Injector::make(FacadeTargetB::class);

        $this->assertEquals($b->getB(), $data);

        $alias = 'b';
        Injector::alias(FacadeTargetB::class, $alias);

        $b = Injector::make($alias);

        $this->assertEquals(get_class($b), FacadeTargetB::class);
        $this->assertEquals($b->getB(), $data);

        $this->assertTrue(Injector::has(FacadeTargetB::class));
        $this->assertTrue(Injector::has($alias));

        Injector::clear();

        $this->assertTrue(!Injector::has(FacadeTargetB::class));
        $this->assertTrue(!Injector::has($alias));
    }

    public function test__Facade__method__ok()
    {
        $data = 'c';
        Facade::setA($data);

        $this->assertEquals(Facade::getA(), $data);

        $b = FacadeB::getB();
        $data = 'ccc';
        FacadeB::setB($data);

        $this->assertNotEquals($b, $data);
    }

    public function test__Facade__binding__ok()
    {
        $data = 'c';

        Facade::binding(function ($c) use ($data) {
            $a = new FacadeTargetA;
            $a->setA($data);

            return $a;
        });

        $this->assertEquals(Facade::getA(), $data);
    }
}

class FacadeTargetA
{
    private $a = 'a';

    public function setA($a)
    {
        $this->a = $a;
    }

    public function getA()
    {
        return $this->a;
    }
}

class FacadeTargetB
{
    private $b = 'b';

    public function setB($b)
    {
        $this->b = $b;
    }

    public function getB()
    {
        return $this->b;
    }
}

class FacadeTargetC
{
    public function __construct(
        private FacadeTargetB $b,
        private FacadeTargetA $a,
        private $c = 'C',
    ) {
        //
    }

    public function getB($b)
    {
        return $this->b;
    }

    public function getA()
    {
        return $this->a;
    }

    public function getC()
    {
        return $this->c;
    }
}

/**
 * @method static string getA()
 * @method static void setA(string $a)

 * @see FacadeTargetA
 */
class Facade extends AbstractFacade
{
    protected static function accessor(): string|object
    {
        return FacadeTargetA::class;
    }
}

/**
 * @method static string getA()
 * @method static void setA(string $a)

 * @see FacadeTargetA
 */
class FacadeB extends AbstractFacade
{
    protected static function accessor(): string|object
    {
        return new FacadeTargetB;
    }
}
