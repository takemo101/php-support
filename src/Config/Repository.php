<?php

namespace Takemo101\PHPSupport\Config;

use Takemo101\PHPSupport\{
    Path\Path,
    Arr\Arr,
    File\System,
    Contract\Config\Repository as Contract,
};
use ArrayAccess;

/**
 * config repository
 */
class Repository implements Contract, ArrayAccess
{
    /**
     * @var string
     */
    const NamespaceSparator = '::';

    /**
     * @var string
     */
    const ConfigExt = '.php';

    /**
     * @var array[]
     */
    protected $config = [];

    /**
     * factory
     *
     * @param string|null $directory
     * @return self
     */
    public static function of(?string $directory = null)
    {
        return new static($directory);
    }

    /**
     * construct
     *
     * @param string|null $directory
     */
    public function __construct(?string $directory = null)
    {
        if ($directory) {
            $this->load($directory);
        }
    }

    /**
     * ネームスペース文字列を生成
     *
     * @param string|null $namespace
     * @return string
     */
    protected function namespaceString(?string $namespace = null): string
    {
        return $namespace ? $namespace . self::NamespaceSparator : '';
    }

    /**
     * パスからキー文字列を生成
     *
     * @param string $path
     * @return string
     */
    protected function keyStringByPath(string $path): string
    {
        return basename($path, self::ConfigExt);
    }

    /**
     * キーを指定してコンフィグに対して色々な値を設定する
     * configに設定できるものはcallableかコンフィグファイルへのパスか配列など
     *
     * @param string $key
     * @param string|callable $config
     * @param string|null $namespace
     * @return self
     */
    public function loadBy(string $key, string|callable $config, ?string $namespace = null)
    {
        $namespace = $this->namespaceString($namespace);
        $this->config["{$namespace}{$key}"] = $config;

        return $this;
    }

    /**
     * パスをコンフィグに設定する
     * キーを指定しない場合はファイル名がキーとなる
     *
     * @param string $path
     * @param string|null $key
     * @param string|null $namespace
     * @return self
     */
    public function loadByPath(string $path, ?string $key = null, ?string $namespace = null)
    {
        $key = $key ?? $this->keyStringByPath($path);
        return $this->loadBy($key, $path, $namespace);
    }

    /**
     * ディレクトリーからコンフィグを設定する
     *
     * @param string $directory
     * @param string|null $namespace
     * @return self
     */
    public function load(string $directory, ?string $namespace = null)
    {
        $namespace = $this->namespaceString($namespace);
        $ext = self::ConfigExt;
        $paths = System::glob(Path::join($directory, "*{$ext}"));

        foreach ($paths as $path) {
            $key = $this->keyStringByPath($path);
            $this->config["{$namespace}{$key}"] = $path;
        }

        return $this;
    }

    /**
     * コンフィグデータをロード
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function loadData(string $key, $default = null)
    {
        if (isset($this->config[$key])) {
            $result = $this->resolveData($this->config[$key]);
            $this->config[$key] = $result;

            return $result;
        }

        return $default;
    }

    /**
     * コンフィグデータを解決
     *
     * @param string|callable|array $config
     * @return array
     */
    protected function resolveData(string|callable|array $config): array
    {
        if (is_string($config)) {
            $result = require $config;
        } else if (is_callable($config)) {
            $result = call_user_func($config);
        } else {
            $result = $config;
        }

        return $result;
    }

    /**
     * コンフィグデータをマージ
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function merge(string $key, $value)
    {
        [$first, $last] = Arr::firstDotKey($key);
        $this->loadData($first);

        Arr::set(
            $this->config,
            $last,
            array_merge(
                Arr::get($this->config, $last, []),
                $this->resolveData($value)
            )
        );

        return $this;
    }

    /**
     * コンフィグデータを取得
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        [$first, $last] = Arr::firstDotKey($key);
        $this->loadData($first);

        return Arr::get($this->config, $key, $default);
    }

    /**
     * コンフィグデータをセット
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, $value)
    {
        [$first, $last] = Arr::firstDotKey($key);
        $this->loadData($first);

        Arr::set($this->config, $key, $value);

        return $this;
    }

    /**
     * コンフィグデータの存在チェック
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool
    {
        [$first, $last] = Arr::firstDotKey($key);
        $this->loadData($first);

        return Arr::has($this->config, $key);
    }

    /**
     * コンフィグファイルの有無
     *
     * @param string $key
     * @return boolean
     */
    public function exists(string $key): bool
    {
        [$first, $last] = Arr::firstDotKey($key);

        return array_key_exists($first, $this->config);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        // 処理なし
    }
}
