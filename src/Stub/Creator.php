<?php

namespace Takemo101\PHPSupport\Stub;

use Takemo101\PHPSupport\Contract\Stub\Parser as Contract;
use Takemo101\PHPSupport\File\{
    ExtractType,
    System,
};

/**
 * stub create manager
 */
class Creator
{
    /**
     * stub parser
     *
     * @var Contract
     */
    protected $parser;

    /**
     * stub path map
     * 出力元stubファイルパス => 出力先パス配列
     *
     * @var array<array>
     */
    private $map = [];

    public function __construct(?Contract $parser = null)
    {
        $this->setParser(
            $parser ?? new Parser
        );
    }

    /**
     * パスを追加
     *
     * @param string $from
     * @param string|array $path
     * @return self
     */
    public function addPath(string $from, string|array $path): self
    {
        $paths = is_array($path) ? $path : [$path];

        if (array_key_exists($from, $this->map)) {
            $paths = array_unique(
                array_merge(
                    $this->map[$from],
                    $paths
                )
            );
        }

        $this->map[$from] = $paths;

        return $this;
    }

    /**
     * パスを追加（複数）
     *
     * @param array $paths
     * @return self
     */
    public function addPaths(array $paths): self
    {
        foreach ($paths as $from => $path) {
            $this->addPath($from, $path);
        }

        return $this;
    }

    /**
     * stubパスマッピングをクリアする
     *
     * @return self
     */
    public function clear(): self
    {
        $this->map = [];

        return $this;
    }

    /**
     * stubの作成処理
     *
     * @param array $data
     * @return self
     */
    public function create(array $data = []): self
    {
        foreach ($this->map as $from => $paths) {
            if ($fromText = System::read($from)) {
                foreach ($paths as $path) {
                    // 出力元のテキストと出力先のパスを変換
                    $toText = $this->parse($fromText, $data);
                    $toPath = $this->parse($path, $data);

                    $directory = System::extract($toPath, ExtractType::DirectoryName);

                    // ディレクトリを作成
                    if (!(System::exists($directory) && System::isDirectory($directory))) {
                        System::makeDirectory($directory);
                    }

                    // 書き込み
                    System::write($toPath, $toText);
                }
            }
        }

        return $this;
    }

    /**
     * 変換器による変換処理
     *
     * @param string $stub
     * @param array $data
     * @return string
     */
    public function parse(string $stub, array $data = []): string
    {
        return $this->parser->parse($stub, $data);
    }

    /**
     * stub変換クラスをセット
     *
     * @param Contract $parser
     * @return self
     */
    public function setParser(Contract $parser): self
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * パス配列を追加してインスタンス生成
     *
     * @param array $paths
     * @return self
     */
    public static function ofPaths(array $paths = []): self
    {
        return (new static())->addPaths($paths);
    }
}
