<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * FOSMessageBundle configuration definition
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
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
                        ->scalarNode('searcher')->defaultValue('fos_message.searcher.default')->cannotBeEmpty()->end()
                        ->scalarNode('sender')->defaultValue('fos_message.sender.default')->cannotBeEmpty()->end()
                        ->scalarNode('updater')->defaultValue('fos_message.updater.default')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('fields')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('recipient')->defaultValue('_default_')->cannotBeEmpty()->end()
                        ->scalarNode('subject')->defaultValue('text')->cannotBeEmpty()->end()
                        ->scalarNode('content')->defaultValue('textarea')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('forms')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('new_thread')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('fos_message_new_thread')->cannotBeEmpty()->end()
                                ->scalarNode('model')->defaultValue('FOS\MessageBundle\Form\Model\NewThreadModel')->end()
                                ->scalarNode('type')->defaultValue('fos_message.forms.new_thread.type.default')->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue('fos_message.forms.new_thread.factory.default')->cannotBeEmpty()->end()
                                ->scalarNode('handler')->defaultValue('fos_message.forms.new_thread.handler.default')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('reply')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('fos_message_reply')->cannotBeEmpty()->end()
                                ->scalarNode('model')->defaultValue('FOS\MessageBundle\Form\Model\ReplyModel')->end()
                                ->scalarNode('type')->defaultValue('fos_message.forms.reply.type.default')->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue('fos_message.forms.reply.factory.default')->cannotBeEmpty()->end()
                                ->scalarNode('handler')->defaultValue('fos_message.forms.reply.handler.default')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
