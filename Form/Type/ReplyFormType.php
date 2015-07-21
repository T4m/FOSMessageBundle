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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Message form type for replying to a conversation
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class ReplyFormType extends AbstractFormType
{
    /**
     * Build the form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', $this->contentFieldAlias, [
            'label' => 'form.content',
            'translation_domain' => 'FOSMessageBundle',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'intention' => 'reply',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fos_message_reply';
    }
}
