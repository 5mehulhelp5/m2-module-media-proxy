<?php declare(strict_types=1);

namespace SamJUK\MediaProxy\Test\Unit\Model;

use PHPUnit\Framework\TestCase;

use SamJUK\MediaProxy\Model\Config;
use SamJUK\MediaProxy\Model\RequestedMedia;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverInterface as FilesystemDriverInterface;

class RequestedMediaTest extends TestCase
{
    private const SAMPLE_CACHE_TAG = 'cache/ABCDEFG012345XYZ';

    public function testAbsolutePathStripsCacheTag()
    {
        $config = $this->createMock(Config::class);
        $filesystem = $this->createMock(FilesystemDriverInterface::class);
        $directoryList = $this->createMock(DirectoryList::class);
        $directoryList->method('getPath')->willReturn('/var/www/html/pub');

        $GLOBALS['relativePath'] = sprintf(
            'media/%s/a/a/aaa.jpg',
            static::SAMPLE_CACHE_TAG
        );

        $result = (new RequestedMedia(
            $filesystem,
            $directoryList,
            $config
        ))->getAbsolutePath();

        $this->assertStringNotContainsString(static::SAMPLE_CACHE_TAG, $result);
    }

    public function testAbsolutePathDoesNotStripImageNamedCache()
    {
        $config = $this->createMock(Config::class);
        $filesystem = $this->createMock(FilesystemDriverInterface::class);
        $directoryList = $this->createMock(DirectoryList::class);
        $directoryList->method('getPath')->willReturn('/var/www/html/pub');

        $GLOBALS['relativePath'] = 'media/c/a/cache.jpg';

        $result = (new RequestedMedia(
            $filesystem,
            $directoryList,
            $config
        ))->getAbsolutePath();

        $this->assertStringContainsString($GLOBALS['relativePath'], $result);
    }
}
