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
     * The event is an instance of FOS\MessageBundle\Api\Event\ThreadListEvent
     *
     * @var string
     */
    const PAGE_INBOX = 'fos_message.page_inbox';

    /**
     * The PAGE_SENT event occurs before the rendering of the sent box
     * The event is an instance of FOS\MessageBundle\Api\Event\ThreadListEvent
     *
     * @var string
     */
    const PAGE_SENT = 'fos_message.page_sent';

    /**
     * The PAGE_DELETED event occurs before the rendering of the deleted box
     * The event is an instance of FOS\MessageBundle\Api\Event\ThreadListEvent
     *
     * @var string
     */
    const PAGE_DELETED = 'fos_message.page_deleted';

    /**
     * The PAGE_THREAD event occurs before the rendering of a single thread
     * The event is an instance of FOS\Message\Api\Event\ThreadEvent
     *
     * @var string
     */
    const PAGE_THREAD = 'fos_message.page_thread';

    /**
     * The FORM_NEW event occurs before the rendering of the new thread form
     * The event is an instance of FOS\MessageBundle\Api\Event\MessageFormEvent
     *
     * @var string
     */
    const FORM_NEW = 'fos_message.form_new';

    /**
     * The FORM_NEW event occurs before the rendering of the reply form
     * The event is an instance of FOS\MessageBundle\Api\Event\MessageFormEvent
     *
     * @var string
     */
    const FORM_REPLY = 'fos_message.form_reply';
}
