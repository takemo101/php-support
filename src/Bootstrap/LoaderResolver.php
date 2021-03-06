<?php

namespace Takemo101\PHPSupport\Bootstrap;

use Takemo101\PHPSupport\Contract\Bootstrap\{
    Loader,
    LoaderResolver as Contract,
};
use Takemo101\PHPSupport\Facade\Injector;

/**
 * default loader resolver
 */
class LoaderResolver implements Contract
{
    /**
     * Loaderの生成処理
     *
     * @param string $loader
     * @return Loader
     */
    public function create(string $loader): Loader
    {
        return Injector::make($loader);
    }
}
