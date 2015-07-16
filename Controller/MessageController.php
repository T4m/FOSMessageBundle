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

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Provider\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $threads = $this->getProvider()->getInboxThreads($this->getParticipant());

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
        $threads = $this->getProvider()->getSentThreads($this->getParticipant());

        return $this->render('FOSMessageBundle:Message:sent.html.twig', [
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
        $threads = $this->getProvider()->getDeletedThreads($this->getParticipant());

        return $this->render('FOSMessageBundle:Message:deleted.html.twig', [
            'threads' => $threads
        ]);
    }

    /**
     * Displays a thread, also allows to reply to it
     *
     * @param Request $request
     * @param $threadId
     * @return RedirectResponse|Response|NotFoundHttpException
     */
    public function threadAction(Request $request, $threadId)
    {
        $thread = $this->getProvider()->getThread($threadId);

        if (! $thread) {
            return $this->createNotFoundException('Thread not found');
        }

        $this->get('fos_message.reader')->markAsRead($thread, $this->getParticipant());

        $form = $this->get('fos_message.forms.reply.factory')->create($thread);
        $handler = $this->get('fos_message.forms.reply.handler');

        if ($message = $handler->process($form, $request)) {
            return $this->redirect($this->generateUrl('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId()
            ]));
        }

        return $this->render('FOSMessageBundle:Message:thread.html.twig', [
            'form' => $form->createView(),
            'thread' => $thread
        ]);
    }

    /**
     * Create a new thread
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newThreadAction(Request $request)
    {
        $form = $this->get('fos_message.forms.new_thread.factory')->create();
        $handler = $this->get('fos_message.forms.new_thread.handler');

        if ($message = $handler->process($form, $request)) {
            return $this->redirect($this->generateUrl('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId()
            ]));
        }

        return $this->render('FOSMessageBundle:Message:newThread.html.twig', [
            'form' => $form->createView(),
            'data' => $form->getData()
        ]);
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
     * Gets the current authenticated participant
     *
     * @return ParticipantInterface
     */
    private function getParticipant()
    {
        return $this->get('fos_message.participant_provider')->getAuthenticatedParticipant();
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
