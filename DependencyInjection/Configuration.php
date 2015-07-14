<?php

namespace FOS\MessageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fos_message');

        $rootNode
            ->children()
                ->scalarNode('driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('models')
                    ->isRequired()
                    ->children()
                        ->scalarNode('message_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('message_metadata_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('thread_class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('thread_metadata_class')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('services')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('composer')->defaultValue('fos_message.composer.default')->cannotBeEmpty()->end()
                        ->scalarNode('deleter')->defaultValue('fos_message.deleter.default')->cannotBeEmpty()->end()
                        ->scalarNode('provider')->defaultValue('fos_message.provider.default')->cannotBeEmpty()->end()
                        ->scalarNode('reader')->defaultValue('fos_message.reader.default')->cannotBeEmpty()->end()
                        ->scalarNode('remover')->defaultValue('fos_message.remover.default')->cannotBeEmpty()->end()
                        ->scalarNode('sender')->defaultValue('fos_message.sender.default')->cannotBeEmpty()->end()
                        ->scalarNode('updater')->defaultValue('fos_message.updater.default')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
