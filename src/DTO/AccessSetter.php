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

        $aliases = $this->filpAliases();
        $alias = $aliases[$name] ?? $name;

        $types = $collection->findByPropertyName($alias);

        // 値変換
        $value = $this->convertProperty($name, $value);

        // 型チェック
        $value = TypeHelper::check($types, $value);

        $this->$alias = $value;
    }
}
