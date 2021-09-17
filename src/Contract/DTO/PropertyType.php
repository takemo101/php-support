<?php

namespace Takemo101\PHPSupport\Contract\DTO;

/**
 * dto property type interface
 */
interface PropertyType
{

    /**
     * 型名
     *
     * @return string
     */
    public function getTypeName(): string;

    /**
     * プリミティブ（ビルドイン）型か
     *
     * @return boolean
     */
    public function isBuiltin(): bool;

    /**
     * null許容 or nullか
     *
     * @return boolean
     */
    public function isOptional(): bool;
}
