<?php

namespace Takemo101\PHPSupport\Facade;

use InvalidArgumentException;
use Error;
use ReflectionClass;
use ReflectionParameter;
use ReflectionNamedType;
use Takemo101\PHPSupport\Contract\Facade\{
    Container as Contract,
    ArgumentResolver,
};

/**
 * argument resolvers
 * クラス名からインスタンスに解決するクラス
 */
final class ArgumentResolvers
{
    /**
     * argument resolver
     *
     * @var ArgumentResolver[]
     */
    private $resolvers;

    /**
     * construct
     *
     * @param ArgumentResolver[] $resolvers
     */
    public function __construct(array $resolvers)
    {
        $this->setResolvers($resolvers);
    }

    /**
     * 解決クラスをセットして配列内初期化
     *
     * @param ArgumentResolver[] $resolvers
     * @return self
     */
    public function setResolvers(array $resolvers): self
    {
        $this->resolvers = [];

        foreach ($resolvers as $resolver) {
            $this->addResolver($resolver);
        }

        return $this;
    }

    /**
     * 解決クラスの追加
     *
     * @param ArgumentResolver $resolver
     * @return self
     */
    public function addResolver(ArgumentResolver $resolver): self
    {
        $this->resolvers[] = $resolver;

        return $this;
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
     * @param array $args
     * @throws Error|InvalidArgumentException
     * @return object
     */
    public function resolve(Contract $container, string $class, array $options = []): object
    {
        $this->checkClassName($class);

        $reflector = new ReflectionClass($class);

        // インスタンス化できなければ例外
        if (!$reflector->isInstantiable()) {
            throw new Error('resolve instance error');
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new ($class);
        }

        $parameters = $constructor->getParameters();

        // コンストラクタの引数をリフレクションパラメータから解決する
        $arguments = $this->resolveArguments(
            $container,
            $parameters,
            $options
        );

        return $reflector->newInstanceArgs($arguments);
    }

    /**
     * 引数をリフレクションパラメータから解決する
     *
     * @param Container $container
     * @param ReflectionParameter[] $parameters
     * @param array $options
     * @return array
     */
    public function resolveArguments(Container $container, array $parameters, array $options = []): array
    {
        $arguments = [];
        foreach ($this->resolvers as $resolver) {
            $arguments = $resolver->resolve(
                $container,
                $parameters,
                $arguments,
                $options
            );
        }

        return $arguments;
    }
}
