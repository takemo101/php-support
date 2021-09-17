<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Collection\AbstractTypeCollection;

/**
 * プロパティタイプコレクションのキャッシュ
 */
final class PropertyTypesCollectionCache
{
    /**
     * cache
     *
     * @var array<PropertyTypesCollection>
     */
    private static $cache = [
        //
    ];

    /**
     * キャッシュする
     *
     * @param string $class
     * @param PropertyTypesCollection $collection
     * @return void
     */
    public static function cache(AbstractDTO $dto, PropertyTypesCollection $collection)
    {
        $class = get_class($dto);
        self::$cache[$class] = $collection;
    }

    /**
     * キャッシュを取得
     *
     * @param string $class
     * @return PropertyTypesCollection|null
     */
    public static function find(AbstractDTO $dto): PropertyTypesCollection
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
