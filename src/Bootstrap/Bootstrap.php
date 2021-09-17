<?php

namespace Takemo101\PHPSupport\Bootstrap;

use Takemo101\PHPSupport\Contract\Bootstrap\LoaderResolver as Contract;

/**
 * bootstrap class
 */
class Bootstrap
{
    /**
     * @var array<string>
     */
    private $loader = [
        //
    ];

    /**
     * ローダー解決クラス
     *
     * @var Contract
     */
    private $resolver;

    public function __construct(?Contract $resolver = null)
    {
        $this->setLoaderResolver(
            $resolver ?? new LoaderResolver
        );
    }

    /**
     * パッケージの起動処理
     * 全てのローダーを実行する
     *
     * @return void
     */
    public function boot()
    {
        $this->load();
    }

    /**
     * ローダーの追加
     *
     * @param string|array $loader
     * @return self
     */
    public function addLoader(string|array $loader): self
    {
        $loaders = is_array($loader) ? $loader : [$loader];
        $this->loader = array_unique(
            array_merge(
                $this->loader,
                $loaders
            )
        );

        return $this;
    }

    /**
     * ローダーを全て実行
     *
     * @return void
     */
    private function load()
    {
        foreach ($this->loader as $loader) {
            $this->resolver
                ->create($loader)
                ->load();
        }
    }

    /**
     * ローダー解決クラスをセット
     *
     * @param Contract $resolver
     * @return self
     */
    public function setLoaderResolver(Contract $resolver): self
    {
        $this->resolver = $resolver;

        return $this;
    }
}
