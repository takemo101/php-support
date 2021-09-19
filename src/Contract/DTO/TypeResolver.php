<?php

namespace Takemo101\PHPSupport\Contract\DTO;

use Takemo101\PHPSupport\DTO\PropertyTypes;

/**
 * dto type resolver interface
 */
interface TypeResolver
{
    /**
     * タイプ解決処理
     *
     * @param PropertyTypes $types
     * @param mixed $value
     * @return mixed
     */
    public function resolve(PropertyTypes $types, $value);
}
