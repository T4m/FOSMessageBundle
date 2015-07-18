<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Bridge\KnpPaginator\Paginator;

use FOS\Message\Api\Driver\DriverStatementInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Paginator for DriverStatement objects using KnpPaginator
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class StatementPaginator
{
    /**
     * @var Paginator
     */
    private $knpPaginator;

    /**
     * @var string
     */
    private $pageParameterName;

    /**
     * Constructor
     *
     * @param Paginator $knpPaginator
     */
    public function __construct(Paginator $knpPaginator)
    {
        $this->knpPaginator = $knpPaginator;

        $property = new \ReflectionProperty($knpPaginator, 'defaultOptions');
        $property->setAccessible(true);

        $defaultOptions = $property->getValue($knpPaginator);

        $this->pageParameterName = $defaultOptions['pageParameterName'];
    }

    /**
     * @param DriverStatementInterface $statement
     * @param Request $request
     * @return SlidingPagination
     */
    public function paginate(DriverStatementInterface $statement, Request $request)
    {
        return $this->knpPaginator->paginate(
            $statement->getPaginationResource(),
            $request->query->get($this->pageParameterName, 1),
            20
        );
    }
}