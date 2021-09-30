<?php

namespace Takemo101\PHPSupport\Facade\Resolver;

use Takemo101\PHPSupport\Contract\Facade\{
    Container,
    ArgumentResolver,
};
use ReflectionNamedType;
use Error;

final class DefaultResolver implements ArgumentResolver
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
            // 可変長引数の場合は例外
            if ($parameter->isVariadic()) {
                throw new Error('resolve argument parameter error');
            }

            $type = $parameter->getType();

            if ($type && !$type->isBuiltin()) {
                $name = $type->getName();

                if (!is_null($class = $parameter->getDeclaringClass())) {
                    if ($name === 'self') {
                        $name = $class->getName();
                    } else if ($name === 'parent' && $parent = $class->getParentClass()) {
                        $name = $parent->getName();
                    }
                }

                $arguments[$parameter->getName()] = $container->make($name);
            } else if ($parameter->isDefaultValueAvailable()) {
                $arguments[$parameter->getName()] = $parameter->getDefaultValue();
            }
        }

        return $arguments;
    }
}
