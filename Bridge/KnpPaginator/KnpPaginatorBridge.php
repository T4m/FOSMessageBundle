<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Bridge\KnpPaginator;

use FOS\MessageBundle\Api\Bridge\BridgeInterface;

/**
 * Bridge definition for KnpPaginatorBundle.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class KnpPaginatorBridge implements BridgeInterface
{
    /**
     * @inheritdoc
     */
    public static function canBeEnabled()
    {
        return class_exists('\Knp\Bundle\PaginatorBundle\KnpPaginatorBundle', true);
    }
}