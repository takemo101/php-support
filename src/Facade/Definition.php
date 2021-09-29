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
     * @return mixed
     */
    public function resolve(Contract $container)
    {
        if ($this->singleton) {
            if (is_null($this->instance)) {
                $this->instance = $this->build($container);
            }

            return $this->instance;
        }

        return $this->build($container);
    }

    /**
     * インスタンス生成
     *
     * @param Contract $container
     * @throws Error
     * @return mixed
     */
    private function build(Contract $container)
    {
        if ($this->callback instanceof Closure) {
            $result = ($this->callback)($container);

            if (is_null($result)) {
                throw new Error('build type error');
            }
        } else {
            $result = ClassNameResolver::toResolve($this->callback, $container);
        }

        return $result;
    }
}
