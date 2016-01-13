<?php
namespace LosMiddleware\BasePath;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelperFactory as ZendUrlHelperFactory;

class UrlHelperFactory extends ZendUrlHelperFactory
{
    /**
     * Create a UrlHelper instance.
     *
     * @param ContainerInterface $container
     * @return \Zend\Expressive\Helper\UrlHelper
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $path = array_key_exists('los_basepath', $config) && !empty($config['los_basepath'])
            ? $config['los_basepath']
            : null;

        $helper = parent::__invoke($container);
        $helper->setBasePath($path);
        return $helper;
    }
}