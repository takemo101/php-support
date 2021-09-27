<?php

namespace Takemo101\PHPSupport\File;

use Takemo101\PHPSupport\Contract\File\LocalSystem as Contract;
use Takemo101\PHPSupport\Path\Path;
use ErrorException;

/**
 * extract type enum
 */
class LocalSystem implements Contract
{
    /**
     *  ファイル存在
     *
     * @param string $path
     * @return boolean
     */
    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * ファイル読み込み
     *
     * @param string $path
     * @throws LocalSystemException
     * @return null|string
     */
    public function read(string $path): ?string
    {
        if ($this->isFile($path)) {
            $content = file_get_contents($path);
            return $content === false ? null : $content;
        }

        throw new LocalSystemException("does not exist at path [{$path}]");
    }

    /**
     * ファイル書き込み（上書き）
     *
     * @param string $path
     * @param string|resource $content
     * @return boolean
     */
    public function write(string $path, $content): bool
    {
        return file_put_contents($path, $content);
    }

    /**
     * ファイル追加書き込み（先頭へ）
     *
     * @param string $path
     * @param string $content
     * @return boolean
     */
    public function prepend(string $path, string $content): bool
    {
        if ($this->exists($path)) {
            return $this->write($path, $content . $this->read($path));
        }

        return $this->write($path, $content);
    }

    /**
     * ファイル追加書き込み（最後へ）
     *
     * @param string $path
     * @param string $content
     * @return boolean
     */
    public function append(string $path, string $content): bool
    {
        return file_put_contents($path, $content, FILE_APPEND);
    }

    /**
     * ファイル削除
     *
     * @param string $path
     * @return boolean
     */
    public function delete(string $path): bool
    {
        try {
            $result = @unlink($path);
        } catch (ErrorException $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * ファイル権限
     *
     * @param string $path
     * @param integer $permission
     * @return boolean
     */
    public function chmod(string $path, int $permission = 0755): bool
    {
        return chmod($path, $permission);
    }

    /**
     * ファイルコピー
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function copy(string $from, string $to): bool
    {
        return copy($from, $to);
    }

    /**
     * ファイル移動
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function move(string $from, string $to): bool
    {
        return rename($from, $to);
    }

    /**
     * シンボリックリンク
     *
     * @param string $target
     * @param string $link
     * @return boolean
     */
    public function symlink(string $target, string $link): bool
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return false;
        }

        return symlink($target, $link);
    }

    /**
     * ファイルサイズ
     *
     * @param string $path
     * @return integer
     */
    public function size(string $path): int
    {
        return filesize($path);
    }

    /**
     * ファイルタイム
     *
     * @param string $path
     * @return integer
     */
    public function time(string $path): int
    {
        return filemtime($path);
    }

    /**
     * ファイルか
     *
     * @param string $path
     * @return boolean
     */
    public function isFile(string $path): bool
    {
        return is_file($path);
    }

    /**
     * ディレクトリーか
     *
     * @param string $path
     * @return boolean
     */
    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * リンクか
     *
     * @param string $path
     * @return boolean
     */
    public function isLink(string $path): bool
    {
        return is_link($path);
    }

    /**
     * 読み込み可能か
     *
     * @param string $path
     * @return boolean
     */
    public function isReadable(string $path): bool
    {
        return is_readable($path);
    }

    /**
     * 書き込み可能か
     *
     * @param string $path
     * @return bool
     */
    public function isWritable(string $path): bool
    {
        return is_writable($path);
    }

    /**
     * ファイル情報抽出
     *
     * @param string $path
     * @param integer $option
     * @throws LocalSystemException
     * @return string
     */
    public function extract(string $path, int $option = ExtractType::BaseName): string
    {
        if (!ExtractType::in($option)) {
            throw new LocalSystemException("[{$option}] is not in extract type");
        }

        return pathinfo($path, $option);
    }

    /**
     * ファイルパーミッション取得
     *
     * @param string $path
     * @return null|integer
     */
    public function permission(string $path): ?int
    {
        $result = fileperms($path);

        return $result === false ? null : $result;
    }

    /**
     * ファイルタイプ取得
     *
     * @param string $path
     * @return null|string
     */
    public function type(string $path): ?string
    {
        $result = filetype($path);

        return $result === false ? null : $result;
    }

    /**
     * ファイルMimeタイプ取得
     *
     * @param string $path
     * @return null|string
     */
    public function mimeType(string $path): ?string
    {
        $result = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);

        return $result === false ? null : $result;
    }

    /**
     * パスを捜索
     *
     * @param string $pattern
     * @return null|array
     */
    public function glob(string $pattern): ?array
    {
        $result = glob($pattern);

        return $result === false ? null : $result;
    }

    /**
     * ディレクトリ作成
     *
     * @param string $path
     * @param integer $permission
     * @param boolean $recursive
     * @return boolean
     */
    public function makeDirectory(string $path, int $permission = 0755, bool $recursive = true): bool
    {
        return mkdir($path, $permission, $recursive);
    }

    /**
     * ディレクトリ移動
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function moveDirectory(string $from, string $to): bool
    {
        return @rename($from, $to) === true;
    }

    /**
     * ディレクトリコピー
     *
     * @param string $from
     * @param string $to
     * @return boolean
     */
    public function copyDirectory(string $from, string $to): bool
    {
        if (!$this->isDirectory($from)) {
            return false;
        }

        $this->makeDirectory($to, 0777);

        $paths = $this->glob(Path::join($from, "*"));

        foreach ($paths as $path) {
            $target = $this->extract($path, ExtractType::BaseName);

            $target = Path::join($to, $target);

            if ($this->isDirectory($path)) {
                return $this->copyDirectory($path, $target);
            }

            if (!$this->copy($path, $target)) {
                return false;
            }
        }

        return true;
    }

    /**
     * ディレクトリ削除
     *
     * @param string $path
     * @param boolean $keep
     * @return boolean
     */
    public function deleteDirectory(string $path, bool $keep = true): bool
    {
        if (!$this->isDirectory($path)) {
            return false;
        }

        $paths = $this->glob(Path::join($path, "*"));

        foreach ($paths as $target) {
            if ($this->isDirectory($target)) {
                return $this->deleteDirectory($target);
            }

            if (!$this->delete($target)) {
                return false;
            }
        }

        if (!$keep) {
            rmdir($path);
        }

        return true;
    }
}
