# Twig

## Twig Template Caching

Twig es rápido porque cada plantilla se compila a código nativo PHP y se cachea. 
Esto ocurre de forma automática. Sin embargo, durante el desarrollo, Twig no cachea 
sino que recompila las plantillas después de cada cambio. Esto hace que Twig sea
rápido en producción pero cómodo durante el desarrollo.


## Twig syntax

Twig define tres tipos de sintaxis:

{{ ... }}
Renderiza en la plantilla el valor de una variable o el resultado de una expresión.

{% ... %}
Ejecuta instrucciones lógicas (condiciones, bucles, etc).

{# ... #}
Comentarios. Los comentarios de Twig no se incluyen en las páginas renderizadas.

Twig también tiene filtros, que modifican el contenido que va a ser renderizado.
{{ title|upper }}

Twig viene con una larga lista de etiquetas, filtros y funciones disponibles por defecto. 
También se pueden añadir filtros y funciones personalizados con extensiones de Twig.

https://twig.symfony.com/doc/2.x/tags/index.html
https://twig.symfony.com/doc/2.x/filters/index.html
https://twig.symfony.com/doc/2.x/functions/index.html



## Función path()

Extensión de symfony.

// src/AppBundle/Controller/WelcomeController.php

// ...
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WelcomeController extends Controller
{
    /**
     * @Route("/", name="welcome")
     */
    public function indexAction()
    {
        // ...
    }
}



<a href="{{ path('welcome') }}">Home</a>



### Función path() con parámetros

// src/AppBundle/Controller/ArticleController.php

// ...
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/article/{slug}", name="article_show")
     */
    public function showAction($slug)
    {
        // ...
    }
}



