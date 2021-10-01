<?php

namespace Takemo101\PHPSupport\Collection\Support;

use InvalidArgumentException;

trait CheckTypeTrait
{
    /**
     * コレクション要素の型
     *
     * @var string
     */
    protected $type = 'mixed';

    /**
     * 要素の型
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * 設定された要素の型から要素をチェック
     *
     * @param mixed $element
     * @throws InvalidArgumentException
     * @return void
     */
    protected function checkElementType($element)
    {
        $type = $this->type();
        if (!$this->checkType($type, $element)) {
            throw new InvalidArgumentException("element type not [{$type}]");
        }
    }

    /**
     * 配列要素の型を全てチェック
     *
     * @param array $elements
     * @throws InvalidArgumentException
     * @return void
     */
    protected function checkElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->checkElementType($element);
        }
    }

    /**
     * 要素の型チェック
     *
     * @param string $type
     * @param mixed $element
     * @return void
     */
    protected function checkType(string $type, $element)
    {
        switch (strtolower($type)) {
            case 'array':
                return is_array($element);
            case 'bool':
            case 'boolean':
                return is_bool($element);
            case 'callable':
                return is_callable($element);
            case 'float':
            case 'double':
                return is_float($element);
            case 'int':
            case 'integer':
                return is_int($element);
            case 'null':
                return $element === null;
            case 'numeric':
                return is_numeric($element);
            case 'object':
                return is_object($element);
            case 'resource':
                return is_resource($element);
            case 'scalar':
                return is_scalar($element);
            case 'string':
                return is_string($element);
            case 'mixed':
                return true;
            default:
                return $element instanceof $type;
        }
    }
}
