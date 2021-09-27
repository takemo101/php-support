<?php

namespace Takemo101\PHPSupport\File;

use Takemo101\PHPSupport\Contract\File\LocalSystem as Contract;

/**
 * file system helper
 */
final class System
{
    /**
     * local file system
     *
     * @var Contract|null
     */
    protected static $system = null;

    /**
     * singleton instance
     *
     * @return Contract
     */
    public static function instance(): Contract
    {
        if (!self::$system) {
            self::$system = new LocalSystem;
        }

        return self::$system;
    }

    /**
     *  ファイル存在
     *
     * @param string $path
     * @return boolean
     */
    public static function exists(string $path): bool
    {
        return self::instance()->exists($path);
    }

    /**
     * ファイル読み込み
     *
     * @param string $path
     * @throws LocalSystemException
     * @return null|string
     */
    public static function read(string $path): ?string
    {
        return self::instance()->read($path);
    }

    /**
     * ファイル書き込み（上書き）
     *
     * @param string $path
     * @param string|resource $content
     * @return boolean
     */
    public static function write(string $path, $content): bool
    {
        return self::instance()->write($path, $content);
    }

    /**
     * ファイル追加書き込み（先頭へ）
     *
     * @param string $path
     * @param string $content
     * @return boolean
     */
    public static function prepend(string $path, string $content): bool
    {
        return self::instance()->prepend($path, $content);
    }

    /**
     * ファイル追加書き込み（最後へ）
     *
     * @param string $path
     * @param string $content
     * @return boolean
     */
    public static function append(string $path, string $content): bool
    {
        return self::instance()->append($path, $content);
    }

    /**
     * ファイル削除
     *
     * @param string $path
     * @return boolean
     */
    public static function delete(string $path): bool
    {
        return self::instance()->delete($path);
    }

    /**
     * ファイル権限
     *
     * @param string $path
     * @param integer $permission
     * @return boolean
     */
    public static function chmod(string $path, int $permission = 0755): bool
    {
        return self::instance()->chmod($path, $permission);
    }

    /**
     * ファイルコピー
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public static function copy(string $from, string $to): bool
    {
        return self::instance()->copy($from, $to);
    }

    /**
     * ファイル移動
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public static function move(string $from, string $to): bool
    {
        return self::instance()->move($from, $to);
    }

    /**
     * シンボリックリンク
     *
     * @param string $target
     * @param string $link
     * @return boolean
     */
    public static function symlink(string $target, string $link): bool
    {
        return self::instance()->symlink($target, $link);
    }

    /**
     * シンボリックリンクのリンク先を取得
     *
     * @param string $path
     * @throws LocalSystemException
     * @return null|string
     */
    public static function readlink(string $path): ?string
    {
        return self::instance()->readlink($path);
    }

    /**
     * 正規化されたパスを返す
     *
     * @param string $path
     * @return string
     */
    public static function realpath(string $path): string
    {
        return self::instance()->realpath($path);
    }

    /**
     * ファイルサイズ
     *
     * @param string $path
     * @return integer
     */
    public static function size(string $path): int
    {
        return self::instance()->size($path);
    }

    /**
     * ファイルタイム
     *
     * @param string $path
     * @return integer
     */
    public static function time(string $path): int
    {
        return self::instance()->time($path);
    }

    /**
     * ファイルか
     *
     * @param string $path
     * @return boolean
     */
    public static function isFile(string $path): bool
    {
        return self::instance()->isFile($path);
    }

    /**
     * ディレクトリーか
     *
     * @param string $path
     * @return boolean
     */
    public static function isDirectory(string $path): bool
    {
        return self::instance()->isDirectory($path);
    }

    /**
     * リンクか
     *
     * @param string $path
     * @return boolean
     */
    public static function isLink(string $path): bool
    {
        return self::instance()->isLink($path);
    }

    /**
     * 読み込み可能か
     *
     * @param string $path
     * @return boolean
     */
    public static function isReadable(string $path): bool
    {
        return self::instance()->isReadable($path);
    }

    /**
     * 書き込み可能か
     *
     * @param string $path
     * @return bool
     */
    public static function isWritable(string $path): bool
    {
        return self::instance()->isWritable($path);
    }

    /**
     * ファイル情報抽出
     *
     * @param string $path
     * @param integer $option
     * @return string
     */
    public static function extract(string $path, int $option = ExtractType::BaseName): string
    {
        return self::instance()->extract($path, $option);
    }

    /**
     * ファイルパーミッション取得
     *
     * @param string $path
     * @return null|integer
     */
    public static function permission(string $path): ?int
    {
        return self::instance()->permission($path);
    }

    /**
     * ファイルタイプ取得
     *
     * @param string $path
     * @return null|string
     */
    public static function type(string $path): ?string
    {
        return self::instance()->type($path);
    }

    /**
     * ファイルMimeタイプ取得
     *
     * @param string $path
     * @return null|string
     */
    public static function mimeType(string $path): ?string
    {
        return self::instance()->mimeType($path);
    }

    /**
     * パスを捜索
     *
     * @param string $pattern
     * @return null|array
     */
    public static function glob(string $pattern): ?array
    {
        return self::instance()->glob($pattern);
    }

    /**
     * ディレクトリ作成
     *
     * @param string $path
     * @param integer $permission
     * @param boolean $recursive
     * @return boolean
     */
    public static function makeDirectory(string $path, int $permission = 0755, bool $recursive = true): bool
    {
        return self::instance()->makeDirectory($path, $permission, $recursive);
    }

    /**
     * ディレクトリ移動
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public static function moveDirectory(string $from, string $to): bool
    {
        return self::instance()->moveDirectory($from, $to);
    }

    /**
     * ディレクトリコピー
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public static function copyDirectory(string $from, string $to): bool
    {
        return self::instance()->copyDirectory($from, $to);
    }

    /**
     * ディレクトリ削除
     *
     * @param string $path
     * @param boolean $keep
     * @return boolean
     */
    public static function deleteDirectory(string $path, bool $keep = true): bool
    {
        return self::instance()->deleteDirectory($path, $keep);
    }
}
