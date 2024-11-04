<?php

namespace Siarko\Admin\Config\Boot;

use Siarko\Admin\Model\Routing\AdminUrlProvider;
use Siarko\UrlService\UrlProvider;

class ScopeProvider implements \Siarko\Api\State\Scope\ScopeProviderInterface
{


    public const SCOPE_ID = 'admin';

    public function __construct(
        private readonly UrlProvider $urlProvider,
        private readonly AdminUrlProvider $adminUrlProvider
    )
    {
    }

    /**
     * @return ?string
     */
    public function getScope(): ?string
    {
        if(str_starts_with($this->urlProvider->getSuffix(), $this->adminUrlProvider->get())){
            return self::SCOPE_ID;
        }
        return null;
    }
}