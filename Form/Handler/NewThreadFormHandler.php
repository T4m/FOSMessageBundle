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

use InvalidArgumentException;
use FOS\Message\Api\Model\MessageInterface;
use FOS\MessageBundle\Form\Model\NewThreadModel;

/**
 * Handle new thread form
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadFormHandler extends AbstractFormHandler
{
    /**
     * Create the composed message
     *
     * @param NewThreadModel $formModel
     *
     * @return MessageInterface
     *
     * @throws InvalidArgumentException When the given model is not an instance of NewThreadModel
     */
    protected function composeMessage($formModel)
    {
        if (! $formModel instanceof NewThreadModel) {
            throw new InvalidArgumentException(
                sprintf('Message must be a NewThreadModel instance, "%s" given', get_class($formModel))
            );
        }

        return $this->composer->createNewThreadBuilder()
            ->setSubject($formModel->getSubject())
            ->addRecipient($formModel->getRecipient())
            ->setAuthor($this->getAuthenticatedParticipant())
            ->setContent($formModel->getContent())
            ->getMessage();
    }
}
