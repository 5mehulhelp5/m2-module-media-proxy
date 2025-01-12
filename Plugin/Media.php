<?php

declare(strict_types=1);

namespace SamJUK\MediaProxy\Plugin;

use SamJUK\MediaProxy\Api\ConfigInterface;
use SamJUK\MediaProxy\Api\RequestedMediaInterface;
use Magento\Framework\HTTP\PhpEnvironment\Response;
use Magento\MediaStorage\App\Media as BaseMedia;

class Media
{
    private readonly ConfigInterface $config;
    private readonly RequestedMediaInterface $requestedMedia;

    public function __construct(
        ConfigInterface $config,
        RequestedMediaInterface $requestedMedia
    ) {
        $this->config = $config;
        $this->requestedMedia = $requestedMedia;
    }

    public function aroundLaunch(BaseMedia $subject, callable $proceed)
    {
        if ($this->config->isProxyMode()) {
            return $this->createRedirect(
                $this->requestedMedia->getUpstreamUrl()
            );
        }

        if ($this->config->isCacheMode() && !$this->requestedMedia->exists()) {
            $this->requestedMedia->sync();
        }

        return $proceed();
    }

    private function createRedirect($url, $code = 302)
    {
        return (new Response())->setRedirect(
            $url,
            $code
        );
    }
}
