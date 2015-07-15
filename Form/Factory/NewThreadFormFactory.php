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

use FOS\MessageBundle\Api\Form\Factory\NewThreadFormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Instanciates message forms
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadFormFactory extends AbstractFormFactory implements NewThreadFormFactoryInterface
{
    /**
     * Creates a new thread form
     *
     * @return FormInterface
     */
    public function create()
    {
        $model = $this->createModelInstance();

        return $this->formFactory->createNamed($this->formName, $this->formType, $model);
    }
}
