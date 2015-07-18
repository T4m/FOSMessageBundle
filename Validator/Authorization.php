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
 * Validation constraint to check authorization
 * to send a message to this recipient
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class Authorization extends Constraint
{
    public $message = 'fos_message.not_authorized';

    public function validatedBy()
    {
        return 'fos_message.validator.authorization';
    }

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
