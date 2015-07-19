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

use FOS\Message\Api\Model\DeletableInterface;
use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Model\ReadableInterface;
use FOS\Message\Api\Model\ThreadInterface;
use FOS\Message\Api\Provider\ProviderInterface;
use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use FOS\MessageBundle\Form\Type\ActionFormType;
use Symfony\Component\Form\FormFactoryInterface;

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
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var ActionFormType
     */
    protected $actionFormType;

    /**
     * Simple cache array to avoid calling multiple times
     * the same service on the same page.
     *
     * @var array
     */
    protected $cache;


    /**
     * Constructor
     *
     * @param ParticipantProviderInterface $participantProvider
     * @param ProviderInterface $provider
     * @param AuthorizerInterface $authorizer
     * @param FormFactoryInterface $formFactory
     * @param ActionFormType $actionFormType
     */
    public function __construct(
        ParticipantProviderInterface $participantProvider,
        ProviderInterface $provider,
        AuthorizerInterface $authorizer,
        FormFactoryInterface $formFactory,
        ActionFormType $actionFormType
    ) {
        $this->participantProvider = $participantProvider;
        $this->provider = $provider;
        $this->authorizer = $authorizer;
        $this->formFactory = $formFactory;
        $this->actionFormType = $actionFormType;
        $this->cache = [];
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
            'fos_message_is_deleted'  => new \Twig_Function_Method($this, 'isDeleted'),

            'fos_message_can_see'  => new \Twig_Function_Method($this, 'canSee'),
            'fos_message_can_delete'  => new \Twig_Function_Method($this, 'canDelete'),
            'fos_message_can_reply'  => new \Twig_Function_Method($this, 'canReply'),
            'fos_message_can_send_message'  => new \Twig_Function_Method($this, 'canSendMessage'),

            'fos_message_count_inbox_new'  => new \Twig_Function_Method($this, 'countInboxNew'),
            'fos_message_create_action_form' => new \Twig_Function_Method($this, 'createActionForm'),
        );
    }

    /**
     * Tells if this readable entity is read by the current user
     *
     * @param ReadableInterface $readable
     * @return bool
     */
    public function isRead(ReadableInterface $readable)
    {
        return $readable->isReadByParticipant($this->participantProvider->getAuthenticatedParticipant());
    }

    /**
     * Tells if this deletable entity is deleted by the current user
     *
     * @param DeletableInterface $deletable
     * @return bool
     */
    public function isDeleted(DeletableInterface $deletable)
    {
        return $deletable->isDeletedByParticipant($this->participantProvider->getAuthenticatedParticipant());
    }


    /**
     * Tells if the current user can see this thread
     *
     * @param ThreadInterface $thread
     * @return bool
     */
    public function canSee(ThreadInterface $thread)
    {
        if (! array_key_exists('can_see_' . $thread->getId(), $this->cache)) {
            $this->cache['can_see_' . $thread->getId()] = $this->authorizer->canSeeThread($thread);
        }

        return $this->cache['can_see_' . $thread->getId()];
    }

    /**
     * Tells if the current user can delete this thread
     *
     * @param ThreadInterface $thread
     * @return bool
     */
    public function canDelete(ThreadInterface $thread)
    {
        if (! array_key_exists('can_delete_' . $thread->getId(), $this->cache)) {
            $this->cache['can_delete_' . $thread->getId()] = $this->authorizer->canDeleteThread($thread);
        }

        return $this->cache['can_delete_' . $thread->getId()];
    }

    /**
     * Tells if the current user can reply to this thread
     *
     * @param ThreadInterface $thread
     * @return bool
     */
    public function canReply(ThreadInterface $thread)
    {
        if (! array_key_exists('can_reply_' . $thread->getId(), $this->cache)) {
            $this->cache['can_reply_' . $thread->getId()] = $this->authorizer->canReplyToThread($thread);
        }

        return $this->cache['can_reply_' . $thread->getId()];
    }

    /**
     * Tells if the current user can send a message to this participant
     *
     * @param ParticipantInterface $participant
     * @return bool
     */
    public function canSendMessage(ParticipantInterface $participant)
    {
        if (! array_key_exists('can_send_' . $participant->getId(), $this->cache)) {
            $this->cache['can_send_' . $participant->getId()] = $this->authorizer->canSendMessageTo($participant);
        }

        return $this->cache['can_send_' . $participant->getId()];
    }


    /**
     * Gets the number of unread messages in the inbox of the current user
     *
     * @return int
     */
    public function countInboxNew()
    {
        if (! array_key_exists('count_inbox_new', $this->cache)) {
            $participant = $this->participantProvider->getAuthenticatedParticipant();

            $this->cache['count_inbox_new'] = $this->provider->countInboxNewThreads($participant);
        }

        return $this->cache['count_inbox_new'];
    }

    /**
     * Create a form to protect thread manipulation action from CSRF
     *
     * @param $name
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createActionForm($name)
    {
        return $this->formFactory->createNamed('fos_message_' . $name, $this->actionFormType)->createView();
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
