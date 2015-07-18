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
 * Message form type for starting a new conversation with multiple recipients
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Łukasz Pospiech <zocimek@gmail.com>
 */
class NewThreadMultipleFormType extends AbstractFormType
{
    /**
     * Build the form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recipients', 'collection', [
            'type' => $this->recipientFieldAlias,
            'allow_add' => 'true',
            'allow_delete' => 'true',
            'label' => 'list.header.recipients',
            'translation_domain' => 'FOSMessageBundle',
        ]);

        $builder->add('subject', $this->subjectFieldAlias, [
            'label' => 'list.header.subject',
            'translation_domain' => 'FOSMessageBundle',
        ]);

        $builder->add('content', $this->contentFieldAlias, [
            'label' => 'list.header.content',
            'translation_domain' => 'FOSMessageBundle',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'intention' => 'new_thread_multiple',
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fos_message_new_thread_multiple';
    }
}
