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

use FOS\Message\Api\Model\ThreadInterface;
use Symfony\Component\Form\FormInterface;

/**
 * A reply form factory is an object able to create reply forms
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface ReplyFormFactoryInterface
{
    /**
     * Create a reply form
     *
     * @param ThreadInterface $thread
     *
     * @return FormInterface
     */
    public function create(ThreadInterface $thread);
}