{# app/Resources/views/article/recent_list.html.twig #}
{% for article in articles %}
    <a href="{{ path('article_show', {'slug': article.slug}) }}">
        {{ article.title }}
    </a>
{% endfor %}


## Función url()

Extensión de symfony.

<a href="{{ url('welcome') }}">Home</a>


## Función asset()

Extensión de symfony.

<img src="{{ asset('images/logo.png') }}" alt="Symfony!" />

<link href="{{ asset('css/blog.css') }}" rel="stylesheet" />

Genera rutas relativas al directorio webroot del proyecto.

http://example.com => /images/logo.png
http://example.com/my_app => /my_app/images/logo.png


## Función absolute_url()

Extensión de symfony.

<img src="{{ absolute_url(asset('images/logo.png')) }}" alt="Symfony!" />


## Template Inheritance and Layouts

The key to template inheritance is the {% extends %} tag. This tells the templating engine to first evaluate the base template, which sets up the layout and defines several blocks. The child template is then rendered, at which point the title and body blocks of the parent are replaced by those from the child. Depending on the value of blog_entries, the output might look like this:

Notice that since the child template didn't define a sidebar block, the value from the parent template is used instead. Content within a {% block %} tag in a parent template is always used by default.

TIP
You can use as many levels of inheritance as you want! See How to Organize Your Twig Templates Using Inheritance for more info.
When working with template inheritance, here are some tips to keep in mind:

If you use {% extends %} in a template, it must be the first tag in that template;

The more {% block %} tags you have in your base templates, the better. Remember, child templates don't have to define all parent blocks, so create as many blocks in your base templates as you want and give each a sensible default. The more blocks your base templates have, the more flexible your layout will be;

If you find yourself duplicating content in a number of templates, it probably means you should move that content to a {% block %} in a parent template. In some cases, a better solution may be to move the content to a new template and include it (see Including other Templates);

If you need to get the content of a block from the parent template, you can use the {{ parent() }} function. This is useful if you want to add to the contents of a parent block instead of completely overriding it:


## Función parent()

{# app/Resources/views/contact/contact.html.twig #}
{% extends 'base.html.twig' %}

{% block stylesheets %}
    {{ parent() }}

    <link href="{{ asset('css/contact.css') }}" rel="stylesheet" />
{% endblock %}

{# ... #}







## Template Naming and Locations

By default, templates can live in two different locations:

app/Resources/views/
The application's views directory can contain application-wide base templates (i.e. your application's layouts and templates of the application bundle) as well as templates that override third party bundle templates (see How to Override Templates from Third-Party Bundles).
vendor/path/to/CoolBundle/Resources/views/
Each third party bundle houses its templates in its Resources/views/ directory (and subdirectories). When you plan to share your bundle, you should put the templates in the bundle instead of the app/ directory.
Most of the templates you'll use live in the app/Resources/views/ directory. The path you'll use will be relative to this directory. For example, to render/extend app/Resources/views/base.html.twig, you'll use the base.html.twig path and to render/extend app/Resources/views/blog/index.html.twig, you'll use the blog/index.html.twig path.

## Referencing Templates in a Bundle
If you need to refer to a template that lives in a bundle, Symfony uses the Twig namespaced syntax (@BundleName/directory/filename.html.twig). This allows for several types of templates, each which lives in a specific location:

@AcmeBlog/Blog/index.html.twig: This syntax is used to specify a template for a specific page. The three parts of the string, each separated by a slash (/), mean the following:

@AcmeBlog: is the bundle name without the Bundle suffix. This template lives in the AcmeBlogBundle (e.g. src/Acme/BlogBundle);
Blog: (directory) indicates that the template lives inside the Blog subdirectory of Resources/views/;
index.html.twig: (filename) the actual name of the file is index.html.twig.
Assuming that the AcmeBlogBundle lives at src/Acme/BlogBundle, the final path to the layout would be src/Acme/BlogBundle/Resources/views/Blog/index.html.twig.

@AcmeBlog/layout.html.twig: This syntax refers to a base template that's specific to the AcmeBlogBundle. Since the middle, "directory", portion is missing (e.g. Blog), the template lives at Resources/views/layout.html.twig inside AcmeBlogBundle.

## Override Templates from Third-Party Bundles

In the How to Override Templates from Third-Party Bundles section, you'll find out how each template living inside the AcmeBlogBundle, for example, can be overridden by placing a template of the same name in the app/Resources/AcmeBlogBundle/views/ directory. This gives the power to override templates from any vendor bundle.

## Including other Templates

{# app/Resources/views/article/article_details.html.twig #}
<h2>{{ article.title }}</h2>
<h3 class="byline">by {{ article.authorName }}</h3>

<p>
    {{ article.body }}
</p>

{# app/Resources/views/article/list.html.twig #}
{% extends 'layout.html.twig' %}

{% block body %}
    <h1>Recent Articles<h1>

    {% for article in articles %}
        {{ include('article/article_details.html.twig', { 'article': article }) }}
    {% endfor %}
{% endblock %}

The template is included using the {{ include() }} function. Notice that the template name follows the same typical convention. The article_details.html.twig template uses an article variable, which we pass to it. In this case, you could avoid doing this entirely, as all of the variables available in list.html.twig are also available in article_details.html.twig (unless you set with_context to false).






## Acceso a variables globales del framework

- app.user
The representation of the current user or null if there is none. The value stored in this variable can be a UserInterface object, any other object which implements a __toString() method or even a regular string.

- app.request
The Request object that represents the current request (depending on your application, this can be a sub-request or a regular request, as explained later).

- app.session
The Session object that represents the current user's session or null if there is none.

- app.environment
The name of the current environment (dev, prod, etc).

- app.debug
True if in debug mode. False otherwise.

```html
<p>Username: {{ app.user.username }}</p>
{% if app.debug %}
    <p>Request method: {{ app.request.method }}</p>
    <p>Application Environment: {{ app.environment }}</p>
{% endif %}
```

## Cómo inyectar variables globales en las plantillas

https://symfony.com/doc/current/templating/global_variables.html

Sometimes you want a variable to be accessible to all the templates you use. This is possible inside your app/config/config.yml file:


// app/config/config.yml
twig:
    # ...
    globals:
        ga_tracking: UA-xxxxx-x
 
XML
 
PHP
Now, the variable ga_tracking is available in all Twig templates:


<p>The google tracking code is: {{ ga_tracking }}</p>
It's that easy!

Using Service Container Parameters¶

You can also take advantage of the built-in Service Parameters system, which lets you isolate or reuse the value:


// app/config/parameters.yml
parameters:
    ga_tracking: UA-xxxxx-x

// app/config/config.yml
twig:
    globals:
        ga_tracking: '%ga_tracking%'
 

The same variable is available exactly as before.




Instead of using static values, you can also set the value to a service. Whenever the global variable is accessed in the template, the service will be requested from the service container and you get access to that object.

NOTE
The service is not loaded lazily. In other words, as soon as Twig is loaded, your service is instantiated, even if you never use that global variable.
To define a service as a global Twig variable, prefix the string with @. This should feel familiar, as it's the same syntax you use in service configuration.


// app/config/config.yml
twig:
    # ...
    globals:
        # the value is the service's id
        user_management: '@AppBundle\Service\UserManagement'


## Output Escaping

Twig performs automatic "output escaping" when rendering any content in order to protect you from Cross Site Scripting (XSS) attacks.

Suppose description equals I <3 this product:

<!-- output escaping is on automatically -->
{{ description }} <!-- I &lt;3 this product -->

<!-- disable output escaping with the raw filter -->
{{ description|raw }} <!-- I <3 this product -->


## Cómo escribir una extensión de Twig

https://symfony.com/doc/current/templating/twig_extension.html