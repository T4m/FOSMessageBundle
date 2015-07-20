Getting started with FOSMessageBundle
=====================================

The FOSMesageBundle is a bundle creating a bridge between the [FOSMessage library](https://github.com/tgalopin/FOSMessage)
and Symfony. It extends the library to provide a full-featured, easy to install and
easy to use use messaging system in any Symfony application.

Installation
------------

This bundle requires Symfony 2.1+ and is not tested with Symfony 2.0.X. It could work or
require some modifications but this version of Symfony won't be supported.

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).   

### Step 1: Download FOSMessageBundle using composer

Add FOSUserBundle by running the command:

``` bash
composer require tgalopin/fos-message-bundle "dev-master"
```

Composer will install the bundle to your project's `vendor/tgalopin` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\MessageBundle\FOSMessageBundle(),
    );
}
```

### Step 3: Setting up your models

FOSMessageBundle provides a flexible set of tools organized around a three main entites:
messages, threads and users. You need to implement a link between these entities and your
application for FOSMessageBundle to work properly.

#### Step 3a: User entity

FOSMessageBundle requires that your user class implement `ParticipantInterface`. This
bundle does not have any direct dependencies to any particular UserBundle or
implementation of a user, except that it must implement the above interface.

Your user class may look something like the following:

```php
<?php

use Doctrine\ORM\Mapping as ORM;
use FOS\Message\Api\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 */
class User extends BaseUser implements ParticipantInterface
{
    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    // Your code ...
}
```

#### Step 3b: Message and Thread entities

FOSMessageBundle has multiple models that must be implemented in your application.

As for the moment only Doctrine ORM is supported, we only provide example for it.
Stay tuned, other integrations will come soon!

- [Example entities for Doctrine ORM](models/orm.md)


### Step 4: Routing

Add FOSMessageBundle's routing to your application with an optional routing prefix:

```yaml
# app/config/routing.yml

# ...
fos_message:
    resource: "@FOSMessageBundle/Resources/config/routing.yml"
    prefix: /messages
# ...
```

### Step 5: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a few new entities (messages and threads).

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

You now can access your messaging system at `http://app.com/app_dev.php/messages`!

### Next Steps

Now that you have completed the basic installation and configuration of the
FOSMessageBundle, you are ready to learn about more advanced features and usages
of the bundle.

The following documents are available:

**TODO**