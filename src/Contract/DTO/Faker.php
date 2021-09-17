<?php

namespace Takemo101\PHPSupport\Contract\DTO;

/**
 * dto faker interface
 * このインタフェースを実装したDTOは
 * FakerFactoryで簡単なフェイクインスタンスを生成できる
 */
interface Faker
{
    /**
     * fake parameter
     *
     * @return array
     */
    public function fakeParameter(): array;
}
