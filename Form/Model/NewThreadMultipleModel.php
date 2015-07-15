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

use Doctrine\Common\Collections\ArrayCollection;
use FOS\Message\Api\Model\ParticipantInterface;

/**
 * Model representing the form data of a new thread with multiple recipients
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class NewThreadMultipleModel extends ContentModel
{
    /**
     * The user who receives the message
     *
     * @var ParticipantInterface[]|ArrayCollection
     */
    protected $recipients;

    /**
     * The thread subject
     *
     * @var string
     */
    protected $subject;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipients = new ArrayCollection();
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

    /**
     * @return ArrayCollection|\FOS\Message\Api\Model\ParticipantInterface[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param ParticipantInterface $recipient
     */
    public function addRecipient(ParticipantInterface $recipient)
    {
        if (! $this->recipients->contains($recipient)) {
            $this->recipients->add($recipient);
        }
    }

    /**
     * @param ParticipantInterface $recipient
     */
    public function removeRecipient(ParticipantInterface $recipient)
    {
        $this->recipients->removeElement($recipient);
    }
}
