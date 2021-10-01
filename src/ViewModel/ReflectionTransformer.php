<?php

namespace Takemo101\PHPSupport\ViewModel;

use Takemo101\PHPSupport\Collection\ArrayCollection as Collection;
use Takemo101\PHPSupport\Contract\ViewModel\CallableResolver as Contract;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use OutOfBoundsException;

/**
 * view model reflection data transformer
 * ViewModelのデータ加工のためのクラス
 */
final class ReflectionTransformer
{
    /**
     * データの初期値を取得するメソッド名
     *
     * @var string DataMethodName
     */
    const DataMethodName = '__data';

    /**
     * メソッド呼び出し解決クラス
     *
     * @var null|Contract
     */
    private static $callableResolver = null;

    /**
     * メソッド呼び出し解決クラスをセット
     *
     * @param Contract $callableResolver
     * @return void
     */
    public static function setCallableResolver(Contract $callableResolver)
    {
        self::$callableResolver = $callableResolver;
    }

    /**
     * メソッド呼び出し解決
     *
     * @param AbstractModel $model
     * @param string $method
     * @return void
     */
    private static function callResolve(AbstractModel $model, string $method)
    {
        if (!self::$callableResolver) {
            self::setCallableResolver(new CallableResolver);
        }

        return self::$callableResolver->call($model, $method);
    }

    /**
     * プロパティとメソッドから抽出したViewModelの値を
     * コレクションとして返す
     *
     * @param AbstractModel $model
     * @throws OutOfBoundsException
     * @return Collection
     */
    public static function toCollect(AbstractModel $model): Collection
    {
        // ViewModelのプロパティを加工
        $properties = self::toPropertyData($model);

        // ViewModelのメソッドを加工
        $methods = self::toMethodData($model);

        // データ初期化メソッドがあれば取得する
        if (method_exists($model, self::DataMethodName)) {
            $data = self::callResolve($model, self::DataMethodName);
            if (!is_array($data)) {
                throw new OutOfBoundsException('initialize data is not array');
            }

            return Collection::of($data)->merge(
                $properties->merge(
                    $methods->all()
                )->all()
            );
        }

        return $properties->merge($methods->all());
    }

    /**
     * ViewModelのプロパティを加工してコレクションで返す
     *
     * @param AbstractModel $model
     * @return Collection
     */
    public static function toPropertyData(AbstractModel $model): Collection
    {
        $class = new ReflectionClass($model);

        return Collection::of(
            $class->getProperties(
                ReflectionProperty::IS_PUBLIC
            )
        )
            ->filter(function (ReflectionProperty $property) use ($model) {
                return !$model->hasIgnoreKey($property->getName());
            })
            ->mapWithKey(function (ReflectionProperty $property) use ($model) {
                return [
                    $property->getName() => $model->{$property->getName()}
                ];
            });
    }

    /**
     * ViewModelのメソッドを加工してコレクションで返す
     *
     * @param AbstractModel $model
     * @return Collection
     */
    public static function toMethodData(AbstractModel $model): Collection
    {
        $class = new ReflectionClass($model);

        return Collection::of(
            $class->getMethods(
                ReflectionMethod::IS_PUBLIC
            )
        )
            ->filter(function (ReflectionMethod $method) use ($model) {
                return !$model->hasIgnoreKey($method->getName());
            })
            ->mapWithKey(function (ReflectionMethod $method) use ($model) {
                return [
                    $method->getName() => static::call($model, $method)
                ];
            });
    }

    /**
     * リフレクションでのメソッド呼び出しとメソッドインジェクション
     *
     * @param AbstractModel $model
     * @param ReflectionMethod $method
     * @return void
     */
    private static function call(AbstractModel $model, ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $model->{$method->getName()}();
        }

        return self::callResolve($model, $method->getName());
    }
}
