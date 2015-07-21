- [Previous: Index](00-index.md)
- Next: TODO

Integrate FOSMessageBundle to your application
==============================================

While your current installation is working, you would probably want to integrate FOSMessageBundle
into your application, especially to adapt the templates to your application look.

Doing so is very easy and you can use differents techniques:

- Overriding the template layout ;
- Use CSS to customize the default theme ;
- Use the Bootstrap3 theme ;
- Overriding all or specific pages templates ;


Overriding the templates layout
-------------------------------

The first step alsmost every time required to integrate FOSMessageBundle in your
application is to override the global templates layout. By doing so, you will be 
able to integrate your application layout around the messaging system.

To override the global templates layout, create the file
`app/Resources/FOSMessageBundle/views/layout.html.twig` and redfine where you
want the block `{% block fos_message_content %}{% endblock %}`. For instance:

``` twig
{# app/Resources/FOSMessageBundle/views/layout.html.twig #}

{% extends 'base.html.twig' %}

{% block content %}
    {% block fos_message_content %}{% endblock %}
{% endblock %}
```

> **Note**: when you create the file `app/Resources/FOSMessageBundle/views/layout.html.twig`,
> you may need to clear your application cache (even in develeopment environment).

Use CSS to customize the default theme
--------------------------------------

The default templates already provide a lot of CSS classes on various elements,
so if you only need to customize the style of the messaging system without needing
HTML modifications, you can easily just customize your application by using CSS.

Use the Bootstrap3 theme
------------------------

If your application use Bootstrap3 and you don't need to change the HTML,
you can use the Bootstrap3 theme.

Themes in FOSMessageBundle are predefined sets of templates aiming to ease
your website integration by providing front-end framework specific templates.

The Bootstrap3 theme is usable out of the box by changing a line in your configuration:

``` yml
# app/config/config.yml

fos_message:

    # Templates theme ("default" or "bootstrap3")
    theme: bootstrap3

    # ...
```

*[Learn more about the themes (TODO)]()*

Overriding all or specific pages templates
------------------------------------------

If you need to change the HTML of all or specific pages, you can do it by overriding the
templates in the `app/Resources/FOSMessageBundle/views` directory.

To do so, go in the installation directory of FOSMessageBundle and copy the theme you want
as a base: for instance, to customize the HTML of the Bootstrap3 theme, copy
`vendor/tgalopin/fos-message-bundle/Resources/views/bootstrap3` to 
`app/Resources/FOSMessageBundle/views/bootstrap3`.

Once copied, you can edit the templates as much as you want.

> **Note**: when you copy the theme, you may need to clear your application cache
> (even in develeopment environment).
