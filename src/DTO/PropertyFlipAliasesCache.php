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
     * @var array<array>
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
    public static function cache(AbstractDTO $dto)
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
    public static function find(AbstractDTO $dto): array
    {
        $class = get_class($dto);
        return self::$cache[$class] ?? null;
    }

    /**
     * キャッシュがあるか
     *
     * @param AbstractDTO $dto
     * @return boolean
     */
    public static function has(AbstractDTO $dto): bool
    {
        $class = get_class($dto);
        return isset(self::$cache[$class]);
    }
}
