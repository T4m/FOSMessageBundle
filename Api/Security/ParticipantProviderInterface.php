<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Api\Security;

use FOS\Message\Api\Model\ParticipantInterface;

/**
 * Provides the authenticated participant
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface ParticipantProviderInterface
{
    /**
     * Gets the current authenticated user or null if no participant is authenticated
     *
     * @return ParticipantInterface|null
     */
    public function getAuthenticatedParticipant();
}
