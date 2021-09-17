<?php

namespace Takemo101\PHPSupport\DTO;

use Takemo101\PHPSupport\Contract\DTO\PropertyType;

/**
 * コメントタイプ
 */
final class CommentPropertyType implements PropertyType
{
    /**
     * 型の名前
     *
     * @var string
     */
    private $type;

    /**
     * null許容 or nullか
     *
     * @var boolean
     */
    private $optional = false;

    /**
     * construct
     *
     * @param string $comment
     */
    public function __construct(
        string $comment
    ) {
        $this->setCommentString($comment);
    }

    /**
     * null許容を有効
     *
     * @return self
     */
    private function enableOptional(): self
    {
        $this->optional = true;

        return $this;
    }

    /**
     * コメント型をセット
     *
     * @param string $comment
     * @return self
     */
    private function setCommentString(string $comment): self
    {
        $type = trim($comment);
        if (strpos($type, '?') === 0) {
            $this->enableOptional();
            $type = str_replace('?', '', $type);
        }

        if (strtolower($type) == 'null') {
            $this->enableOptional();
        }

        $this->type = $type;

        return $this;
    }

    /**
     * 元の型
     *
     * @return string
     */
    public function getOriginalTypeName(): string
    {
        return $this->type;
    }

    /**
     * 整理された型
     *
     * @return string
     */
    public function getTypeName(): string
    {
        $type = $this->getOriginalTypeName();
        if ($this->isBuiltin()) {
            switch ($type) {
                case 'bool':
                    return 'boolean';
                case 'int':
                    return 'integer';
            }
        }

        return $type;
    }

    /**
     * プリミティブ（ビルドイン）型か
     *
     * @return boolean
     */
    public function isBuiltin(): bool
    {
        return in_array(strtolower($this->type), [
            'array',
            'bool',
            'boolean',
            'callable',
            'float',
            'double',
            'int',
            'integer',
            'null',
            // 'object',
            'resource',
            'string',
            'mixed',
        ]);
    }

    /**
     * null許容 or nullか
     *
     * @return boolean
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }

    /**
     * コメントからインスタンス生成
     * プロパティ設定がなければnullを返す
     *
     * @param string $comment
     * @return array
     */
    public static function fromCommentString(string $comment): array
    {
        $result = [];

        if (preg_match('/@var\s+([^\s]+)/', $comment, $matches)) {
            [, $type] = $matches;

            $types = explode('|', $type);

            foreach ($types as $t) {
                if ($t) {
                    $result[] = new static($t);
                }
            }
        }

        return $result;
    }
}
