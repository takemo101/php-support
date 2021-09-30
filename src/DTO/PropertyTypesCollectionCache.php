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
     * @var PropertyTypesCollection[]
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
    public static function cache(AbstractObject $dto, PropertyTypesCollection $collection)
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
    public static function find(AbstractObject $dto): PropertyTypesCollection
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
