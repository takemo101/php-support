<?php

namespace Takemo101\PHPSupport\DTO;

use ReflectionProperty;
use Exception;
use Takemo101\PHPSupport\Contract\DTO\TypeResolver as Contract;

/**
 * シンプルな型解決クラス
 */
final class TypeResolver implements Contract
{
    /**
     * タイプ解決処理
     *
     * @param PropertyTypes $types
     * @param mixed $value
     * @return mixed
     */
    public function resolve(PropertyTypes $types, $value)
    {
        if ($type = $types->firstInstanceType()) {
            $class = $type->getTypeName();

            if (class_exists($class)) {
                try {
                    $value = new $class($value);
                } catch (Exception $e) {
                    return $value;
                }
            }
        }

        return $value;
    }
}
