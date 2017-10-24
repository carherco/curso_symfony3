# Routing

En symfony, una ruta es un mapeo entre una url y un controlador. Las rutas no se 
programan, sino que se configuran o definen.

Hay 4 formas distintas de configurar las rutas en symfony:

- Con anotaciones en los propios controladores
- En un fichero de configuración YML
- En un fichero de configuración XML
- En un fichero de configuración PHP

En este curso veremos las 2 primeras que son las utilizadas por la inmensa 
mayoría de la comunidad symfony.

En la documentación de symfony (https://symfony.com/doc/current/routing.html) 
vienen las 4 formas perfectamente explicadas.

## Anotaciones

```php
    /**
     * @Route("/home", name="home")
     */
    public function homeAction()
```

```
    /**
     * @Route("/login", name="login")
     */
    public function homeAction()
```

El atributo name es necesario, pero no es obligatorio. Si no se pone, symfony 
asignará automáticamente un nombre a la ruta. Dicho nombre puede verse en la 
barra de depuración.

Los nombres de las rutas deberían ser ÚNICOS. En caso de que el Bundle que vayamos 
a crear vaya a ser distribuido para otras aplicaciones, una buena práctica es ponerles un 
prefijo para evitar colisiones con otros bundles o con las propias aplicaciones 
en las que se instale nuestro bundle.

## YML

Si se definen las rutas en formato .yml, el fichero está en app/config/routing.yml

```yml
home:
    path:     /home
    defaults: { _controller: AppBundle:Public:home }

login:
    path:     /login
    defaults: { _controller: AppBundle:Public:login }
```

En formato .yml, es imposible definir una ruta sin ponerle un nombre.


## Rutas con parámetros

Consideremos la siguiente ruta:

user_edit:
  path:  /user/edit/{id}
  defaults: { _controller: AppBundle:Routing:edit }

Esta ruta hace match con

http://localhost:8000/user/edit/3
http://localhost:8000/user/edit/78

Pero no hace match con 

http://localhost:8000/user/edit

Al la función del controlador le llegará un parámetro de entrada $id, con el valor 
del wildcard.

```php
public function editAction($id)
```

Esta ruta anterior también hace match con 

http://localhost:8000/user/edit/78/patata


Se puede tener más de un wildcard en una misma ruta

http://localhost:8000/user/{action}/{id}

```php
public function editAction($action, $id)
```


## Restricciones de los parámetros

```yml
user_edit:
  path:  /user/edit/{id}
  defaults: { _controller: AppBundle:Routing:edit }
  requirements:
    id: '\d+'
```

El \d+ es una expresión regular. 

Otro ejemplo con expresiones regulares podría ser:

```yml
homepage:
    path:      /{_locale}
    defaults:  { _controller: AppBundle:Main:homepage, _locale: en }
    requirements:
        _locale:  en|fr
```


## Valor por defecto de un parámetro

```yml
user_edit:
  path:  /user/edit/{id}
  defaults: { _controller: AppBundle:Routing:edit, id: 1 }
  requirements:
    id: '\d+'

homepage:
    path:      /{_locale}
    defaults:  { _controller: AppBundle:Main:homepage, _locale: en }
    requirements:
        _locale:  en|fr
```

```
/     =>  {_locale} = "en"
/en   =>  {_locale} = "en"
/fr   =>  {_locale} = "fr"
/es   =>  No hace match
```

Con anotaciones:

```php
class MainController extends Controller
{
    /**
     * @Route("/{_locale}", defaults={"_locale": "en"}, requirements={
     *     "_locale": "en|fr"
     * })
     */
    public function homepageAction($_locale)
    {
    }
```





## Restringir por método (GET, POST...)

```yml
api_user_show:
    path:     /api/users/{id}
    defaults: { _controller: AppBundle:UsersApi:show }
    methods:  [GET, HEAD]

api_user_edit:
    path:     /api/users/{id}
    defaults: { _controller: AppBundle:UsersApi:edit }
    methods:  [PUT]
```

```php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// ...

class UsersApiController extends Controller
{
    /**
     * @Route("/api/users/{id}")
     * @Method({"GET","HEAD"})
     */
    public function showAction($id)
    {
        // ... return a JSON response with the post
    }

    /**
     * @Route("/api/users/{id}")
     * @Method("PUT")
     */
    public function editAction($id)
    {
        // ... edit a post
    }
}
```

## Ejemplo complejo

```yml
article_show:
  path:     /articles/{_locale}/{year}/{slug}.{_format}
  defaults: { _controller: AppBundle:Article:show, _format: html }
  requirements:
      _locale:  en|fr
      _format:  html|rss
      year:     \d+
```

```php
class ArticleController extends Controller
{
    /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function showAction($_locale, $year, $slug)
    {
    }
}
```

URLs válidas:

```
/articles/en/2010/my-post
/articles/fr/2010/my-post.rss
/articles/en/2013/my-latest-post.html
```

## Parámetros especiales

_controller
Este parámetro determina qué controlador se ejecutará.
_format
Establece el formato de la request (read more).
_fragment (a partir de symfony 3.2)
Establece el *fragment* de la url
_locale
Establece el idioma de la petición


## El orden de las rutas importa



## Prefijando todas las rutas de un controlador

```php
/**
 * @Route("/formularios", name="formularios_")
 */

```
class FormulariosController extends Controller


## Generando urls en el controlador

```php
    public function showAction($id)
    {
        // ...

        // /blog/my-blog-post
        $url = $this->generateUrl(
            'user_edit',
            array('id' => $id)
        );
    }
```

http://localhost:8000/user/edit/35

Si se pasan parámetros extra, se inlcuirán en la url como parámetros de la query string.

```php
    public function showAction($id)
    {
        // ...

        // /blog/my-blog-post
        $url = $this->generateUrl(
            'user_edit',
            array('id' => $id, 'otro' => 'valor')
        );
    }
```

/user/edit/35?otro=valor

Para generar urls absolutas, se debe pasar un tercer parámetro a la función generateUrl():

```php
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    //...

    public function showAction($id)
    {
        // ...

        // /blog/my-blog-post
        $url = $this->generateUrl(
            'user_edit',
            array('id' => $id, 'otro' => 'valor'),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
```




https://symfony.com/doc/current/routing.html

