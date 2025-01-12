<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Model;

use SamJUK\MediaProxy\Enum\Mode;
use SamJUK\MediaProxy\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config implements ConfigInterface
{
    private const XML_PATH_ENABLED = 'samjuk_media_proxy/general/enabled';
    private const XML_PATH_MODE = 'samjuk_media_proxy/general/mode';
    private const XML_PATH_UPSTREAM_HOST = 'samjuk_media_proxy/general/upstream_host';

    private readonly ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfigInterface
    ) {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isEnabled(): bool
    {
        return $this->getFlag(self::XML_PATH_ENABLED);
    }

    public function getUpstreamHost(): string
    {
        return rtrim($this->getValue(self::XML_PATH_UPSTREAM_HOST), '/');
    }

    public function getMode(): Mode
    {
        return Mode::from($this->getValue(self::XML_PATH_MODE));
    }

    public function isProxyMode(): bool
    {
        return $this->isEnabled() && $this->getMode() === Mode::Proxy;
    }

    public function isCacheMode(): bool
    {
        return $this->isEnabled() && $this->getMode() === Mode::Cache;
    }

    private function getFlag($path, $scope = 'default', $scopeCode = null): bool
    {
        return (bool)$this->scopeConfig->isSetFlag(
            $path,
            $scope,
            $scopeCode
        );
    }

    private function getValue($path, $scope = 'default', $scopeCode = null): mixed
    {
        return $this->scopeConfig->getValue(
            $path,
            $scope,
            $scopeCode
        );
    }
}
