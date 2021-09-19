<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\DTO\{
    AbstractDTO,
    AccessGetter,
    AccessSetter,
};
use Takemo101\PHPSupport\Contract\DTO\Faker;

use stdClass;

/**
 * dto test
 */
class DTOTest extends TestCase
{
    public function test__DTO__construct__ok()
    {
        $a = 'a';
        $b = 2;
        $c = null;
        $d = new stdClass;
        $e = 'e';

        $dto = new DTO([
            'a' => $a,
            'b' => $b,
            'cc' => $c,
            'd' => $d,
            'e' => $e,
        ]);

        $this->assertEquals($dto->getA(), $a);
        $this->assertEquals($dto->getB(), $b);
        $this->assertEquals($dto->getC(), $c);
        $this->assertTrue($dto->getD() instanceof $d);
        $this->assertTrue($dto->getE() instanceof PropTypeContract);
    }

    public function test__FakeFactory__faker__ok()
    {
        $dto = DTO::fake();

        $this->assertTrue($dto->getD() instanceof stdClass);
    }

    public function test__DTO__toArray__ok()
    {
        $dto = DTO::fake();
        $array = $dto->toArray();

        $this->assertTrue(isset($array['a']));
    }

    public function test__DTO__getter_setter__ok()
    {
        $dto = DTO::fake();

        $a = 'z';
        $b = 100;
        $c = 'zezezez';

        $dto->a = $a;
        $dto->b = $b;
        $dto->c = $c;

        $this->assertEquals($dto->a, $a);
        $this->assertEquals($dto->b, $b);
        $this->assertEquals($dto->c, $c);
    }
}

class DTO extends AbstractDTO implements Faker
{
    use AccessGetter, AccessSetter;

    /**
     * DTOの初期値からプロパティへの別名
     *
     * @var array
     */
    protected $__aliases = [
        'c' => 'cc',
    ];

    /**
     * 初期値をセットするときの変換処理の設定
     *
     * @var array
     */
    protected $__converters = [
        'e' => 'convertPropType',
    ];

    /**
     * @var string
     */
    private string $a = 'string';

    /**
     * @var integer
     */
    private $b = 1;

    /**
     * DTO Property
     *
     * @var mixed
     */
    private $c = 'mixed';

    private ?stdClass $d = null;

    /**
     * @var \Test\PropTypeContract
     */
    private $e;

    public function getA(): string
    {
        return $this->a;
    }

    public function getB(): int
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }

    public function getD(): ?stdClass
    {
        return $this->d;
    }

    public function getE(): PropTypeContract
    {
        return $this->e;
    }

    public function convertPropType(string $e): PropTypeContract
    {
        return new PropType($e);
    }

    /**
     * fake parameter
     *
     * @return array
     */
    public function fakeParameter(): array
    {
        return [
            'a' => 'a',
            'b' => 1,
            'cc' => null,
            'd' => new stdClass,
            'e' => 'e',
        ];
    }
}

interface PropTypeContract
{
    //
}

class PropType implements PropTypeContract
{
    public $e;

    public function __construct(string $e)
    {
        $this->e = $e;
    }
}
