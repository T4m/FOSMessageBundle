<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Api\Bridge;

/**
 * A bridge is a link between FOSMessageBundle and other bundles and libraries.
 * It implements an easy to use setup for external libraries in order to
 * create a greate Deeloper Experience for FOSMessageBundle users.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface BridgeInterface
{
    /**
     * Does this bridge can be enabled?
     * This method will probably check the presence of a library / bundle
     * and perhaps in the right version.
     *
     * @return boolean
     */
    public static function canBeEnabled();
}