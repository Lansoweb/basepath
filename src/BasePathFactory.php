<?php

namespace LosMiddleware\BasePath;

use Interop\Container\ContainerInterface;

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

        return new BasePath($path);
    }
}
