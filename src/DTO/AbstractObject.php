<?php

namespace Takemo101\PHPSupport\DTO;

use ReflectionClass;
use JsonSerializable;

/**
 * DTOのベースクラス
 */
abstract class AbstractObject implements JsonSerializable
{
    /**
     * DTOの不許可プロパティ名
     *
     * @var array
     */
    protected $__ignores = [];

    /**
     * DTOの初期値からプロパティへの別名
     * プロパティ名 => 別名
     *
     * @var array
     */
    protected $__aliases = [];

    /**
     * プロパティ値をセットするときの変換処理の設定
     *
     * @var array
     */
    protected $__converters = [];

    public function __construct(array $inputs = [])
    {
        PropertyFlipAliasesCache::cache($this);
        $this->loadProperties($inputs);
    }

    /**
     * プロパティのロード
     *
     * @param array $inputs
     * @throws PropertyTypeException
     * @return void
     */
    public function loadProperties(array $inputs)
    {
        // プロパティタイプコレクションの生成
        $collection = PropertyTypesCollection::fromObject($this);

        // inputsが空配列であれば処理しない
        if (count($inputs) == 0) {
            return;
        }

        $reflection = new ReflectionClass($this);

        $aliases = $this->propertyAliases();

        foreach ($collection as $name => $types) {
            $alias = $aliases[$name] ?? $name;

            if (array_key_exists($alias, $inputs)) {
                // 別名の値を取り出す
                $value = $inputs[$alias];
            } else {
                continue;
            }

            // 値変換
            $value = TypeHelper::convert($this, $name, $value);

            // 型チェック
            $value = TypeHelper::check($types, $value);

            // 値を対象プロパティに入れる
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($this, $value);
        }
    }

    /**
     * DTOの不許可プロパティかどうか
     * プロパティ名のプレフィックスに __ をつけると不許可とする
     *
     * @param string $name
     * @return boolean
     */
    public function hasIgnoreProperty(string $name): bool
    {
        if (strpos($name, '__') === 0) {
            return true;
        }

        return in_array($name, $this->ignoreProperties());
    }

    /**
     * DTOのプロパティとして許可しない（不許可）プロパティ名
     *
     * @return array
     */
    public function ignoreProperties(): array
    {
        return $this->__ignores;
    }

    /**
     * DTOプロパティを配列に変換
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->properties();
    }

    /**
     * serialize value.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * プロパティの配列を返す
     *
     * @return array
     */
    public function properties(): array
    {
        // プロパティタイプコレクションの生成
        $collection = PropertyTypesCollection::fromObject($this);

        $reflection = new ReflectionClass($this);

        $aliases = PropertyFlipAliasesCache::find($this);

        $result = [];

        foreach ($collection as $name => $types) {
            $alias = $aliases[$name] ?? $name;

            // 値を対象プロパティから取り出す
            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $result[$alias] = $property->getValue($this);
        }

        return $result;
    }

    /**
     * プロパティーのエイリアス配列を返す
     *
     * @return array
     */
    public function propertyAliases(): array
    {
        return $this->__aliases;
    }

    /**
     * プロパティ変換配列を返す
     *
     * @return array
     */
    public function propertyConverters(): array
    {
        return $this->__converters;
    }

    /**
     * フェイクインスタンスを生成
     *
     * @return static
     */
    public static function fake(): static
    {
        return FakeFactory::make(static::class);
    }
}
