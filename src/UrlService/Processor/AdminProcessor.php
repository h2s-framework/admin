<?php

namespace Siarko\Admin\UrlService\Processor;

use Siarko\Admin\Model\Routing\AdminUrlProvider;
use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\UrlService\Api\UrlProcessorInterface;
use Siarko\UrlService\Processor\ProcessedUrl;
use Siarko\UrlService\UrlUtils;

class AdminProcessor implements UrlProcessorInterface
{

    public function __construct(
        private readonly AdminUrlProvider $adminUrlProvider
    )
    {
    }

    /**
     * @param ProcessedUrl $url
     * @return ProcessedUrl
     * @throws RootPathNotSet
     */
    public function processRelativeUrl(\Siarko\UrlService\Processor\ProcessedUrl $url): ProcessedUrl
    {
        if($this->isAdminUrl($url->getRelativeUrl())){
            $url->setRelativeUrl($this->processUrl($url->getRelativeUrl()));
            $url->setBaseUrl($this->adminUrlProvider->getAbsoluteUrl());
        }
        return $url;
    }

    /**
     * @param string $url
     * @return bool
     */
    private function isAdminUrl(string $url): bool
    {
        return str_starts_with($url, UrlUtils::URL_SEPARATOR.AdminUrlProvider::DEFAULT_URL);
    }

    /**
     * @param string $getRelativeUrl
     * @return string
     */
    private function processUrl(string $getRelativeUrl): string
    {
        return substr($getRelativeUrl, strlen(UrlUtils::URL_SEPARATOR.AdminUrlProvider::DEFAULT_URL));
    }
}