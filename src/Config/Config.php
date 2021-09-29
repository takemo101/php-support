<?php

namespace Takemo101\PHPSupport\Config;

use Takemo101\PHPSupport\Contract\Config\Repository as Contract;
use Takemo101\PHPSupport\Facade\AbstractFacade;

/**
 * config helper
 *
 * @method static Contract loadBy(string $key, string|callable $config, ?string $namespace = null)
 * @method static Contract load(string $directory, ?string $namespace = null)
 * @method static Contract merge(string $key, $value)
 * @method static mixed get(string $key, $default = null)
 * @method static Contract set(string $key, $value)
 * @method static boolean has(string $key)
 * @method static boolean exists(string $key)
 *
 * @see \Takemo101\PHPSupport\Contract\Config\Repository
 */
final class Config extends AbstractFacade
{
    /**
     * facade accesser
     *
     * @throws RuntimeException
     * @return string|object
     */
    protected static function accessor(): string|object
    {
        return Contract::class;
    }

    /**
     * シングルトンインスタンスをセットする
     *
     * @param Contract $repository
     * @return void
     */
    public static function setRepository(Contract $repository)
    {
        self::binding(function ($c) use ($repository) {
            return $repository;
        });
    }
}
