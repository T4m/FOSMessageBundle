- [Previous: Index](00-index.md)
- [Next: Integrate FOSMessageBundle to your application](02-integration-to-your-application.md)

Create the recipient field
==========================

You current messaging system is not fully working, as you may notice
by trying to access `http://app.com/app_dev.php/messages/new`.

Indeed you need either to use a predefined recipient field type or to implement
one in order to let FOSMessageBundle transform a form value into a User entity.

Using the FOSUserBundle
-----------------------

The integration with the FOSUserBundle is very simple, you just need to change
you configuration to enabled it:

``` yaml
# app/config/config.yml

fos_message:

    # Bridges with other libraries / bundles
    bridges:
        - fos_user
    
    # ...
```

Using a custom User implementation
----------------------------------

A custom user system requires a bit more work: you need to create a custom field type
and specify to use it in the configuration.

You can base your custom recipient field type on the FOSUserBundle one:

``` php
<?php

namespace FOS\MessageBundle\Bridge\FOSUser\Field;

use FOS\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Handles messages forms, from binding request to sending the message
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class FOSUserRecipientFieldType extends AbstractType
{
    /**
     * @var UserToUsernameTransformer
     */
    private $userToUsernameTransformer;

    /**
     * Constructor
     *
     * @param UserToUsernameTransformer $userToUsernameTransformer
     */
    public function __construct(UserToUsernameTransformer $userToUsernameTransformer)
    {
        $this->userToUsernameTransformer = $userToUsernameTransformer;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->userToUsernameTransformer);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected recipient does not exist',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fos_user_recipient';
    }
}
```

Once declared, register your field type in the container as a form field. For instance:

``` yaml
services:
    my_recipient_field_type:
        class: AppBundle\Form\Field\MyRecipientFieldType
        tags:
            - { name: form.type, alias: my_recipient_field_type }
```

And finally, tell FOSMessageBundle to use your field type:

``` yaml
# app/config/config.yml

fos_message:

    # Fields types
    fields:
        recipient: my_recipient_field_type
    
    # ...
```
