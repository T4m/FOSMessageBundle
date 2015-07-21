<?php

/*
 * This file is part of the fos/message package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Api\Event;

use FOS\Message\Api\Driver\DriverStatementInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event concerning a message form (new thread or reply)
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class MessageFormEvent extends Event
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * MessageFormEvent constructor.
     * @param FormInterface $form
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }
}
