<?php

namespace Takemo101\PHPSupport\DTO;

/**
 * DTOのプロパティアクセス補助 setter
 */
trait AccessSetter
{
    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        // プロパティタイプコレクションの生成
        $collection = PropertyTypesCollection::fromDTO($this);

        $aliases = array_flip($this->__aliases);
        $alias = $aliases[$name] ?? $name;

        $types = $collection->findByPropertyName($alias);

        if (!$types->compare($value)) {
            $type = gettype($value);
            throw new PropertyTypeException("type does not match [{$type}]");
        }

        $this->$alias = $value;
    }
}
