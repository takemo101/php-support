<?php

namespace Takemo101\PHPSupport\Contract\Facade;

use ReflectionParameter;

/**
 * reflection argument resolver interface
 */
interface ArgumentResolver
{
    /**
     * リフレクション引数を引数値に変換する
     *
     * @param Container $container
     * @param ReflectionParameter[] $parameters
     * @param array $arguments
     * @param array $options
     * @return array
     */
    public function resolve(
        Container $container,
        array $parameters,
        array $arguments,
        array $options = []
    ): array;
}
