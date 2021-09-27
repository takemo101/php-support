<?php

namespace Takemo101\PHPSupport\DTO;

use InvalidArgumentException;
use Takemo101\PHPSupport\Contract\DTO\Faker;

final class FakeFactory
{
    /**
     * フェイクDTOインスタンスを生成
     *
     * @param string $class
     * @throws InvalidArgumentException
     * @return AbstractObject
     */
    public static function make(string $class): AbstractObject
    {
        $dto = new $class;
        return self::makeByObject($dto);
    }

    /**
     * DTOインスタンスからフェイクDTOインスタンスを生成
     *
     * @param string $class
     * @throws InvalidArgumentException
     * @return AbstractObject
     */
    public static function makeByObject(AbstractObject $dto): AbstractObject
    {
        if (!($dto instanceof Faker)) {
            throw new InvalidArgumentException("Faker is not implemented");
        }

        $class = get_class($dto);

        return new $class($dto->fakeParameter());
    }
}
