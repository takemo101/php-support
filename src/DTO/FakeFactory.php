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
     * @return AbstractDTO
     */
    public static function make(string $class): AbstractDTO
    {
        $dto = new $class;
        return self::makeByDTO($dto);
    }

    /**
     * DTOインスタンスからフェイクDTOインスタンスを生成
     *
     * @param string $class
     * @throws InvalidArgumentException
     * @return AbstractDTO
     */
    public static function makeByDTO(AbstractDTO $dto): AbstractDTO
    {
        if (!($dto instanceof Faker)) {
            throw new InvalidArgumentException("Faker is not implemented");
        }

        $class = get_class($dto);

        return new $class($dto->fakeParameter());
    }
}
