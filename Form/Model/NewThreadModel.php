<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Form\Model;

use FOS\Message\Api\Model\ParticipantInterface;

/**
 * Model representing the form data of a new thread with a single recipient
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NewThreadModel extends ContentModel
{
    /**
     * The user who receives the message
     *
     * @var ParticipantInterface
     */
    protected $recipient;

    /**
     * The thread subject
     *
     * @var string
     */
    protected $subject;

    /**
     * @return ParticipantInterface
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param ParticipantInterface $recipient
     */
    public function setRecipient(ParticipantInterface $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
}
