<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Api\Form\Handler;

use FOS\Message\Api\Model\MessageInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * A form handler is able to process forms to execute actions
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface FormHandlerInterface
{
    /**
     * Processes the form with the request
     *
     * @param FormInterface $form
     * @param Request $request
     *
     * @return MessageInterface|false The sent message if the form is bound and valid, false otherwise
     */
    public function process(FormInterface $form, Request $request);
}
