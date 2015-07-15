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
use FOS\Message\Api\Model\ThreadInterface;

/**
 * Manages permissions to manipulate threads and messages
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
interface AuthorizerInterface
{
    /**
     * Tells if the current user is allowed to see the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canSeeThread(ThreadInterface $thread);

    /**
     * Tells if the current user is allowed to delete the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canDeleteThread(ThreadInterface $thread);

    /**
     * Tells if the current user is allowed to reply to the thread
     *
     * @param ThreadInterface $thread
     *
     * @return boolean
     */
    public function canReplyToThread(ThreadInterface $thread);

    /**
     * Tells if the current user is allowed to send a message to this other participant
     *
     * @param ParticipantInterface $participant
     *
     * @return boolean
     */
    public function canSendMessageTo(ParticipantInterface $participant);
}
