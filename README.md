# PHPSupport

PHP で Package 開発を行うのに必要な実装サポートツールをまとめたものです。  
単純な実装や抽象的な機能のみを提供するツールなので、高機能なものが必要な場合は他のライブラリを利用することをお勧めします。

## Arr

配列操作をサポート

example:

```
use Takemo101\PHPSupport\Arr\Arr;

// return string 'hello'
$c = Arr::get([
    'a' => [
        'b' => [
            'c' => 'hello',
        ],
    ],
];, 'a.b.c');
```

## Bootstrap

パッケージの初期処理をサポート

## Collection

コレクション実装をサポート

example:

```
use Takemo101\PHPSupport\Collection\ArrayCollection;

$collection = new ArrayCollection([
    'a',
    'b',
    'c',
]);
$collection->add('d');

foreach ($collection as $item) {
    //
}
```

## Enum

列挙型の実装をサポート

example:

```
use Takemo101\PHPSupport\Enum\AbstractEnum;

class Enum extends AbstractEnum
{
    const One = 'one';
    const Two = 'two';
    const Three = 'three';
}
```

## Event

同期イベントの実装をサポート

## Config

パッケージの設定をサポート

## Facade

ファザードの実装をサポート（シンプルな DI コンテナ含む）

container example:

```
Injector::bind(ExampleService::class);

/** @var ExampleService $service */
$service = Injector::make(ExampleService::class);
```

## File（利用非推奨）

簡単なファイル操作をサポート（ただしローカルストレージの操作のみで簡単な操作しか用意してません）  
※ パッケージで簡単なファイル操作する場合にのみ利用します

## Path

パス加工をサポート（主に結合）

## DataTransferObject（DTO）

DataTransferObject の実装をサポート

## Stub

Stub 生成の実装をサポート
