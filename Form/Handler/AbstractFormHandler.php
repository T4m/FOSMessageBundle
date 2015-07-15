<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Form\Handler;

use FOS\Message\Api\Composer\ComposerInterface;
use FOS\Message\Api\Model\MessageInterface;
use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Sender\SenderInterface;
use FOS\MessageBundle\Api\Form\Handler\FormHandlerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles messages forms, from binding request to sending the message
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractFormHandler implements FormHandlerInterface
{
    /**
     * @var ComposerInterface
     */
    protected $composer;

    /**
     * @var SenderInterface
     */
    protected $sender;

    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    /**
     * Constructor
     *
     * @param ComposerInterface $composer
     * @param SenderInterface $sender
     * @param ParticipantProviderInterface $participantProvider
     */
    public function __construct(
        ComposerInterface $composer,
        SenderInterface $sender,
        ParticipantProviderInterface $participantProvider
    ) {
        $this->composer = $composer;
        $this->sender = $sender;
        $this->participantProvider = $participantProvider;
    }

    /**
     * Composes a message from the form data
     *
     * @param mixed $formModel The form model used to compose the message
     * @return MessageInterface The composed message ready to be sent
     */
    abstract protected function composeMessage($formModel);

    /**
     * Processes the form with the request
     *
     * @param FormInterface $form
     * @param Request $request
     *
     * @return MessageInterface|false The sent message if the form is bound and valid, false otherwise
     */
    public function process(FormInterface $form, Request $request)
    {
        if ('POST' !== $request->getMethod()) {
            return false;
        }

        $form->submit($request);

        if ($form->isValid()) {
            return $this->processValidForm($form);
        }

        return false;
    }

    /**
     * Processes the valid form, sends the message
     *
     * @param FormInterface $form
     * @return MessageInterface the sent message
     */
    public function processValidForm(FormInterface $form)
    {
        $message = $this->composeMessage($form->getData());

        $this->sender->send($message);

        return $message;
    }

    /**
     * Gets the current authenticated user
     *
     * @return ParticipantInterface
     */
    protected function getAuthenticatedParticipant()
    {
        return $this->participantProvider->getAuthenticatedParticipant();
    }
}
