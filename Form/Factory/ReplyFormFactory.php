<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Form\Factory;

use FOS\Message\Api\Model\ThreadInterface;
use FOS\MessageBundle\Api\Form\Factory\ReplyFormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Instanciates message forms
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class ReplyFormFactory extends AbstractFormFactory implements ReplyFormFactoryInterface
{
    /**
     * Creates a reply message
     *
     * @param ThreadInterface $thread the thread we answer to
     * @return FormInterface
     */
    public function create(ThreadInterface $thread)
    {
        $model = $this->createModelInstance();
        $model->setThread($thread);

        return $this->formFactory->createNamed($this->formName, $this->formType, $model);
    }
}
