<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Twig\Extension;

use FOS\Message\Api\Model\ReadableInterface;
use FOS\Message\Api\Model\ThreadInterface;
use FOS\Message\Api\Provider\ProviderInterface;
use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;

/**
 * Twig extension providing useful functions in templates
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class MessageExtension extends \Twig_Extension
{
    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @var AuthorizerInterface
     */
    protected $authorizer;

    /**
     * @var integer
     */
    protected $nbUnreadMessagesCache;

    /**
     * Constructor
     *
     * @param ParticipantProviderInterface $participantProvider
     * @param ProviderInterface $provider
     * @param AuthorizerInterface $authorizer
     */
    public function __construct(
        ParticipantProviderInterface $participantProvider,
        ProviderInterface $provider,
        AuthorizerInterface $authorizer
    ) {
        $this->participantProvider = $participantProvider;
        $this->provider = $provider;
        $this->authorizer = $authorizer;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            'fos_message_is_read'  => new \Twig_Function_Method($this, 'isRead'),
            'fos_message_nb_unread' => new \Twig_Function_Method($this, 'getNbUnread'),
            'fos_message_can_delete_thread' => new \Twig_Function_Method($this, 'canDeleteThread'),
            'fos_message_deleted_by_participant' => new \Twig_Function_Method($this, 'isThreadDeletedByParticipant')
        );
    }

    /**
     * Tells if this readable (thread or message) is read by the current user
     *
     * @return boolean
     */
    public function isRead(ReadableInterface $readable)
    {
        return $readable->isReadByParticipant($this->participantProvider->getAuthenticatedParticipant());
    }
    
    
    /**
     * Checks if the participant can mark a thread as deleted
     * 
     * @param ThreadInterface $thread
     * 
     * @return boolean true if participant can mark a thread as deleted, false otherwise
     */
    public function canDeleteThread(ThreadInterface $thread)
    {
        return $this->authorizer->canDeleteThread($thread);
    }
    
    /**
     * Checks if the participant has marked the thread as deleted
     * 
     * @param ThreadInterface $thread
     * 
     * @return boolean true if participant has marked the thread as deleted, false otherwise
     */
    public function isThreadDeletedByParticipant(ThreadInterface $thread)
    {
       return $thread->isDeletedByParticipant($this->participantProvider->getAuthenticatedParticipant());
    }

    /**
     * Gets the number of unread messages for the current user
     *
     * @return int
     */
    public function getNbUnread()
    {
        return 0;
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'fos_message';
    }
}
