<?php

namespace Siarko\Admin\Model\Routing;

use Siarko\ActionRouting\Api\Routing\RouterInterface;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;
use Siarko\ActionRouting\Routing\Router;
use Siarko\ActionRouting\Routing\RouterFactory;
use Siarko\ActionRouting\Routing\Url\RequestDataProviderInterface;
use Siarko\ActionRouting\Routing\Url\RequestDataProviderInterfaceFactory;
use Siarko\UrlService\UrlProvider;
use Siarko\UrlService\UrlUtils;

class AdminRouter implements RouterInterface
{

    /**
     * @param RequestDataProviderInterface $requestDataProvider
     * @param RequestDataProviderInterfaceFactory $requestDataProviderFactory
     * @param AdminUrlProvider $adminUrlProvider
     * @param RouterFactory $defaultRouterFactory
     */
    public function __construct(
        private readonly RequestDataProviderInterface $requestDataProvider,
        private readonly RequestDataProviderInterfaceFactory $requestDataProviderFactory,
        private readonly AdminUrlProvider             $adminUrlProvider,
        private readonly RouterFactory                       $defaultRouterFactory
    )
    {
    }


    /**
     * @return UrlMatchResult|null
     */
    public function match(): ?UrlMatchResult
    {
        $frontendRouter = $this->defaultRouterFactory->createNamed(
            requestDataProvider:  $this->getCustomRequestDataProvider()
        );
        return $frontendRouter->match();
    }

    /**
     * @return string
     */
    private function getAdminUrl(): string
    {
        $adminUrl = $this->adminUrlProvider->get();
        $currentUrl = $this->requestDataProvider->getRequestUrl();
        $suffix = substr($currentUrl, strlen($adminUrl));
        return UrlUtils::implode([AdminUrlProvider::DEFAULT_URL, $suffix]);
    }

    /**
     * @return RequestDataProviderInterface
     */
    private function getCustomRequestDataProvider(): RequestDataProviderInterface
    {
        $provider = $this->requestDataProviderFactory->create();
        $provider->setRequestUrl($this->getAdminUrl());
        return $provider;
    }
}