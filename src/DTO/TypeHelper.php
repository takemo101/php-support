<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Contract\DTO\TypeResolver as Contract;

/**
 * プロパティタイプのヘルパークラス
 */
final class TypeHelper
{
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
}
