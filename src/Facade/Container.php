<?php

namespace Takemo101\PHPSupport\Facade;

use Closure;
use LogicException;
use Takemo101\PHPSupport\Contract\Facade\Container as Contract;
use Takemo101\PHPSupport\Facade\Resolver\{
    DefaultResolver,
    ArgumentNameResolver,
};

/**
 * facade inject container class
 * ファザードで利用するインスタンスを管理するクラス
 */
class Container implements Contract
{
    /**
     * injection bind map
     *
     * @var Definition[]
     */
    protected $binds = [];

    /**
     * injection aliases
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * class constructor argument resolvers
     *
     * @var ArgumentResolvers
     */
    protected $resolvers;

    public function __construct(
        ?ArgumentResolvers $resolvers = null
    ) {
        $this->resolvers = $resolvers ?? new ArgumentResolvers([
            new DefaultResolver,
            new ArgumentNameResolver,
        ]);
    }

    /**
     * 別名の設定
     *
     * @param string $class
     * @param string $alias
     * @return self
     */
    public function alias(string $class, string $alias)
    {
        if ($class === $alias) {
            throw new LogicException("[{$class}] same name as the alias");
        }

        $this->aliases[$alias] = $class;

        return $this;
    }

    /**
     * シングルトンでの依存注入を設定
     *
     * @param string $label
     * @param Closure|string|null $callback
     * @return self
     */
    public function singleton(string $label, Closure|string|null $callback = null)
    {
        $callback = $callback ?? $label;

        $this->binds[$label] = new Definition($callback, true);

        return $this;
    }

    /**
     * 通常の依存注入を設定
     *
     * @param string $label
     * @param Closure|string|null $callback
     * @return self
     */
    public function bind(string $label, Closure|string|null $callback = null)
    {
        $callback = $callback ?? $label;

        $this->binds[$label] = new Definition($callback);

        return $this;
    }

    /**
     * バインドされているか
     *
     * @param string $label
     * @return boolean
     */
    public function has(string $label): bool
    {
        return isset($this->binds[$label]) || isset($this->aliases[$label]);
    }

    /**
     * 全てのバインディングを開放
     *
     * @return self
     */
    public function clear()
    {
        $this->binds = [];
        $this->aliases = [];

        return $this;
    }

    /**
     * クラスまたはラベル名から依存性を解決した値を取得する
     *
     * @param string $label
     * @param array $options
     * @return mixed
     */
    public function make(string $label, array $options = [])
    {
        if (!isset($this->binds[$label])) {
            if (isset($this->aliases[$label])) {
                return $this->make($this->aliases[$label]);
            }

            if (class_exists($label)) {
                return $this
                    ->bind($label)
                    ->make($label);
            }

            throw new BindingException("not found label or class [{$label}]");
        }

        $definition = $this->binds[$label];

        return $definition->resolve($this, $this->resolvers, $options);
    }

    /**
     * callableから依存性を解決した値を取得する
     *
     * @param callable $callable
     * @param array $options
     * @return mixed
     */
    public function call(callable $callable, array $options = [])
    {
        return CallableResolversAdapter::toResolve(
            $this->resolvers,
            $this,
            $callable,
            $options
        );
    }
}
