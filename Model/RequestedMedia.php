<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Model;

use SamJUK\MediaProxy\Api\RequestedMediaInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverInterface as FilesystemDriverInterface;

class RequestedMedia implements RequestedMediaInterface
{
    private readonly string $relativePath;
    private readonly string $absolutePubPath;
    private readonly string $upstreamHost;
    private readonly FilesystemDriverInterface $filesystem;

    public function __construct(
        FilesystemDriverInterface $filesystem,
        DirectoryList $directoryList,
        Config $config
    ) {
        $this->filesystem = $filesystem;
        // remove the cache id, its very unlike to align across different environments.
        $this->relativePath = preg_replace(
            '#/cache/[a-zA-Z0-9]*/#',
            '/',
            $GLOBALS['relativePath'] // phpcs:ignore
        );
        $this->absolutePubPath = $directoryList->getPath('pub');
        $this->upstreamHost = $config->getUpstreamHost();
    }

    public function getAbsolutePath(): string
    {
        return "{$this->absolutePubPath}/{$this->relativePath}";
    }

    public function getUpstreamUrl(): string
    {
        return "{$this->upstreamHost}/{$this->relativePath}";
    }

    public function exists(): bool
    {
        return $this->filesystem->isReadable($this->getAbsolutePath());
    }

    public function sync(): bool
    {
        $this->createDirectories();

        return (bool)$this->filesystem->filePutContents(
            $this->getAbsolutePath(),
            $this->filesystem->fileGetContents($this->getUpstreamUrl())
        );
    }

    private function createDirectories(): bool
    {
        return $this->filesystem->createDirectory(
            $this->getAbsolutePath(),
            0755
        );
    }
}
