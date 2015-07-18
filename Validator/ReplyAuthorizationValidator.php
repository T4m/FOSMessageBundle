<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Validator;

use FOS\MessageBundle\Api\Security\AuthorizerInterface;
use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation assocaited to ReplyAuthorization constraint
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ReplyAuthorizationValidator extends ConstraintValidator
{
    /**
     * @var AuthorizerInterface
     */
    protected $authorizer;

    /**
     * Constructor
     *
     * @param AuthorizerInterface $authorizer
     * @param ParticipantProviderInterface $participantProvider
     */
    public function __construct(AuthorizerInterface $authorizer, ParticipantProviderInterface $participantProvider)
    {
        $this->authorizer = $authorizer;
        $this->participantProvider = $participantProvider;
    }

    /**
     * Indicates whether the constraint is valid
     *
     * @param object     $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $sender = $this->participantProvider->getAuthenticatedParticipant();
        $recipients = $value->getThread()->getOtherParticipants($sender);
        foreach ($recipients as $recipient) {
            if (!$this->authorizer->canSendMessageTo($recipient)) {
                $this->context->addViolation($constraint->message);
                
                return;
            }
        }
    }
}
