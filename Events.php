<?php

/*
 * This file is part of the fos/message package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle;

/**
 * Declares all events thrown in the bundle
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class Events
{
    /**
     * The PAGE_INBOX event occurs before the rendering of the inbox
     * The event is an instance of FOS\MessageBundle\Api\Event\PageListEvent
     *
     * @var string
     */
    const PAGE_INBOX = 'fos_message.page_inbox';

    /**
     * The PAGE_SENT event occurs before the rendering of the sent box
     * The event is an instance of FOS\MessageBundle\Api\Event\PageListEvent
     *
     * @var string
     */
    const PAGE_SENT = 'fos_message.page_sent';

    /**
     * The PAGE_DELETED event occurs before the rendering of the deleted box
     * The event is an instance of FOS\MessageBundle\Api\Event\PageListEvent
     *
     * @var string
     */
    const PAGE_DELETED = 'fos_message.page_deleted';
}
