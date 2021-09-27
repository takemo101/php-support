<?php

namespace Takemo101\PHPSupport\File;

use Takemo101\PHPSupport\Enum\AbstractEnum;

/**
 * extract type enum
 */
final class ExtractType extends AbstractEnum
{
    const DirectoryName = PATHINFO_DIRNAME;
    const BaseName = PATHINFO_BASENAME;
    const ExtensionName = PATHINFO_EXTENSION;
    const FileName = PATHINFO_FILENAME;
}
