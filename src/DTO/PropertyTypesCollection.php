<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Collection\AbstractTypeCollection;

use ReflectionProperty;
use ReflectionClass;

/**
 * プロパティタイプコレクション
 */
final class PropertyTypesCollection extends AbstractTypeCollection
{
    /**
     * コレクション要素の型
     *
     * @var string
     */
    protected $type = PropertyTypes::class;

    /**
     * プロパティタイプリストを追加
     *
     * @param string $name
     * @param PropertyTypes $types
     * @return self
     */
    public function addPropertyTypes(string $name, PropertyTypes $types): self
    {
        return $this->set($name, $types);
    }

    /**
     * プロパティタイプリストを取得
     *
     * @param string $name
     * @return PropertyTypes|null
     */
    public function findByPropertyName(string $name): ?PropertyTypes
    {
        return $this->get($name);
    }

    /**
     * AbstractDTOからcollectionを生成する
     *
     * @param AbstractDTO $dto
     * @return self
     */
    public static function fromDTO(AbstractDTO $dto): self
    {
        if (!PropertyTypesCollectionCache::has($dto)) {
            // キャッシュにコレクションがなければ生成処理をする
            $reflection = new ReflectionClass($dto);

            // private と protected を DTOプロパティとする
            $properties = $reflection->getProperties(
                ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED
            );

            $collection = new static();

            foreach ($properties as $property) {
                if ($property->isStatic()) {
                    continue;
                }

                // プロパティ名取得
                $name = $property->getName();

                // ignoreに含まれていればプロパティとしない
                if ($dto->hasIgnoreProperty($name)) {
                    continue;
                }

                $collection->addPropertyTypes(
                    $name,
                    PropertyTypes::fromReflectionProperty($property)
                );
            }

            PropertyTypesCollectionCache::cache($dto, $collection);
        } else {
            // キャッシュにコレクションがあればキャッシュを返す
            $collection = PropertyTypesCollectionCache::find($dto);
        }

        return $collection;
    }
}
