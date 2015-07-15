<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Api\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * A new thread form factory is an object able to create new thread forms
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface NewThreadFormFactoryInterface
{
    /**
     * Creates a new thread form
     *
     * @return FormInterface
     */
    public function create();
}
