<?php

namespace Takemo101\PHPSupport\Arr;

/**
 * array helper class
 */
final class Arr
{
    /**
     * ドット記法での配列を返す
     *
     * @param array $array
     * @return array
     */
    public static function dot(array $array): array
    {
        return ArrAccess::of($array)->dot();
    }

    /**
     * ドット記法 => 値 を配列に直す
     *
     * @param array $array
     * @return array
     */
    public static function undot(array $array): array
    {
        return ArrAccess::of()->undot($array)->all();
    }

    /**
     * 指定したキーに指定した値を入れる
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @return array
     */
    public static function set(array &$array, string $key, $value): array
    {
        $array = ArrAccess::of($array)->set($key, $value)->all();
        return $array;
    }

    /**
     * 指定したキーの値が存在するか
     *
     * @param array $array
     * @param string $key
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        return ArrAccess::of($array)->has($key);
    }

    /**
     * 配列値をドット記法で取得
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    public static function get(array $array, string $key, $default = null)
    {
        return ArrAccess::of($array)->get($key, $default);
    }

    /**
     * 指定キーに対する配列値を全て取得
     *
     * @param array $array
     * @param string $value
     * @param string|null $key
     * @return array
     */
    public static function pluck(array $array, string $value, ?string $key = null): array
    {
        return ArrAccess::of($array)->pluck($value, $key);
    }

    /**
     * 指定したキーの配列を削除する
     *
     * @param array $array
     * @param string|array $keys
     * @return array
     */
    public static function forget(array &$array, $keys): array
    {
        $array = ArrAccess::of($array)->forget($keys)->all();
        return $array;
    }

    /**
     * 指定したキーを除外した配列を返す
     *
     * @param array $array
     * @param string|array $keys
     * @return array
     */
    public static function except(array $array, $keys): array
    {
        return ArrAccess::of($array)->except($keys);
    }

    /**
     * 指定したキーの配列だけを返す
     *
     * @param array $array
     * @param string|array
     * @return array
     */
    public static function only(array $array, $keys): array
    {
        return ArrAccess::of($array)->only($keys);
    }

    /**
     * 指定したキーが見つかった配列だけを返す
     *
     * @param array $array
     * @param string|array $keys
     * @return array
     */
    public static function missing(array $array, $keys): array
    {
        return ArrAccess::of($array)->missing($keys);
    }

    /**
     * クエリ文字に変換
     *
     * @param array $array
     * @return string
     */
    public static function query(array $array)
    {
        return ArrAccess::of($array)->query();
    }
}
