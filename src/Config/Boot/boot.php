<?php

\Siarko\DependencyManager\Config\Init\BootConfiguration::register([
    \Siarko\DependencyManager\Config\DMKeys::ARGUMENTS => [
        \Siarko\Api\State\Scope\ScopeProviderRegistry::class => [
            'scopeProviders' => [
                'Admin' => [
                    \Siarko\Api\State\Scope\ScopeProviderRegistry::SCOPE_PROVIDER_CLASS => \Siarko\Admin\Config\Boot\ScopeProvider::class,
                    \Siarko\Api\State\Scope\ScopeProviderRegistry::SCOPE_PROVIDER_BEFORE => 'Core'
                ]
            ]
        ]
    ]
]);