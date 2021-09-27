<?php

namespace Takemo101\PHPSupport\Contract\Stub;

/**
 * parse stub text
 * stubテキストを変換するクラス
 */
interface Parser
{
    /**
     * stubテキストを変換する
     *
     * @param string $stub
     * @param array $data
     * @return string
     */
    public function parse(string $stub, array $data = []): string;
}
