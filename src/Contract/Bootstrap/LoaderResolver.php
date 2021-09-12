<?php

namespace Takemo101\PHPSupport\Contract\Bootstrap;

/**
 * loader resolver interface
 */
interface LoaderResolver
{
    /**
     * Loaderの生成処理
     *
     * @param string $loader
     * @return Loader
     */
    public function create(string $loader): Loader;
}
