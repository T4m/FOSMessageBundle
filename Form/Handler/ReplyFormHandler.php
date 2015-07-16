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

use FOS\MessageBundle\Form\Model\ReplyModel;
use InvalidArgumentException;
use FOS\Message\Api\Model\MessageInterface;

/**
 * Handle reply form
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class ReplyFormHandler extends AbstractFormHandler
{
    /**
     * Create the composed message
     *
     * @param ReplyModel $formModel
     *
     * @return MessageInterface
     *
     * @throws InvalidArgumentException When the given model is not an instance of ReplyModel
     */
    protected function composeMessage($formModel)
    {
        if (! $formModel instanceof ReplyModel) {
            throw new InvalidArgumentException(
                sprintf('Message must be a ReplyModel instance, "%s" given', get_class($formModel))
            );
        }

        return $this->composer->createReplyBuilder($formModel->getThread())
            ->setAuthor($this->getAuthenticatedParticipant())
            ->setContent($formModel->getContent())
            ->getMessage();
    }
}
