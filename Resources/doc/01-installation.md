Setting up FOSMessageBundle
===========================

### Step 1 - Requirements and Installing the bundle

The first step is to tell composer that you want to download FOSMessageBundle which can
be achieved by typing the following at the command prompt:

``` bash
composer require tgalopin/message-bundle
```

### Step 2 - Setting up your user class

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

### Step 3 - Set up FOSMessageBundle's models

FOSMessageBundle has multiple models that must be implemented by you in an application
bundle (that may or may not be a child of FOSMessageBundle).

As for the moment only Doctrine ORM is supported, we only provide example for it.
Stay tuned, other integrations will come soon!

- [Example entities for Doctrine ORM](models/orm.md)

### Step 4 - Enable the bundle in your kernel

The bundle must be added to your `AppKernel`

```php
# app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new FOS\MessageBundle\FOSMessageBundle(),
        // ...
    );
}
```

### Step 5 - Import the bundle routing

Add FOSMessageBundle's routing to your application with an optional routing prefix.

```yaml
# app/config/routing.yml

# ...
fos_message:
    resource: "@FOSMessageBundle/Resources/config/routing.yml"
    prefix: /messages
# ...
```

## Installation Finished

At this point, the bundle has been installed and configured and should be ready for use.
You can continue reading documentation by returning to the [index](00-index.md).