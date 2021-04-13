<?php

declare(strict_types=1);

namespace LosMiddleware\BasePath;

use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

use function assert;
use function is_array;
use function is_string;

final class BasePathMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): BasePathMiddleware
    {
        $config = $container->get('config');
        assert(is_array($config));

        $path = $config['los']['basepath'] ?? $config['los_basepath'] ?? '';
        assert(is_string($path));

        $urlHelper = $container->has(UrlHelper::class) ? $container->get(UrlHelper::class) : null;
        assert($urlHelper instanceof UrlHelper || $urlHelper === null);

        return new BasePathMiddleware($path, $urlHelper);
    }
}
