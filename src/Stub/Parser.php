<?php

namespace Takemo101\PHPSupport\Stub;

use Takemo101\PHPSupport\Contract\Stub\Parser as Contract;

/**
 * stub parser
 */
class Parser implements Contract
{
    /**
     * stubテキストを変換する
     *
     * @param string $stub
     * @param array $data
     * @return string
     */
    public function parse(string $stub, array $data = []): string
    {
        $result = $stub;
        foreach ($data as $key => $value) {
            $result = str_replace(
                $this->createReplacePatterns($key),
                $value,
                $result
            );
        }

        return $result;
    }

    /**
     * 置換するためのパターンを返す
     *
     * @param string $key
     * @return array
     */
    protected function createReplacePatterns(string $key): array
    {
        return [
            '{{ ' . $key . ' }}',
            '{{ ' . $key . '}}',
            '{{' . $key . ' }}',
            '{{' . $key . '}}',
        ];
    }
}
