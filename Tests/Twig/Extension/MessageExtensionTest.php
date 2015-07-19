<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Tests\Twig\Extension;

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Provider\ProviderInterface;
use FOS\Message\Tests\Mock\ModelMockBuilder;
use FOS\Message\Tests\Mock\ParticipantMockBuilder;
use FOS\Message\Tests\Mock\ServiceMockBuilder;
use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use FOS\MessageBundle\Form\Type\ActionFormType;
use FOS\MessageBundle\Tests\Mock\BundleMockBuilder;
use FOS\MessageBundle\Twig\Extension\MessageExtension;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Twig extension tests
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class MessageExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageExtension
     */
    private $extension;

    /**
     * @var ParticipantProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $participantProvider;

    /**
     * @var ProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $provider;

    /**
     * @var AuthorizerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authorizer;

    /**
     * @var ParticipantInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $participant;


    public function setUp()
    {
        $this->provider = ServiceMockBuilder::createProviderMock($this);
        $this->participant = ParticipantMockBuilder::createParticipant($this,  1);

        $this->participantProvider = BundleMockBuilder::createParticipantProviderMock($this);
        $this->authorizer = BundleMockBuilder::createAuthorizerMock($this);

        $this->extension = new MessageExtension(
            $this->participantProvider,
            $this->provider,
            $this->authorizer,
            $this->getMock('Symfony\Component\Form\FormFactoryInterface'),
            new ActionFormType()
        );
    }

    public function testIsReadReturnsTrueWhenRead()
    {
        $this->participantProvider
            ->expects($this->once())
            ->method('getAuthenticatedParticipant')
            ->will($this->returnValue($this->participant));

        $readable = ModelMockBuilder::createReadableMock($this);

        $readable->expects($this->once())
            ->method('isReadByParticipant')
            ->with($this->participant)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->isRead($readable));
    }

    public function testIsReadReturnsFalseWhenNotRead()
    {
        $this->participantProvider
            ->expects($this->once())
            ->method('getAuthenticatedParticipant')
            ->will($this->returnValue($this->participant));

        $readable = ModelMockBuilder::createReadableMock($this);

        $readable->expects($this->once())
            ->method('isReadByParticipant')
            ->with($this->participant)
            ->will($this->returnValue(false));

        $this->assertFalse($this->extension->isRead($readable));
    }

    public function testIsDeletedReturnsTrueWhenDeleted()
    {
        $this->participantProvider
            ->expects($this->once())
            ->method('getAuthenticatedParticipant')
            ->will($this->returnValue($this->participant));

        $deletable = ModelMockBuilder::createDeletableMock($this);

        $deletable->expects($this->once())
            ->method('isDeletedByParticipant')
            ->with($this->participant)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->isDeleted($deletable));
    }

    public function testIsDeletedReturnsFalseWhenNotDeleted()
    {
        $this->participantProvider
            ->expects($this->once())
            ->method('getAuthenticatedParticipant')
            ->will($this->returnValue($this->participant));

        $deletable = ModelMockBuilder::createDeletableMock($this);

        $deletable->expects($this->once())
            ->method('isDeletedByParticipant')
            ->with($this->participant)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->isDeleted($deletable));
    }

    public function testCanSeeThreadWhenHasPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canSeeThread')
            ->with($thread)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->canSee($thread));
    }

    public function testCanNotSeeThreadWhenHasNotPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canSeeThread')
            ->with($thread)
            ->will($this->returnValue(false));

        $this->assertFalse($this->extension->canSee($thread));
    }

    public function testCanDeleteThreadWhenHasPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canDeleteThread')
            ->with($thread)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->canDelete($thread));
    }

    public function testCanNotDeleteThreadWhenHasNotPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canDeleteThread')
            ->with($thread)
            ->will($this->returnValue(false));

        $this->assertFalse($this->extension->canDelete($thread));
    }

    public function testCanReplyThreadWhenHasPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canReplyToThread')
            ->with($thread)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->canReply($thread));
    }

    public function testCanNotReplyThreadWhenHasNotPermission()
    {
        $thread = ModelMockBuilder::createThreadMock($this);

        $this->authorizer
            ->expects($this->once())
            ->method('canReplyToThread')
            ->with($thread)
            ->will($this->returnValue(false));

        $this->assertFalse($this->extension->canReply($thread));
    }

    public function testCanSendMessageWhenHasPermission()
    {
        $recipient = ParticipantMockBuilder::createParticipant($this, 2);

        $this->authorizer
            ->expects($this->once())
            ->method('canSendMessageTo')
            ->with($recipient)
            ->will($this->returnValue(true));

        $this->assertTrue($this->extension->canSendMessage($recipient));
    }

    public function testCanNotSendMessageWhenHasNotPermission()
    {
        $recipient = ParticipantMockBuilder::createParticipant($this, 2);

        $this->authorizer
            ->expects($this->once())
            ->method('canSendMessageTo')
            ->with($recipient)
            ->will($this->returnValue(false));

        $this->assertFalse($this->extension->canSendMessage($recipient));
    }

    public function testCountInbox()
    {
        $this->participantProvider
            ->expects($this->once())
            ->method('getAuthenticatedParticipant')
            ->will($this->returnValue($this->participant));

        $this->provider
            ->expects($this->once())
            ->method('countInboxNewThreads')
            ->with($this->participant)
            ->will($this->returnValue(3));

        $this->assertEquals(3, $this->extension->countInboxNew());
    }
}
