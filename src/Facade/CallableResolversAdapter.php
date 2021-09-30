<?php

namespace Takemo101\PHPSupport\Facade;

use InvalidArgumentException;
use Error;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionFunctionAbstract;
use Closure;
use Takemo101\PHPSupport\Contract\Facade\Container as Contract;

/**
 * callable argument resolvers
 * callableを解決するクラス
 */
final class CallableResolversAdapter
{
    /**
     * argument resolvers
     *
     * @var ArgumentResolvers
     */
    private $resolvers;

    /**
     * construct
     *
     * @param ArgumentResolvers $resolvers
     */
    public function __construct(ArgumentResolvers $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * callable呼び出しを解決
     *
     * @param Contract $container
     * @param array $args
     * @throws Error|InvalidArgumentException
     * @return mixed
     */
    public function resolve(Contract $container, callable $callable, array $options = [])
    {
        $reflector = $this->createCallableReflection($callable);

        $parameters = $reflector->getParameters();

        $arguments = $this->resolvers->resolveArguments(
            $container,
            $parameters,
            $options
        );

        return call_user_func_array($callable, $arguments);
    }

    /**
     * callableからリフレクションのインスタンスを生成する
     *
     * @param callable $callable
     * @throws Error
     * @return ReflectionFunctionAbstract
     */
    public function createCallableReflection(callable $callable): ReflectionFunctionAbstract
    {
        // for closure
        if ($callable instanceof Closure) {
            return new ReflectionFunction($callable);
        }

        // for callable array
        if (is_array($callable)) {
            [$class, $method] = $callable;

            if (!method_exists($class, $method)) {
                throw new Error('resolve callable array error');
            }

            return new ReflectionMethod($class, $method);
        }

        // for callable object
        if (is_object($callable) && method_exists($callable, '__invoke')) {
            return new ReflectionMethod($callable, '__invoke');
        }

        // for function
        if (is_string($callable) && function_exists($callable)) {
            return new ReflectionFunction($callable);
        }

        throw new Error('resolve callable error');
    }

    /**
     * インスタンス生成からresolve処理まで一括で行う
     *
     * @param ArgumentResolvers $resolvers
     * @param Contract $container
     * @param callable $callable
     * @param array $options
     * @return mixed
     */
    public static function toResolve(
        ArgumentResolvers $resolvers,
        Contract $container,
        callable $callable,
        array $options = []
    ) {
        return (new static($resolvers))->resolve(
            $container,
            $callable,
            $options
        );
    }
}
