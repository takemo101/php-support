<?php

namespace Takemo101\PHPSupport\DTO;

/**
 * DTOのプロパティアクセス補助 getter
 */
trait AccessGetter
{
    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        // プロパティタイプコレクションの生成
        $collection = PropertyTypesCollection::fromDTO($this);

        $aliases = array_flip($this->__aliases);
        $alias = $aliases[$name] ?? $name;

        $value = $this->$alias;
        $types = $collection->findByPropertyName($alias);

        if (!$types->compare($value)) {
            $type = gettype($value);
            throw new PropertyTypeException("type does not match [{$type}]");
        }

        return $value;
    }
}
