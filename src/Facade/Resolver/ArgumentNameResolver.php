<?php

namespace Takemo101\PHPSupport\Facade\Resolver;

use Takemo101\PHPSupport\Contract\Facade\{
    Container,
    ArgumentResolver,
};
use Error;

final class ArgumentNameResolver implements ArgumentResolver
{
    /**
     * リフレクション引数を引数値に変換する
     *
     * @param Container $container
     * @param ReflectionParameter[] $parameters
     * @param array $arguments
     * @param array $options
     * @throws Error
     * @return array
     */
    public function resolve(
        Container $container,
        array $parameters,
        array $arguments,
        array $options = []
    ): array {

        // パラメータから引数を取得する
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();

            if (array_key_exists($name, $options)) {
                $arguments[$name] = $options[$name];
            }

            // 可変長引数の場合は例外
            if ($parameter->isVariadic()) {
                throw new Error('resolve argument parameter error');
            }
        }

        return $arguments;
    }
}
