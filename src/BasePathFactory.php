<?php

namespace LosMiddleware\BasePath;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class BasePathFactory
{
    /**
     * Creates the middleware
     *
     * @param ContainerInterface $container
     * @return \LosMiddleware\BasePath\BasePath
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $path = array_key_exists('los_basepath', $config) && !empty($config['los_basepath'])
            ? $config['los_basepath']
            : null;

        $basePath = new BasePath($path);

        if ($container->has(UrlHelper::class)) {
            $basePath->setUrlHelper($container->get(UrlHelper::class));
        }

        if ($container->has(BasePathHelper::class)) {
            $basePath->setBasePathHelper($container->get(BasePathHelper::class));
        }

        return $basePath;
    }
}
