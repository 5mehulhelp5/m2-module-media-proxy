<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Test\Unit\Model;

use PHPUnit\Framework\TestCase;

use SamJUK\MediaProxy\Model\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigTest extends TestCase
{
    private $scopeConfigInterface;

    public function setUp(): void
    {
        $this->scopeConfigInterface = $this->createMock(ScopeConfigInterface::class);
    }

    public function testProxyModeRespectsGlobalFeatureFlag()
    {
        $this->scopeConfigInterface->method('isSetFlag')
            ->willReturn(false);

        $this->scopeConfigInterface->method('getValue')
            ->willReturn('proxy');

        $config = new Config($this->scopeConfigInterface);
        $this->assertFalse($config->isProxyMode());
    }

    public function testCacheModeRespectsGlobalFeatureFlag()
    {
        $this->scopeConfigInterface->method('isSetFlag')
            ->willReturn(false);

        $this->scopeConfigInterface->method('getValue')
            ->willReturn('cache');

        $config = new Config($this->scopeConfigInterface);
        $this->assertFalse($config->isCacheMode());
    }

    public function testGetUpstreamHostTrimsTrailingSlash()
    {
        $this->scopeConfigInterface->method('getValue')
            ->willReturn('https://example.com/');

        $config = new Config($this->scopeConfigInterface);
        $this->assertStringEndsNotWith('/', $config->getUpstreamHost());
    }
}
