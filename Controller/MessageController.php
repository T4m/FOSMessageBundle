<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Controller;

use FOS\Message\Api\Provider\ProviderInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * FOSMessageBundle controller
 * You should not overwrite this controller: use events or define your
 * custom services instead
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class MessageController extends Controller
{
    /**
     * Displays the authenticated participant inbox
     *
     * @return Response
     */
    public function inboxAction()
    {
        $authenticatedParticipant = $this->getParticipantProvider()->getAuthenticatedParticipant();
        $threads = $this->getProvider()->getInboxThreads($authenticatedParticipant);

        return $this->render('FOSMessageBundle:Message:inbox.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * Displays the authenticated participant messages sent
     *
     * @return Response
     */
    public function sentAction()
    {
        $authenticatedParticipant = $this->getParticipantProvider()->getAuthenticatedParticipant();
        $threads = $this->getProvider()->getSentThreads($authenticatedParticipant);

        return $this->render('FOSMessageBundle:Message:inbox.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * Displays the authenticated participant deleted threads
     *
     * @return Response
     */
    public function deletedAction()
    {
        $authenticatedParticipant = $this->getParticipantProvider()->getAuthenticatedParticipant();
        $threads = $this->getProvider()->getDeletedThreads($authenticatedParticipant);

        return $this->render('FOSMessageBundle:Message:inbox.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * Displays a thread, also allows to reply to it
     *
     * @param string $threadId the thread id
     * 
     * @return Response
     */
    public function threadAction($threadId)
    {
        $thread = $this->getProvider()->getThread($threadId);
        $form = $this->container->get('fos_message.reply_form.factory')->create($thread);
        $formHandler = $this->container->get('fos_message.reply_form.handler');

        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId()
            )));
        }

        return $this->container->get('templating')->renderResponse('FOSMessageBundle:Message:thread.html.twig', array(
            'form' => $form->createView(),
            'thread' => $thread
        ));
    }

    /**
     * Create a new message thread
     *
     * @return Response
     */
    public function newThreadAction()
    {
        $form = $this->container->get('fos_message.new_thread_form.factory')->create();
        $formHandler = $this->container->get('fos_message.new_thread_form.handler');

        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId()
            )));
        }

        return $this->container->get('templating')->renderResponse('FOSMessageBundle:Message:newThread.html.twig', array(
            'form' => $form->createView(),
            'data' => $form->getData()
        ));
    }

    /**
     * Deletes a thread
     * 
     * @param string $threadId the thread id
     * 
     * @return RedirectResponse
     */
    public function deleteAction($threadId)
    {
        $thread = $this->getProvider()->getThread($threadId);
        $this->container->get('fos_message.deleter')->markAsDeleted($thread);
        $this->container->get('fos_message.thread_manager')->saveThread($thread);

        return new RedirectResponse($this->container->get('router')->generate('fos_message_inbox'));
    }
    
    /**
     * Undeletes a thread
     * 
     * @param string $threadId
     * 
     * @return RedirectResponse
     */
    public function undeleteAction($threadId)
    {
        $thread = $this->getProvider()->getThread($threadId);
        $this->container->get('fos_message.deleter')->markAsUndeleted($thread);
        $this->container->get('fos_message.thread_manager')->saveThread($thread);

        return new RedirectResponse($this->container->get('router')->generate('fos_message_inbox'));
    }

    /**
     * Searches for messages in the inbox and sentbox
     *
     * @return Response
     */
    public function searchAction()
    {
        $query = $this->container->get('fos_message.search_query_factory')->createFromRequest();
        $threads = $this->container->get('fos_message.search_finder')->find($query);

        return $this->container->get('templating')->renderResponse('FOSMessageBundle:Message:search.html.twig', array(
            'query' => $query,
            'threads' => $threads
        ));
    }


    /**
     * Gets the participant provider service
     *
     * @return ParticipantProviderInterface
     */
    private function getParticipantProvider()
    {
        return $this->get('fos_message.participant_provider');
    }

    /**
     * Gets the provider service
     *
     * @return ProviderInterface
     */
    private function getProvider()
    {
        return $this->get('fos_message.provider');
    }
}
