<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Api;

use SamJUK\MediaProxy\Enum\Mode;

interface ConfigInterface
{

    /**
     * Feature flag to determine if the module functionality is enabled
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Get the upstream host for the current store
     * @return string
     */
    public function getUpstreamHost(): string;

    /**
     * Get the current mode the module is operating in.
     * @return Mode
     */
    public function getMode(): Mode;

    /**
     * Is the module enabled & operating in proxy mode for the current store.
     * @return bool
     */
    public function isProxyMode(): bool;

    /**
     * Is the module enabled & operating in cache mode for the current store.
     * @return bool
     */
    public function isCacheMode(): bool;
}
