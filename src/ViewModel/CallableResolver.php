<?php

namespace Takemo101\PHPSupport\ViewModel;

use Takemo101\PHPSupport\Contract\ViewModel\CallableResolver as Contract;
use Takemo101\PHPSupport\Facade\Injector;
use BadMethodCallException;

/**
 * シンプルなメソッド呼び出し解決クラス
 * ReflectionTransformerにCallableResolverを設定しなければ
 * このクラスがセットされる
 */
final class CallableResolver implements Contract
{
    /**
     * メソッド呼び出し解決
     *
     * @param AbstractModel $model
     * @param string $method
     * @throws BadMethodCallException
     * @return mixed
     */
    public function call(AbstractModel $model, string $method)
    {
        if (!method_exists($model, $method)) {
            throw new BadMethodCallException("[{$method}] method does not exist");
        }
        return Injector::call([$model, $method]);
    }
}
