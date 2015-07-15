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
use FOS\Message\Api\Model\ThreadInterface;
use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;

/**
 * Manages permissions to manipulate threads and messages
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Authorizer implements AuthorizerInterface
{
    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;


    /**
     * Constructor
     *
     * @param ParticipantProviderInterface $participantProvider
     */
    public function __construct(ParticipantProviderInterface $participantProvider)
    {
        $this->participantProvider = $participantProvider;
    }

    /**
     * Tells if the current user is allowed to see the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canSeeThread(ThreadInterface $thread)
    {
        $currentParticipant = $this->participantProvider->getAuthenticatedParticipant();

        if (! $currentParticipant) {
            return false;
        }

        return null !== $thread->getParticipantMetadata($currentParticipant);
    }

    /**
     * Tells if the current user is allowed to delete the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canDeleteThread(ThreadInterface $thread)
    {
        return $this->canSeeThread($thread);
    }

    /**
     * Tells if the current user is allowed to delete the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canReplyToThread(ThreadInterface $thread)
    {
        return $this->canSeeThread($thread);
    }

    /**
     * Tells if the current user is allowed to send a message to this other participant
     *
     * @param ParticipantInterface $participant
     *
     * @return boolean
     */
    public function canSendMessageTo(ParticipantInterface $participant)
    {
        return true;
    }
}
