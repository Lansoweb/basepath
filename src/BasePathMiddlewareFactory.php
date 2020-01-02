<?php

namespace LosMiddleware\BasePath;

use Psr\Container\ContainerInterface;
use Mezzio\Helper\UrlHelper;

class BasePathMiddlewareFactory
{
    /**
     * Creates the middleware
     *
     * @param ContainerInterface $container
     * @return \LosMiddleware\BasePath\BasePathMiddleware
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $path = $config['los_basepath'] ?? '';

        $urlHelper = null;

        if ($container->has(UrlHelper::class)) {
            $urlHelper = $container->get(UrlHelper::class);
        }

        return new BasePathMiddleware($path, $urlHelper);
    }
}
