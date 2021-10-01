<?php

namespace Takemo101\PHPSupport\Contract\ViewModel;

use Takemo101\PHPSupport\ViewModel\AbstractModel;

/**
 * view model callable resolver interface
 */
interface CallableResolver
{
    /**
     * メソッド呼び出し解決
     *
     * @param AbstractModel $model
     * @param string $method
     * @return mixed
     */
    public function call(AbstractModel $model, string $method);
}
