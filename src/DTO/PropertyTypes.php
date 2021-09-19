<?php

namespace Takemo101\PHPSupport\DTO;

use ReflectionProperty;
use Takemo101\PHPSupport\Contract\DTO\PropertyType;

/**
 * プロパティタイプコレクション
 */
final class PropertyTypes
{
    /**
     * @var array<PropertyType>
     */
    private $types = [];

    /**
     * construct
     *
     * @param array $types
     */
    public function __construct(array $types = [])
    {
        foreach ($types as $type) {
            $this->addType($type);
        }
    }

    /**
     * プロパティタイプ追加
     *
     * @param PropertyType $type
     * @return self
     */
    public function addType(PropertyType $type): self
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * コレクションのタイプと値のタイプが一致するか
     *
     * @param mixed $value
     * @return boolean
     */
    public function compare($value): bool
    {
        // タイプが何もなければ true
        if ($this->isEmpty()) {
            return true;
        }

        $valueType = gettype($value);
        $isNULL = is_null($value);

        foreach ($this->getTypes() as $type) {
            $propertyType = $type->getTypeName();

            // なんでも型の場合は全てtrue
            if ($propertyType == 'mixed') {
                return true;
            }

            // null許可の場合
            if ($isNULL) {
                if ($type->isOptional()) {
                    return true;
                }
            } else {
                // プリミティブ型の場合
                if ($type->isBuiltin()) {
                    if ($valueType == $propertyType) {
                        return true;
                    }
                } else if (
                    (class_exists($propertyType) || interface_exists($propertyType)) &&
                    ($value instanceof $propertyType)
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * プロパティタイプリスト
     *
     * @return array<PropertyType>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * プロパティタイプが空か
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return count($this->types) == 0;
    }

    /**
     * ReflectionPropertyからインスタンス生成
     *
     * @param ReflectionProperty $property
     * @return self
     */
    public static function fromReflectionProperty(ReflectionProperty $property): self
    {
        $types = [];

        if ($property->hasType()) {
            $types = ReflectionPropertyType::fromReflectionType(
                $property->getType()
            );
        } else if ($comment = $property->getDocComment()) {
            $types = CommentPropertyType::fromCommentString($comment);
        }

        return new static($types);
    }
}
