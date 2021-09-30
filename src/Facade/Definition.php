<?php

namespace Takemo101\PHPSupport\Facade;

use Closure;
use Error;
use Takemo101\PHPSupport\Contract\Facade\Container as Contract;

/**
 * injection eefinition class
 * 注入するための定義
 */
final class Definition
{
    /**
     * created instance
     *
     * @var mixed
     */
    private $instance = null;

    /**
     * construct
     *
     * @param Closure|string $callback
     * @param boolean $singleton
     */
    public function __construct(
        private Closure|string $callback,
        private bool $singleton = false
    ) {
        //
    }

    /**
     * 解決
     *
     * @param Contract $container
     * @param Resolvers $resolvers
     * @param array $options
     * @return mixed
     */
    public function resolve(Contract $container, Resolvers $resolvers, array $options = [])
    {
        if ($this->singleton) {
            if (is_null($this->instance)) {
                $this->instance = $this->build($container, $resolvers, $options);
            }

            return $this->instance;
        }

        return $this->build($container, $resolvers, $options);
    }

    /**
     * インスタンス生成
     *
     * @param Contract $container
     * @param Resolvers $resolvers
     * @param array $options
     * @throws Error
     * @return mixed
     */
    private function build(Contract $container, Resolvers $resolvers, array $options = [])
    {
        if ($this->callback instanceof Closure) {
            $result = ($this->callback)($container);

            if (is_null($result)) {
                throw new Error('build type error');
            }
        } else {
            $result = $resolvers->resolve($container, $this->callback, $options);
        }

        return $result;
    }
}
