<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\{
    ViewModel\AbstractModel,
    ViewModel\ArrayAccessObject,
    Facade\Injector,
};

/**
 * view model test
 */
class ViewModelTest extends TestCase
{
    public function test__AbstractModel__ok()
    {
        $dataA = 'a';
        $dataB = 'b';
        $dataC = 'c';
        $dataD = 'd';
        Injector::singleton(ClassD::class, function ($c) use ($dataD) {
            return new ClassD($dataD);
        });

        $model = Model::of(
            $dataA,
            $dataB,
            $dataC
        )->toArray();

        $this->assertEquals($model['a'], $dataA);
        $this->assertEquals($model['b'], $dataB);
        $this->assertEquals($model['c'], $dataC);
        $this->assertEquals($model['d'], $dataD);
        $this->assertEquals($model['e'], 'e');
        $this->assertEquals($model['f'], 'f');
    }

    public function test__ArrayAccessObject__ok()
    {
        $dataA = 'a';
        $dataB = 'b';
        $dataC = [
            'c1' => [
                'c2' => 'hello'
            ],
        ];
        $dataD = 'd';
        Injector::singleton(ClassD::class, function ($c) use ($dataD) {
            return new ClassD($dataD);
        });

        $model = Model::of(
            $dataA,
            $dataB,
            $dataC
        );

        $obj = ArrayAccessObject::fromModel($model);

        $this->assertEquals($obj->a, $dataA);
        $this->assertEquals($obj->b, $dataB);
        $this->assertEquals($obj->c->c1->c2, $dataC['c1']['c2']);
        $this->assertEquals($obj->d, $dataD);
        $this->assertEquals($obj->e, 'e');
        $this->assertEquals($obj->f, 'f');
    }
}

class Model extends AbstractModel
{
    public function __construct(
        public string $a,
        private string $_b,
        private $_c
    ) {
        //
    }

    public function b()
    {
        return $this->_b;
    }

    public function c()
    {
        return $this->_c;
    }

    public function d(ClassD $d)
    {
        return $d->getD();
    }

    public function __data(): array
    {
        return [
            'e' => 'e',
            'f' => 'f',
        ];
    }
}

class ClassD
{
    public function __construct(private $d)
    {
        //
    }

    public function getD()
    {
        return $this->d;
    }

    public function setD($d)
    {
        $this->d = $d;
    }
}
