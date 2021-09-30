<?php

namespace Takemo101\PHPSupport\Path;

/**
 * path helper class
 */
final class Path
{
    /**
     * パスの結合
     *
     * @param string ...$args
     * @return string
     */
    public static function join(string ...$args): string
    {
        return self::createHelper()->join(...$args);
    }

    /**
     * パスを結合して正規化されたパスを返す
     *
     * @param string ...$args
     * @return string
     */
    public static function real(string ...$args): string
    {
        return self::createHelper()->real(...$args);
    }

    /**
     * パスを各階層ごとの配列に分離
     *
     * @param string $path
     * @return string[]
     */
    public static function split(string $path): array
    {
        return self::createHelper()->split($path);
    }

    /**
     * パスのセパレーターを設定
     *
     * @param string $separator
     * @return PathHelper
     */
    public static function setSeparator(string $separator): PathHelper
    {
        return self::createHelper()->setSeparator($separator);
    }

    /**
     * ヘルパーの生成
     *
     * @return PathHelper
     */
    protected static function createHelper(): PathHelper
    {
        return new PathHelper;
    }
}
