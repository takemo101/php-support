<?php

namespace Takemo101\PHPSupport\DTO;

/**
 * DTOのaliasesをarray_filpで逆転したものをキャッシュ
 */
final class PropertyFlipAliasesCache
{
    /**
     * cache
     *
     * @var array[]
     */
    private static $cache = [
        //
    ];

    /**
     * キャッシュする
     *
     * @param string $class
     * @param array $aliases
     * @return void
     */
    public static function cache(AbstractObject $dto)
    {
        $class = get_class($dto);
        self::$cache[$class] = array_flip($dto->propertyAliases());
    }

    /**
     * キャッシュを取得
     *
     * @param string $class
     * @return array|null
     */
    public static function find(AbstractObject $dto): array
    {
        $class = get_class($dto);
        return self::$cache[$class] ?? null;
    }

    /**
     * キャッシュがあるか
     *
     * @param AbstractObject $dto
     * @return boolean
     */
    public static function has(AbstractObject $dto): bool
    {
        $class = get_class($dto);
        return isset(self::$cache[$class]);
    }
}
