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
     * Can be filtered by a search query
     *
     * @param Request $request
     * @return Response
     */
    public function inboxAction(Request $request)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $searchQuery = $request->query->get('q');

        if (null !== $searchQuery) {
            $threads = $this->get('fos_message.searcher')->searchInboxThreads($participant, $searchQuery);
        } else {
            $threads = $this->get('fos_message.provider')->getInboxThreads($participant);
        }

        return $this->renderThemed('inbox.html.twig', [
            'searchQuery' => $searchQuery,
            'threads' => $threads,
        ]);
    }

    /**
     * Displays the authenticated participant messages sent
     * Can be filtered by a search query
     *
     * @param Request $request
     * @return Response
     */
    public function sentAction(Request $request)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $searchQuery = $request->query->get('q');

        if (null !== $searchQuery) {
            $threads = $this->get('fos_message.searcher')->searchSentThreads($participant, $searchQuery);
        } else {
            $threads = $this->get('fos_message.provider')->getSentThreads($participant);
        }

        return $this->renderThemed('sent.html.twig', [
            'searchQuery' => $searchQuery,
            'threads' => $threads,
        ]);
    }

    /**
     * Displays the authenticated participant deleted threads
     * Can be filtered by a search query
     *
     * @param Request $request
     * @return Response
     */
    public function deletedAction(Request $request)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $searchQuery = $request->query->get('q');

        if (null !== $searchQuery) {
            $threads = $this->get('fos_message.searcher')->searchDeletedThreads($participant, $searchQuery);
        } else {
            $threads = $this->get('fos_message.provider')->getDeletedThreads($participant);
        }

        return $this->renderThemed('deleted.html.twig', [
            'searchQuery' => $searchQuery,
            'threads' => $threads,
        ]);
    }

    /**
     * Start a thread
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $this->checkAccessAndGetParticipant();

        $form = $this->get('fos_message.forms.new_thread.factory')->create();
        $handler = $this->get('fos_message.forms.new_thread.handler');

        if ($message = $handler->process($form, $request)) {
            return $this->redirect($this->generateUrl('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId()
            ]));
        }

        return $this->renderThemed('start_thread.html.twig', [
            'form' => $form->createView(),
            'data' => $form->getData()
        ]);
    }

    /**
     * Displays a thread, also allows to reply to it
     *
     * @param Request $request
     * @param int $threadId
     * @return RedirectResponse|Response|NotFoundHttpException
     */
    public function threadAction(Request $request, $threadId)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $thread = $this->get('fos_message.provider')->getThread($threadId);

        if (! $thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        if (! $this->get('fos_message.authorizer')->canSeeThread($thread)) {
            throw $this->createAccessDeniedException('You are not allowed to see this');
        }

        $this->get('fos_message.reader')->markAsRead($thread, $participant);

        $form = $this->get('fos_message.forms.reply.factory')->create($thread);
        $handler = $this->get('fos_message.forms.reply.handler');

        if ($message = $handler->process($form, $request)) {
            return $this->redirect($this->generateUrl('fos_message_thread_view', [
                'threadId' => $message->getThread()->getId()
            ]));
        }

        return $this->renderThemed('thread.html.twig', [
            'form' => $form->createView(),
            'thread' => $thread
        ]);
    }

    /**
     * Mark a thread as deleted
     *
     * @param Request $request
     * @param int $threadId
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $threadId)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $this->handleActionForm('delete_' . $threadId, $request);

        $thread = $this->get('fos_message.provider')->getThread($threadId);

        if (! $thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        if (! $this->get('fos_message.authorizer')->canDeleteThread($thread)) {
            throw $this->createAccessDeniedException('You are not allowed to do this');
        }

        $this->get('fos_message.deleter')->markAsDeleted($thread, $participant);

        return $this->redirect($this->generateUrl('fos_message_inbox'));
    }

    /**
     * Mark a thread as undeleted
     *
     * @param Request $request
     * @param int $threadId
     * @return RedirectResponse
     */
    public function undeleteAction(Request $request, $threadId)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $this->handleActionForm('undelete_' . $threadId, $request);

        $thread = $this->get('fos_message.provider')->getThread($threadId);

        if (! $thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        if (! $this->get('fos_message.authorizer')->canDeleteThread($thread)) {
            throw $this->createAccessDeniedException('You are not allowed to do this');
        }

        $this->get('fos_message.deleter')->markAsUndeleted($thread, $participant);

        return $this->redirect($this->generateUrl('fos_message_deleted'));
    }


    /**
     * Mark a thread as read
     *
     * @param Request $request
     * @param int $threadId
     * @return RedirectResponse
     */
    public function readAction(Request $request, $threadId)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $this->handleActionForm('read_' . $threadId, $request);

        $thread = $this->get('fos_message.provider')->getThread($threadId);

        if (! $thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        if (! $this->get('fos_message.authorizer')->canSeeThread($thread)) {
            throw $this->createAccessDeniedException('You are not allowed to do this');
        }

        $this->get('fos_message.reader')->markAsRead($thread, $participant);

        return $this->redirect($this->generateUrl('fos_message_inbox'));
    }

    /**
     * Mark a thread as read
     *
     * @param Request $request
     * @param int $threadId
     * @return RedirectResponse
     */
    public function unreadAction(Request $request, $threadId)
    {
        $participant = $this->checkAccessAndGetParticipant();

        $this->handleActionForm('unread_' . $threadId, $request);

        $thread = $this->get('fos_message.provider')->getThread($threadId);

        if (! $thread) {
            throw $this->createNotFoundException('Thread not found');
        }

        if (! $this->get('fos_message.authorizer')->canSeeThread($thread)) {
            throw $this->createAccessDeniedException('You are not allowed to do this');
        }

        $this->get('fos_message.reader')->markAsUnread($thread, $participant);

        return $this->redirect($this->generateUrl('fos_message_inbox'));
    }




    /**
     * Renders a view using the configured theme.
     *
     * @param string   $view       The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response   A response instance
     *
     * @return Response A Response instance
     */
    private function renderThemed($view, array $parameters = array(), Response $response = null)
    {
        return $this->render(
            sprintf('FOSMessageBundle:%s:%s', $this->getParameter('fos_message.theme'), $view),
            $parameters,
            $response
        );
    }

    /**
     * Handle an action form and throw an access denied
     * exception if the form is invalid
     *
     * @param string $name
     * @param Request $request
     */
    private function handleActionForm($name, Request $request)
    {
        $formFactory = $this->get('form.factory');
        $actionFormType = $this->get('fos_message.forms.action.type');

        $form = $formFactory->createNamed('fos_message_' . $name, $actionFormType);
        $form->submit($request);

        if (! $form->isValid()) {
            throw $this->createAccessDeniedException('Token invalid');
        }
    }

    /**
     * Gets the current authenticated participant
     *
     * @return ParticipantInterface
     */
    private function checkAccessAndGetParticipant()
    {
        $participant = $this->get('fos_message.participant_provider')->getAuthenticatedParticipant();

        if (! $participant instanceof ParticipantInterface) {
            throw $this->createAccessDeniedException(
                'You have to be authenticated as a ParticipantInterface to access this page'
            );
        }

        return $participant;
    }
}
