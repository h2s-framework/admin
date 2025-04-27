<?php

namespace Siarko\Admin\BlockLayout\Template\Variable;

use Siarko\Admin\Model\Routing\AdminUrlProvider;
use Siarko\BlockLayout\Api\Template\DataNodeVariableValueProvider;
use Siarko\Paths\Exception\RootPathNotSet;

class BaseUrlProvider implements DataNodeVariableValueProvider
{

    /**
     * @param AdminUrlProvider $adminUrlProvider
     */
    public function __construct(
        private readonly AdminUrlProvider $adminUrlProvider
    )
    {
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    public function getValue(): string
    {
        return $this->adminUrlProvider->getAbsoluteUrl();
    }

}