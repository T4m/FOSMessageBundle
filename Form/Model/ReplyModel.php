<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Form\Model;

use FOS\Message\Api\Model\ThreadInterface;

/**
 * Model representing the form data of a reply to a thread
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ReplyModel extends ContentModel
{
    /**
     * The thread to reply to
     *
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @return ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param ThreadInterface $thread
     */
    public function setThread(ThreadInterface $thread)
    {
        $this->thread = $thread;
    }
}
