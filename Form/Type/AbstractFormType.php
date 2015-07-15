<?php

/*
 * This file is part of the fos/message-bundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\MessageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Base class for FOSMessageBundle form types
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
abstract class AbstractFormType extends AbstractType
{
    /**
     * @var string
     */
    protected $recipientFieldAlias;

    /**
     * @var string
     */
    protected $subjectFieldAlias;

    /**
     * @var string
     */
    protected $contentFieldAlias;

    /**
     * Constructor
     *
     * @param string $recipientFieldAlias
     * @param string $subjectFieldAlias
     * @param string $contentFieldAlias
     */
    public function __construct($recipientFieldAlias, $subjectFieldAlias, $contentFieldAlias)
    {
        $this->recipientFieldAlias = $recipientFieldAlias;
        $this->subjectFieldAlias = $subjectFieldAlias;
        $this->contentFieldAlias = $contentFieldAlias;
    }
}
