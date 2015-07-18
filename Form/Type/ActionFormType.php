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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Action form type: contains no specific field, just used as a
 * CSRF protection for FOSMessage threads manipulations.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class ActionFormType extends AbstractType
{
    /**
     * Build the form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Contains no field: just for CSRF protection
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'intention' => 'action',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fos_message_action';
    }
}
