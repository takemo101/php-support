<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Contract\DTO\TypeResolver as Contract;

/**
 * プロパティタイプのヘルパークラス
 */
final class TypeHelper
{
    /**
     * DTO type resolver
     *
     * @var null|Contract
     */
    protected static $typeResolver = null;

    /**
     * 型解決クラスをセットする
     *
     * @param Contract|null $typeResolver
     * @return void
     */
    public static function setTypeResolver(Contract $typeResolver = null)
    {
        self::$typeResolver = $typeResolver;
    }

    /**
     * プロパティのタイプと値をチェックして値をそのまま返す
     *
     * @param PropertyTypes $types
     * @param mixed $value
     * @throws PropertyTypeException
     * @return mixed
     */
    public static function check(PropertyTypes $types, $value)
    {
        // 型が一致しなければ一度型を解決する処理をして、それでも一致しなければ例外
        if (!$types->compare($value)) {
            if (self::$typeResolver) {
                // 値の型を解決する
                $resolve = self::$typeResolver->resolve($types, $value);
                if ($resolve !== $value && $types->compare($resolve)) {
                    return $resolve;
                }
            }

            $type = gettype($value);
            throw new PropertyTypeException("type does not match [{$type}]");
        }

        return $value;
    }

    /**
     * DTOのプロパティ変換
     *
     * @param AbstractDTO $dto
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public static function convert(AbstractDTO $dto, string $name, $value)
    {
        $converters = $dto->propertyConverters();

        if (array_key_exists($name, $converters)) {
            $converter = $converters[$name];

            if (is_callable($converter)) {
                return call_user_func($converter, $value);
            } else if (is_string($converter) && method_exists($dto, $converter)) {
                return call_user_func([$dto, $converter], $value);
            }
        }

        return $value;
    }
}
