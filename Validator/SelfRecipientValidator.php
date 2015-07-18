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

use FOS\MessageBundle\Api\Security\ParticipantProviderInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation assocaited to SelfRecipient constraint
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class SelfRecipientValidator extends ConstraintValidator
{
    /**
     * @var ParticipantProviderInterface
     */
    protected $participantProvider;

    /**
     * Constructor
     *
     * @param ParticipantProviderInterface $participantProvider
     */
    public function __construct(ParticipantProviderInterface $participantProvider)
    {
        $this->participantProvider = $participantProvider;
    }

    /**
     * Indicates whether the constraint is valid
     *
     * @param object     $recipient
     * @param Constraint $constraint
     */
    public function validate($recipient, Constraint $constraint)
    {
        if ($recipient === $this->participantProvider->getAuthenticatedParticipant()) {
            $this->context->addViolation($constraint->message);
        }
    }
}
