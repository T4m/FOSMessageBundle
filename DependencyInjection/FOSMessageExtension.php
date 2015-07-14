<?php

namespace FOS\MessageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FOSMessageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load(sprintf('%s.yml', $config['driver']));
        $loader->load('services.yml');

        $container->setParameter('fos_message.message_class', $config['models']['message_class']);
        $container->setParameter('fos_message.message_metadata_class', $config['models']['message_metadata_class']);
        $container->setParameter('fos_message.thread_class', $config['models']['thread_class']);
        $container->setParameter('fos_message.thread_metadata_class', $config['models']['thread_metadata_class']);

        $container->setAlias('fos_message.composer', $config['services']['composer']);
        $container->setAlias('fos_message.deleter', $config['services']['deleter']);
        $container->setAlias('fos_message.provider', $config['services']['provider']);
        $container->setAlias('fos_message.reader', $config['services']['reader']);
        $container->setAlias('fos_message.remover', $config['services']['remover']);
        $container->setAlias('fos_message.sender', $config['services']['sender']);
        $container->setAlias('fos_message.updater', $config['services']['updater']);
    }
}
