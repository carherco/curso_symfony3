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

### Tipos de datos

#### Cadenas de texto

Van entre comillas. 

- Con comillas simples o dobles: "Hello World"
- El caracter de escape es la barra invertida (\): 'It\'s good'.
- La barra invertida se escapa con otra barra invertida: 'c:\\Program Files'

#### Números

Simplemente se escriben tal cual.

- Si hay un punto, el número será un *float*. Si no lo hay, será un *integer*.

#### Arrays

Se definen entre corchetes cuadrados, separando los elementos con comas: ["foo", "bar"]

#### Hashes

Son listas de parejas clave/valor, separadas por comas y encerradas entre llaves: {"foo": "bar"}

```twig
{# keys as string #}
{ 'foo': 'foo', 'bar': 'bar' }
```

```twig
{# keys as names (equivalent to the previous hash) #}
{ foo: 'foo', bar: 'bar' }
```

```twig
{# keys as integer #}
{ 2: 'foo', 4: 'bar' }
```

```twig
{# keys as expressions (the expression must be enclosed into parentheses) #}
{% set foo = 'foo' %}
{ (foo): 'foo', (1 + 1): 'bar', (foo ~ 'b'): 'baz' }
```

#### Booleanos

Se escriben tal cual:
- true
- false

#### Null

Se escribe tal cual
- null
- none (es un alias de null)


Los arrays y los  hashes se pueden anidar:


{% set foo = [1, {"foo": "bar"}] %}

### Operadores matemáticos

+: Suma: {{ 1 + 1 }}
-: Resta: {{ 3 - 2 }}
/: División. El resultado es un float: {{ 1 / 2 }} es {{ 0.5 }}.
%: Resto de una división: {{ 11 % 7 }} is 4.
//: División más redondeo a la baja: {{ 20 // 7 }} is 2, {{ -20 // 7 }} is -3
*: Multiplicación: {{ 2 * 2 }}
**: Potencia: {{ 2 ** 3 }} es 8.

Twig intenta hacer cast de los operandos antes de realizar la operación

### Operadores lógicos

- and
- or
- not

### Comparadores

La lista de comparadores es la siguiente: ==, !=, <, >, >=, and <=.

Además existen los comparadores start, end y matches

{% if 'Fabien' starts with 'F' %}
{% endif %}

{% if 'Fabien' ends with 'n' %}
{% endif %}

{% if phone matches '/^[\\d\\.]+$/' %}
{% endif %}

### Operador in

{{ 1 in [1, 2, 3] }}
{{ 'cd' in 'abcde' }}

