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

/**
 * Event concerning a page listing threads
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class PageListEvent extends Event
{
    /**
     * @var DriverStatementInterface
     */
    private $statement;

    /**
     * Constructor
     *
     * @param DriverStatementInterface $statement
     */
    public function __construct(DriverStatementInterface $statement)
    {
        $this->statement = $statement;
    }

    /**
     * @return DriverStatementInterface
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param DriverStatementInterface $statement
     */
    public function setStatement(DriverStatementInterface $statement)
    {
        $this->statement = $statement;
    }
}
