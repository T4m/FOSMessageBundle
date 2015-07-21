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
use Symfony\Component\HttpFoundation\Request;

/**
 * Event concerning a page listing threads
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ThreadListEvent extends Event
{
    /**
     * @var DriverStatementInterface
     */
    private $statement;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $searchQuery;

    /**
     * @var mixed
     */
    private $list;

    /**
     * Constructor.
     *
     * @param DriverStatementInterface $statement
     * @param Request $request
     * @param string $searchQuery
     */
    public function __construct(DriverStatementInterface $statement, Request $request, $searchQuery)
    {
        $this->statement = $statement;
        $this->request = $request;
        $this->searchQuery = $searchQuery;
    }

    /**
     * @return DriverStatementInterface
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getSearchQuery()
    {
        return $this->searchQuery;
    }

    /**
     * @return boolean
     */
    public function hasList()
    {
        return null !== $this->list;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }
}