{% if 1 not in [1, 2, 3] %}
{# is equivalent to #}
{% if not (1 in [1, 2, 3]) %}

### Operador de testeo: is

{# find out if a variable is odd #}
{{ name is odd }}

{% if post.status is constant('Post::PUBLISHED') %}

{% if post.status is not constant('Post::PUBLISHED') %}
{# is equivalent to #}
{% if not (post.status is constant('Post::PUBLISHED')) %}

https://twig.symfony.com/doc/2.x/tests/index.html

### Otros operadores

#### Operador |

Aplica un filtro

#### Operador ..

Crea una secuencia (equivalente a la función range()

```twig
{{ 1..5 }}

{# equivalent to #}
{{ range(1, 5) }}
```

#### Operador ~

Convierte los operadores en strings y los concatena

{{ "Hello " ~ name ~ "!" }} => Hello John!.

#### Operador .

```
{{ user.edad }}
```

Cuando twig se encuentra un . realiza las siguientes operaciones en la capa PHP:

1. Comprueba si user es un array y *edad* un elemento de dicho array
2. Si no, si user es un objeto, comprueba que *edad* es una propiedad de de dicho objeto
3. Si no, si user es un objeto, comprueba que *edad()* es un método público de dicho objeto
4. Si no, si user es un objeto, comprueba que *getEdad()* es un método público de dicho objeto
5. Si no, si user es un objeto, comprueba que *isEdad()* es un método público de dicho objeto
6. Si no, si user es un objeto, comprueba que *hasEdad()* es un método público de dicho objeto
7. Si no, devuelve el valor *null*.

#### Operador []

```
{{ user['edad'] }}
```

1. Comprueba si user es un array y edad un elemento de dicho array
2. Si no, devuelve el valor *null*.

#### El operador ? y ?:

{{ foo ? 'yes' : 'no' }}
{{ foo ?: 'no' }} equivale a {{ foo ? foo : 'no' }}
{{ foo ? 'yes' }} equivale a {{ foo ? 'yes' : '' }}

#### El operador ??

{# Devuelve el valor de *foo* si está definido y no es nulo. En cualquier otro caso, devuelve el valor 'no' #}
{{ foo ?? 'no' }}



#### El método attribute()

No es un operador, pero es una función auxiliar para el operador .

```
{{ attribute(user, 'fecha-nacimiento') }}
```

Esta función es útil para acceder atributos con caracteres especiales que pueden dar lugar a confusión.

También para acceder a atributos dinámicamente.


https://twig.symfony.com/doc/2.x/templates.html


### Variables globales

Estas variables están siempre disponibles en las plantillas:

_self: Hace referencia al nombre de la plantilla actual
_context: Hace referencia al contexto actual
_charset: Hace referencia al charset actual


## La etiqueta set

Se utilizar para declarar y establecer valor de variables

```
{% set foo = 'foo' %}
{% set foo = [1, 2] %}
{% set foo = {'foo': 'bar'} %}
```

## La etiqueta if

```
{% if kenny.sick %}
    //---
{% elseif kenny.dead %}
    //---
{% else %}
    //---
{% endif %}


{% if user.edad > 18 and user.active %}
...
{% if not user.active %}
...

```


## La etiqueta for

```
<h1>Members</h1>
<ul>
    {% for user in users %}
        <li>{{ user.username|e }}</li>
    {% endfor %}
</ul>
```

Se utiliza para recorrer arrays o objetos que implementen la interfaz *Traversable*.
http://php.net/manual/es/class.traversable.php


```
{% for i in 0..10 %}
    * {{ i }}
{% endfor %}
```

```
{% for letter in 'a'..'z' %}
    * {{ letter }}
{% endfor %}
```

### La variable loop

```
{% for user in users %}
    {{ loop.index }} - {{ user.username }}
{% endfor %}
```

Dentro de un bucle for, se puede acceder a una variable especial *loop* con los siguientes atributos:

- loop.index	The current iteration of the loop. (1 indexed)
- loop.index0	The current iteration of the loop. (0 indexed)
- loop.revindex	The number of iterations from the end of the loop (1 indexed)
- loop.revindex0	The number of iterations from the end of the loop (0 indexed)
- loop.first	True if first iteration
- loop.last	True if last iteration
- loop.length	The number of items in the sequence
- loop.parent	The parent context

Nota: Las variables loop.length, loop.revindex, loop.revindex0, y loop.last solamente 
están disponibles para arrays PHP u objetos que implementan la interfaz *Countable*.
Tampoco están disponibles si se recorre el bucle con una condición.

### Añadiendo una condición en el bucle

```
<ul>
    {% for user in users if user.active %}
        <li>{{ user.username|e }}</li>
    {% endfor %}
</ul>
```

### La cláusula else

Si no se produce ninguna iteración porque la secuencia estaba vacía, se puede renderizar
un bloque utilizando la cláusula *else*.

```
<ul>
    {% for user in users %}
        <li>{{ user.username|e }}</li>
    {% else %}
        <li><em>no user found</em></li>
    {% endfor %}
</ul>
```


### Iterar con acceso a las claves


```
<h1>Members</h1>
<ul>
    {% for key, user in users %}
        <li>{{ key }}: {{ user.username|e }}</li>
    {% endfor %}
</ul>
```



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

Es una extensión de symfony.

<a href="{{ url('welcome') }}">Home</a>


## Función asset()

Es una extensión de symfony.

<img src="{{ asset('images/logo.png') }}" alt="Symfony!" />

<link href="{{ asset('css/blog.css') }}" rel="stylesheet" />

Genera rutas relativas al directorio webroot del proyecto.

http://example.com => /images/logo.png
http://example.com/my_app => /my_app/images/logo.png


## Función absolute_url()

Extensión de symfony.

<img src="{{ absolute_url(asset('images/logo.png')) }}" alt="Symfony!" />


## Template Inheritance and Layouts - Las etiquetas extends y block

La clave para la herencia de plantillas es la etiqueta *{% extends %}*. 

Esta etiqueta le dice a Twig que primero evalúe la plantilla base, en la que se 
definirá el layout y uno o más bloques mediante la etiqueta *{% block %}*.

Después se renderiza la plantilla *hija*. En la plantilla hija, se redefinen los 
bloques que se deseen. Los bloques que no redefinan en la plantilla hija, se 
renderizarán tal como los haya definido la plantilla base.

Se pueden utilizar tantos niveles de herencia como se quieran. Al trabajar con 
herencia de plantillas, hay que tener en cuenta unas cuantas cosas:

La etiqueta *{% extends %}* debe ser la primera etiqueta de dicha plantilla.


## Función parent()

```
{# app/Resources/views/contact/contact.html.twig #}
{% extends 'base.html.twig' %}

{% block stylesheets %}
    {{ parent() }}

    <link href="{{ asset('css/contact.css') }}" rel="stylesheet" />
{% endblock %}
```

## Función include()

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

The template is included using the {{ include() }} function. Notice that the template 
name follows the same typical convention. The article_details.html.twig template 
uses an article variable, which we pass to it. In this case, you could avoid 
doing this entirely, as all of the variables available in list.html.twig are 
also available in article_details.html.twig (unless you set with_context to false).






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






## Filtros

Se aplican con el operador |

```
{{ name|upper }}
```

Son concatenables

```
{{ name|striptags|title }}
```

Admiten parámetros

```
{{ list|join(', ') }}
```

Se pueden aplicar a bloques completos

```
{% filter upper %}
    Este texto se transformará en mayúsculas
{% endfilter %}
```



## Filtro slice

```
<h1>Top Ten Members</h1>
<ul>
    {% for user in users|slice(0, 10) %}
        <li>{{ user.username|e }}</li>
    {% endfor %}
</ul>
```

## Funciones

Se utilizan de forma similar a la mayoría de lenguajes de programación

```
{% for i in range(0, 3) %}
    {{ i }},
{% endfor %}
```

### Named arguments

```
{% for i in range(low=1, high=10, step=2) %}
    {{ i }},
{% endfor %}
```

Using named arguments makes your templates more explicit about the meaning of the values you pass as arguments:

```
{{ data|convert_encoding('UTF-8', 'iso-2022-jp') }}

{# versus #}

{{ data|convert_encoding(from='iso-2022-jp', to='UTF-8') }}
```

Named arguments also allow you to skip some arguments for which you don't want to change the default value:

```
{# the first argument is the date format, which defaults to the global date format if null is passed #}
{{ "now"|date(null, "Europe/Paris") }}

{# or skip the format value by using a named argument for the time zone #}
{{ "now"|date(timezone="Europe/Paris") }}
```

You can also use both positional and named arguments in one call, in which case positional arguments must always come before named arguments:

```
{{ "now"|date('d/m/Y H:i', timezone="Europe/Paris") }}
```
