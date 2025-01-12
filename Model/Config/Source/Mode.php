<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Mode extends AbstractSource
{
    public const PROXY = 'proxy';
    public const CACHE = 'cache';

    public function getAllOptions()
    {
        $this->_options = [
            ['label' => 'Proxy', 'value' => static::PROXY],
            ['label' => 'Cache', 'value' => static::CACHE]
        ];
        return $this->_options;
    }
}
