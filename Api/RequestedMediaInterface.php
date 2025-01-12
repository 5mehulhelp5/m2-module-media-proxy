<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Api;

interface RequestedMediaInterface
{

    /**
     * Get the absolute path for the requested media on the local file system
     * @return string
     */
    public function getAbsolutePath(): string;
    
    /**
     * Get the full url of the requested media on the upstream host
     * @return string
     */
    public function getUpstreamUrl(): string;
    
    /**
     * Check if the requested media exists on the local file system
     * @return bool
     */
    public function exists(): bool;
 
    /**
     * Sync the image from the upstream host, to the local file system
     * @return bool
     */
    public function sync(): bool;
}
