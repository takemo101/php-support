<?php

namespace Takemo101\PHPSupport\Facade;

use InvalidArgumentException;
use Error;
use ReflectionClass;
use ReflectionNamedType;
use Takemo101\PHPSupport\Contract\Facade\Container as Contract;

/**
 * resolve class name
 * クラス名からインスタンスに解決するクラス
 */
final class ClassNameResolver
{
    /**
     * construct
     *
     * @param string $class
     */
    public function __construct(private string $class)
    {
        $this->checkClassName($class);
    }

    /**
     * クラス名をチェック
     *
     * @param string $class
     * @throws InvalidArgumentException
     * @return void
     */
    private function checkClassName(string $class)
    {
        if (!class_exists($class)) {
            if (!interface_exists($class)) {
                throw new InvalidArgumentException("class name [{$class}] does not exist");
            }
        }
    }

    /**
     * クラス名からインスタンスに解決
     *
     * @param Contract $container
     * @throws Error
     * @return object
     */
    public function resolve(Contract $container): object
    {
        $reflector = new ReflectionClass($this->class);

        // インスタンス化できなければ例外
        if (!$reflector->isInstantiable()) {
            throw new Error('resolve instance error');
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new ($this->class);
        }

        $parameters = $constructor->getParameters();

        $instances = [];

        // パラメータから引数を取得する
        foreach ($parameters as $parameter) {
            // 可変長引数の場合は例外
            if ($parameter->isVariadic()) {
                throw new Error('resolve argument parameter error');
            }

            $type = $parameter->getType();

            if ($type->isBuiltin()) {
                // 引数の型が複数ある場合は例外
                if (!($type instanceof ReflectionNamedType)) {
                    throw new Error('resolve multi argument error');
                }

                // デフォルト値があればそれを引き数値として
                if ($parameter->isDefaultValueAvailable()) {
                    $instances[] = $parameter->getDefaultValue();
                } else {
                    throw new Error('resolve builtin argument error');
                }
            } else {
                $name = $type->getName();

                if (!is_null($class = $parameter->getDeclaringClass())) {
                    if ($name === 'self') {
                        $name = $class->getName();
                    } else if ($name === 'parent' && $parent = $class->getParentClass()) {
                        $name = $parent->getName();
                    }
                }

                $instances[] = $container->make($name);
            }
        }

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * インスタンス解決ヘルパ
     *
     * @param string $label
     * @param Container $container
     * @throws InvalidArgumentException|Error
     * @return object
     */
    public static function toResolve(string $label, Container $container): object
    {
        return (new static($label))->resolve($container);
    }
}
