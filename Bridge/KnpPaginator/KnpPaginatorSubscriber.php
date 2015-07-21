<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Bridge\KnpPaginator;

use FOS\MessageBundle\Api\Event\ThreadListEvent;
use FOS\MessageBundle\Events;
use Knp\Component\Pager\Paginator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Bridge definition for KnpPaginatorBundle.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class KnpPaginatorSubscriber implements EventSubscriberInterface
{
    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var string
     */
    private $pageParameterName;

    /**
     * Constructor.
     *
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;

        $property = new \ReflectionProperty($paginator, 'defaultOptions');
        $property->setAccessible(true);

        $defaultOptions = $property->getValue($paginator);

        $this->pageParameterName = $defaultOptions['pageParameterName'];
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PAGE_INBOX => 'onPageList',
            Events::PAGE_SENT => 'onPageList',
            Events::PAGE_DELETED => 'onPageList',
        ];
    }

    /**
     * Paginate the lists.
     *
     * @param ThreadListEvent $event
     */
    public function onPageList(ThreadListEvent $event)
    {
        $statement = $event->getStatement();

        if (! $statement->supportPagination()) {
            return;
        }

        $page = $event->getRequest()->get($this->pageParameterName);

        if (! $page || ! is_numeric($page)) {
            $page = 1;
        }

        $pagination = $this->paginator->paginate($statement->getPaginationResource(), $page, 20);

        $event->setList($pagination);
    }
}