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
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validation assocaited to Authorization constraint
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class AuthorizationValidator extends ConstraintValidator
{
    /**
     * @var AuthorizerInterface
     */
    protected $authorizer;

    /**
     * Constructor
     *
     * @param AuthorizerInterface $authorizer
     */
    public function __construct(AuthorizerInterface $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Indicates whether the constraint is valid
     *
     * @param object     $recipient
     * @param Constraint $constraint
     */
    public function validate($recipient, Constraint $constraint)
    {
        if ($recipient && ! $this->authorizer->canSendMessageTo($recipient)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
