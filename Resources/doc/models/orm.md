Concrete classes for Doctrine ORM
=================================

This page lists some example implementations of FOSMessageBundle models for the Doctrine
ORM.

Given the examples below with their namespaces and class names, you need to configure
FOSMessageBundle to tell them about these classes.

Add the following to your `app/config/config.yml` file.

```yaml
# app/config/config.yml

fos_message:

    # FOSMessage driver (for the moment only "orm" is available)
    driver: orm

    # Custom entities as models
    models:
        message_class: AppBundle\Entity\Message
        message_metadata_class: AppBundle\Entity\MessageMetadata
        thread_class: AppBundle\Entity\Thread
        thread_metadata_class: AppBundle\Entity\ThreadMetadata
```

[Continue with the installation][]

Message class
-------------

```php
<?php
// src/Acme/MessageBundle/Entity/Message.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Model\ThreadInterface;
use FOS\Message\Driver\DoctrineORM\Entity\Message as BaseMessage;

/**
 * @ORM\Table(name="messages")
 * @ORM\Entity
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="messages", cascade={"all"})
     *
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"all"})
     * @var ParticipantInterface
     */
    protected $author;

    /**
     * @ORM\OneToMany(targetEntity="MessageMetadata", mappedBy="message", cascade={"all"})
     * @var MessageMetadata[]|\Doctrine\Common\Collections\Collection
     */
    protected $metadata;
}
```

MessageMetadata class
---------------------

```php
<?php
// src/Acme/MessageBundle/Entity/MessageMetadata.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\Message\Api\Model\MessageInterface;
use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Driver\DoctrineORM\Entity\MessageMetadata as BaseMessageMetadata;

/**
 * @ORM\Table(name="messages_metadata")
 * @ORM\Entity
 */
class MessageMetadata extends BaseMessageMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Message", inversedBy="metadata", cascade={"all"})
     * @var MessageInterface
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"all"})
     * @var ParticipantInterface
     */
    protected $participant;
}
```

Thread class
------------

```php
<?php
// src/Acme/MessageBundle/Entity/Thread.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Driver\DoctrineORM\Entity\Thread as BaseThread;

/**
 * @ORM\Table(name="threads")
 * @ORM\Entity
 */
class Thread extends BaseThread
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"all"})
     * @var ParticipantInterface
     */
    protected $owner;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="thread", cascade={"all"})
     * @var Message[]|\Doctrine\Common\Collections\Collection
     */
    protected $messages;

    /**
     * @ORM\OneToMany(targetEntity="ThreadMetadata", mappedBy="thread", cascade={"all"})
     * @var ThreadMetadata[]|\Doctrine\Common\Collections\Collection
     */
    protected $metadata;
}
```

ThreadMetadata class
--------------------

```php
<?php
// src/Acme/MessageBundle/Entity/ThreadMetadata.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\Message\Api\Model\ParticipantInterface;
use FOS\Message\Api\Model\ThreadInterface;
use FOS\Message\Driver\DoctrineORM\Entity\ThreadMetadata as BaseThreadMetadata;

/**
 * @ORM\Table(name="threads_metdata")
 * @ORM\Entity
 */
class ThreadMetadata extends BaseThreadMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="metadata", cascade={"all"})
     * @var ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"all"})
     * @var ParticipantInterface
     */
    protected $participant;
}
```

[Continue with the installation](../01-installation.md)
