<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Security;

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Provides the authenticated participant
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class ParticipantProvider implements ParticipantProviderInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Gets the current authenticated user or null if no participant is authenticated
     *
     * @return ParticipantInterface|null
     */
    public function getAuthenticatedParticipant()
    {
        $token = $this->tokenStorage->getToken();

        if ($token instanceof TokenInterface) {
            $participant = $token->getUser();

            if (! $participant instanceof ParticipantInterface) {
                throw new AccessDeniedException('Must be logged in with a ParticipantInterface instance');
            }

            return $participant;
        }

        return null;
    }
}
