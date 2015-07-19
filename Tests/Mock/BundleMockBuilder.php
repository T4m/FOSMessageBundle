<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Tests\Mock;

use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;

class BundleMockBuilder
{
    /**
     * @param \PHPUnit_Framework_TestCase $context
     * @return \PHPUnit_Framework_MockObject_MockObject|AuthorizerInterface
     */
    public static function createAuthorizerMock(\PHPUnit_Framework_TestCase $context)
    {
        return $context->getMock('FOS\MessageBundle\Api\Security\AuthorizerInterface');
    }

    /**
     * @param \PHPUnit_Framework_TestCase $context
     * @return \PHPUnit_Framework_MockObject_MockObject|ParticipantProviderInterface
     */
    public static function createParticipantProviderMock(\PHPUnit_Framework_TestCase $context)
    {
        return $context->getMock('FOS\MessageBundle\Api\Security\ParticipantProviderInterface');
    }
}