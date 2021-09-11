<?php

namespace Takemo101\PHPSupport\Path;

/**
 * path helper class
 */
class PathHelper
{
    /**
     * @var string
     */
    protected $separator = DIRECTORY_SEPARATOR;

    /**
     * パスの結合
     *
     * @param string ...$args
     * @return string
     */
    public function join(string ...$args): string
    {
        if (count($args) === 0) {
            return '';
        }

        $components = [];
        foreach ($args as $component) {
            $components = [
                ...$components,
                ...array_filter(explode('/', $component))
            ];
        }

        $result = $this->normalize($components);

        return implode($this->separator, $result);
    }

    /**
     * パスを各階層ごとの配列に分離
     *
     * @param string $path
     * @return array<string>
     */
    public function split(string $path): array
    {
        return $this->normalize(
            array_filter(explode('/', $path))
        );
    }

    /**
     * 結合可能な配列に整える
     *
     * @param array $components
     * @return array<string>
     */
    protected function normalize(array $components): array
    {
        $result = [];
        foreach ($components as $key => $component) {
            $trim = $key == 0 ? rtrim($component, $this->separator) : $this->trim($component);
            if (strlen($trim) == 0) {
                continue;
            }

            $result[] = $trim;
        }

        return $result;
    }

    /**
     * パスに不必要な文字をトリミング
     *
     * @param string $path
     * @return void
     */
    public function trim(string $path)
    {
        $path = str_replace(' ', '', $path);
        return trim($path, $this->separator);
    }

    /**
     * パスのセパレーターを設定
     *
     * @param string $separator
     * @return self
     */
    public function setSeparator(string $separator): self
    {
        $this->separator = $separator;

        return $this;
    }
}
