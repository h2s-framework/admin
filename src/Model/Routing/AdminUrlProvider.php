<?php

namespace Siarko\Admin\Model\Routing;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\UrlService\UrlProvider;
use Siarko\UrlService\UrlUtils;
use Siarko\Utils\EnvLoader;

class AdminUrlProvider
{

    public const ENV_CONFIG_PATH = 'admin.url';
    public const DEFAULT_URL = 'admin';

    /**
     * @param EnvLoader $envLoader
     * @param UrlProvider $urlProvider
     */
    public function __construct(
        private readonly EnvLoader $envLoader,
        private readonly UrlProvider $urlProvider
    )
    {
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->envLoader->getData(self::ENV_CONFIG_PATH) ?? self::DEFAULT_URL;
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    public function getAbsoluteUrl(): string
    {
        return UrlUtils::implode([
            $this->urlProvider->getBaseUrl(),
            $this->get()
        ]);
    }
}