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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactoryInterface;

use FOS\MessageBundle\Form\Model\NewThreadModel;
use FOS\MessageBundle\Form\Model\NewThreadMultipleModel;
use FOS\MessageBundle\Form\Model\ReplyModel;

/**
 * Instanciates message forms
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
abstract class AbstractFormFactory
{
    /**
     * The Symfony form factory
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * The message form type
     *
     * @var AbstractType
     */
    protected $formType;

    /**
     * The name of the form
     *
     * @var string
     */
    protected $formName;

    /**
     * The FQCN of the message model
     *
     * @var string
     */
    protected $messageClass;


    /**
     * Constructor
     *
     * @param FormFactoryInterface $formFactory
     * @param AbstractType $formType
     * @param string $formName
     * @param string $messageClass
     */
    public function __construct(FormFactoryInterface $formFactory, AbstractType $formType, $formName, $messageClass)
    {
        $this->formFactory = $formFactory;
        $this->formType = $formType;
        $this->formName = $formName;
        $this->messageClass = $messageClass;
    }

    /**
     * Creates a new instance of the form model
     *
     * @return NewThreadModel|NewThreadMultipleModel|ReplyModel
     */
    protected function createModelInstance()
    {
        $class = $this->messageClass;

        return new $class();
    }
}
