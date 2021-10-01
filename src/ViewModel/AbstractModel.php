<?php

namespace Takemo101\PHPSupport\ViewModel;

use JsonSerializable;

/**
 * view model
 */
abstract class AbstractModel implements JsonSerializable
{
    /**
     * デフォルトの不許可プロパティ名
     *
     * @var string[]
     */
    protected static $ignores = [
        'toArray',
        'jsonSerialize',
        'of',
    ];

    /**
     * データをViewに渡すことを許可しないプロパティ名
     *
     * @var string[]
     */
    protected $__ignores = [];

    /**
     * 不許可のメソッド or プロパティかどうか？
     *
     * @param string $name
     * @return boolean
     */
    public function hasIgnoreKey(string $name): bool
    {
        if (strpos($name, '__') === 0) {
            return true;
        }

        $ignores = static::$ignores;
        $ignores[] = __FUNCTION__;

        return in_array($name, array_merge(
            $ignores,
            $this->ignoreKeys()
        ));
    }

    /**
     * 不許可メソッド or プロパティを返す
     *
     * @return array
     */
    protected function ignoreKeys(): array
    {
        return $this->__ignores;
    }

    /**
     * for json array
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return ReflectionTransformer::toCollect($this)->all();
    }

    /**
     * factory
     */
    public static function of(...$parameters)
    {
        return new static(...$parameters);
    }
}
