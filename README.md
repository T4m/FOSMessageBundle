FOSMessageBundle
================

[![Build Status](https://travis-ci.org/tgalopin/FOSMessageBundle.svg)](https://travis-ci.org/tgalopin/FOSMessageBundle)

The FOSMessageBundle provides user-to-user messaging features for Symfony2
applications. It is an implementation of the
[FOSMessage library](https://github.com/tgalopin/FOSMessage).

It provides a flexible framework for messaging management that aims to handle
common tasks of messaging systems.

Features include:

- Messages can be stored via Doctrine ORM *(ODM comming soon)*
- Threaded conversations with inbox, sentbox and deletedbox
- Permissions for messaging
- Integration with FOSUserBundle for user chooser
- Integration with KnpPaginatorBundle for easy pagination
- Integration with Bootstrap3 (theme provided)

**Note**: This bundle is based on the [FOSMessage library](https://github.com/tgalopin/FOSMessage).

Documentation
-------------

The documentation is stored in the `Resources/doc/` directory in this bundle:

[Read the Documentation](https://github.com/tgalopin/FOSMessageBundle/blob/master/Resources/doc/index.md)

Installation
------------

All the installation instructions are located in the documentation.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

Authors
-------

- [Titouan Galopin](https://github.com/tgalopin) aka [tgalopin](https://twitter.com/titouangalopin)
- [The Community contributors] (https://github.com/tgalopin/FOSMessageBundle/contributors)

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/tgalopin/FOSMessageBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.