<?php declare(strict_types=1);

namespace SamJUK\MediaProxy\Test\Unit\Plugin;

use PHPUnit\Framework\TestCase;
use SamJUK\MediaProxy\Plugin\Media as MediaPlugin;
use SamJUK\MediaProxy\Model\Config;
use SamJUK\MediaProxy\Model\RequestedMedia;

use Magento\MediaStorage\App\Media as BaseMedia;

class MediaTest extends TestCase
{
    public function testPluginReturnsRedirectInProxyMode()
    {
        $config = $this->createMock(Config::class);
        $requestedMedia = $this->createMock(RequestedMedia::class);
        $baseMedia = $this->createMock(BaseMedia::class);
        $mediaPlugin = new MediaPlugin($config, $requestedMedia);

        $config->method('isProxyMode')
            ->willReturn(true);

        $response = $mediaPlugin->aroundLaunch(
            $baseMedia,
            [$baseMedia, 'launch']
        );

        $this->assertTrue($response->isRedirect());
    }

    public function testPluginSyncsMediaInCacheModeWhenMissing()
    {
        $config = $this->createMock(Config::class);
        $requestedMedia = $this->createMock(RequestedMedia::class);
        $baseMedia = $this->createMock(BaseMedia::class);
        $mediaPlugin = new MediaPlugin($config, $requestedMedia);

        $config->method('isProxyMode')
            ->willReturn(false);

        $config->method('isCacheMode')
            ->willReturn(true);

        $requestedMedia->method('exists')
            ->willReturn(false);

        $requestedMedia->expects($this->once())
            ->method('sync');

        $mediaPlugin->aroundLaunch(
            $baseMedia,
            [$baseMedia, 'launch']
        );
    }

    public function testPluginDoesNotSyncsMediaInCacheModeWhenNotMissing()
    {
        $config = $this->createMock(Config::class);
        $requestedMedia = $this->createMock(RequestedMedia::class);
        $baseMedia = $this->createMock(BaseMedia::class);
        $mediaPlugin = new MediaPlugin($config, $requestedMedia);

        $config->method('isProxyMode')
            ->willReturn(false);

        $config->method('isCacheMode')
            ->willReturn(true);

        $requestedMedia->method('exists')
            ->willReturn(true);

        $requestedMedia->expects($this->never())
            ->method('sync');

        $mediaPlugin->aroundLaunch(
            $baseMedia,
            [$baseMedia, 'launch']
        );
    }

    public function testPluginDoesNothingWhenDisabled()
    {
        $config = $this->createMock(Config::class);
        $requestedMedia = $this->createMock(RequestedMedia::class);
        $baseMedia = $this->createMock(BaseMedia::class);
        $mediaPlugin = new MediaPlugin($config, $requestedMedia);

        $config->method('isProxyMode')
            ->willReturn(false);

        $config->method('isCacheMode')
            ->willReturn(false);

        $requestedMedia->expects($this->never())
            ->method('sync');

        $baseMedia->expects($this->once())
            ->method('launch');

        $mediaPlugin->aroundLaunch(
            $baseMedia,
            [$baseMedia, 'launch']
        );
    }
}
