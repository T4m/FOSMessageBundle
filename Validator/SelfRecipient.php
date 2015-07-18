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

use Symfony\Component\Validator\Constraint;

/**
 * Validation constraint to avoid self messages
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class SelfRecipient extends Constraint
{
    public $message = 'fos_message.self_recipient';

    public function validatedBy()
    {
        return 'fos_message.validator.self_recipient';
    }

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
