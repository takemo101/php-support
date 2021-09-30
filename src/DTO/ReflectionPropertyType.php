<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Contract\DTO\PropertyType;

use ReflectionNamedType;
use ReflectionUnionType;

/**
 * リフクレションタイプ
 */
final class ReflectionPropertyType implements PropertyType
{
    /**
     * リフレクションタイプ
     *
     * @var ReflectionNamedType
     */
    private $type;

    /**
     * construct
     *
     * @param ReflectionNamedType $type
     */
    public function __construct(
        ReflectionNamedType $type
    ) {
        $this->type = $type;
    }

    /**
     * 型
     *
     * @return string
     */
    public function getTypeName(): string
    {
        $type = $this->type->getName();

        if ($this->isBuiltin()) {
            switch ($type) {
                case 'bool':
                    return 'boolean';
                case 'int':
                    return 'integer';
            }
        }

        return $type;
    }

    /**
     * プリミティブ（ビルドイン）型か
     *
     * @return boolean
     */
    public function isBuiltin(): bool
    {
        return $this->type->isBuiltin();
    }

    /**
     * null許容 or nullか
     *
     * @return boolean
     */
    public function isOptional(): bool
    {
        return $this->type->allowsNull();
    }

    /**
     * リフレクションタイプからインスタンス配列を生成
     *
     * @param ReflectionUnionType|ReflectionNamedType $type
     * @return ReflectionNamedType[]
     */
    public static function fromReflectionType(ReflectionUnionType|ReflectionNamedType $type): array
    {
        $types = $type instanceof ReflectionUnionType ? $type->getTypes() : [$type];

        $result = [];

        foreach ($types as $t) {
            $result[] = new static($t);
        }

        return $result;
    }
}
