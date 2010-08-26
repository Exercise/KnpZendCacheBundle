<?php

namespace Bundle\ZendCacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/*
 * (c) Thibault Duplessis <thibault.duplessis@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * ZendCacheExtension is an extension for the Zend\Cache\Manager Framework library.
 */
class ZendCacheExtension extends Extension
{
    /**
     * Loads the cache manager configuration.
     */
    public function configLoad($config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__.'/../Resources/config');
        $loader->load('manager.xml');

        if(isset($config['templates']) && is_array($config['templates'])) {
            foreach($config['templates'] as $name => $template) {
                $container->findDefinition('zend.cache_manager')->addMethodCall('setCacheTemplate', array($name, $template));
            }
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return 'http://www.symfony-project.org/schema/dic/zend';
    }

    public function getAlias()
    {
        return 'zend_cache';
    }
}