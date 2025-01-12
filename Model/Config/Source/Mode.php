<?php

namespace SamJUK\MediaProxy\Model\Config\Source;

use SamJUK\MediaProxy\Enum\Mode as ModeEnum;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Mode extends AbstractSource
{
    public function getAllOptions()
    {
        $this->_options = [
            ['label' => 'Proxy', 'value' => ModeEnum::Proxy->value],
            ['label' => 'Cache', 'value' => ModeEnum::Cache->value]
        ];
        return $this->_options;
    }
}
