<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Collection\{
    ArrayCollection,
    AbstractTypeCollection,
};
use Takemo101\PHPSupport\Collection\Reducer\{
    Diff,
    Distinct,
    Only,
    Except,
};

/**
 * collection test
 */
class CollectionTest extends TestCase
{
    public function test__ArrayCollection__add__ok()
    {
        $last = 'd';

        $collection = new ArrayCollection([
            'a',
            'b',
            'c',
        ]);

        $startCount = $collection->count();

        $collection->add($last);

        $changeCount = $collection->count();

        $this->assertTrue($startCount != $changeCount);
        $this->assertEquals($last, $collection->last());
    }

    public function test__ArrayCollection__remove__ok()
    {
        $last = 'c';

        $collection = new ArrayCollection([
            'a',
            'b',
            $last,
        ]);

        $startCount = $collection->count();

        $collection->remove($startCount - 1);

        $changeCount = $collection->count();

        $this->assertTrue($startCount != $changeCount);
        $this->assertNotEquals($last, $collection->last());
    }

    public function test__TypeCollection__add__ok()
    {
        $last = 'd';

        $collection = new ElementCollection([
            new Element('a'),
            new Element('b'),
            new Element('c'),
        ]);

        $startCount = $collection->count();

        $collection->add(
            new Element($last)
        );

        $changeCount = $collection->count();

        $this->assertTrue($startCount != $changeCount);
        $this->assertEquals($last, $collection->last()->getValue());

        $collection->get(3)->setValue('e');

        $this->assertNotEquals($last, $collection->last()->getValue());
    }

    public function test__TypeCollection__remove__ok()
    {
        $last = 'c';

        $collection = new ElementCollection([
            new Element('a'),
            new Element('b'),
            new Element($last),
        ]);

        $startCount = $collection->count();

        $collection->remove($startCount - 1);

        $changeCount = $collection->count();

        $this->assertTrue($startCount != $changeCount);
        $this->assertNotEquals($last, $collection->last()->getValue());
    }

    public function test__ArrayCollection__reduce__ok()
    {
        $diffData = '1';
        $base = [
            'a' => $diffData,
            'b' => '2',
            'c' => '3',
        ];
        $data = [
            'a' => '2',
            'b' => '2',
            'c' => '3',
        ];

        $collection = ArrayCollection::of($base);
        $collection = $collection->reduce(new Diff($data));

        $this->assertEquals($collection->count(), 1);
        $this->assertEquals($collection->first(), $diffData);

        $base = [
            'a' => '2',
            'b' => '2',
            'c' => '4',
        ];

        $collection = ArrayCollection::of($base);
        $collection = $collection->reduce(new Distinct);

        $this->assertEquals($collection->count(), 1);
    }

    public function test__TypeCollection__reduce__ok()
    {
        $diffData = '1';
        $base = [
            'a' => new Element($diffData),
            'b' => new Element('2'),
            'c' => new ELement('3'),
        ];
        $data = [
            'a' => new Element('2'),
            'b' => new Element('2'),
            'c' => new Element('3'),
        ];

        $collection = ElementCollection::of($base);
        $collection = $collection->reduce(new Diff($data, true));

        $this->assertEquals($collection->count(), 1);
        $this->assertEquals($collection->first()->getValue(), $diffData);

        $base = [
            'a' => new Element('2'),
            'b' => new Element('2'),
            'c' => new Element('4'),
        ];

        $collection = ElementCollection::of($base);
        $collection = $collection->reduce(new Distinct);

        $this->assertEquals($collection->count(), 1);
    }
}

/**
 * test element class
 */
class Element
{
    /**
     * element value
     *
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}

/**
 * test element collection class
 */
class ElementCollection extends AbstractTypeCollection
{
    protected $type = Element::class;
}
