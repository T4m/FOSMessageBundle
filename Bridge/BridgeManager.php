<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Bridge;

use RuntimeException;
use FOS\MessageBundle\Api\Bridge\BridgeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Static list of available FOSMessageBundle bridges.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class BridgeManager
{
    /**
     * @var BridgeInterface[]
     */
    private static $bridges = [
        'fos_user' => 'FOS\MessageBundle\Bridge\FOSUser\FOSUserBridge',
        'knp_paginator' => 'FOS\MessageBundle\Bridge\KnpPaginator\KnpPaginatorBridge',
    ];

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Register the available bridges in the container
     */
    public function registerAvailableBridge()
    {
        foreach (self::$bridges as $alias => $class) {
            $this->container->setParameter('fos_message.bridges.classes.' . $alias, $class);
            $this->container->setParameter('fos_message.bridges.states.' . $alias, false);
        }
    }

    /**
     * @return array
     */
    public function getAvailableBridges()
    {
        return self::$bridges;
    }

    /**
     * @param string $bridge
     * @throws RuntimeException
     */
    public function enable($bridge)
    {
        if (! array_key_exists($bridge, self::$bridges)) {
            throw new RuntimeException(sprintf(
                'Bridge "%s" is not a valid FOSMessageBundle bridge (availabe bridges: %s)',
                $bridge,
                array_keys(self::$bridges)
            ));
        }

        $bridgeClass = self::$bridges[$bridge];

        if (! $bridgeClass::canBeEnabled()) {
            throw new RuntimeException(sprintf(
                'Bridge "%s" can not be enabled (probably because the underlying library / bundle is not available)',
                $bridge
            ));
        }

        $this->container->setParameter('fos_message.bridges.states.' . $bridge, true);
    }

    /**
     * @param string $bridge
     * @return bool
     */
    public function isEnabled($bridge)
    {
        if (! array_key_exists($bridge, self::$bridges)) {
            return false;
        }

        if (! $this->container->hasParameter('fos_message.bridges.states.' . $bridge)) {
            return false;
        }

        return (bool) $this->container->getParameter('fos_message.bridges.states.' . $bridge);
    }
}