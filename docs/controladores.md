Controladores
=============

En Symfony un controlador es una función PHP que creamos para leer información del 
objeto Request de Symfony y crear y devolver un objeto Response.

La respuesta puede ser una página HTML, JSON, XML, una descarga de un fichero, 
una redirección, un error 404...

El controlador ejecuta cualquier código que necesitemos para renderizar el contenido
de la página.

La Clase Controladora
--------------------- 

El propósito de una clase controladora es albergar controladores.

Una clase controladora en symfony es una clase cuyo nombre tiene el sufijo *Controller* 
y que extiende de *Controller* o de *AbstractController*. La clase *AbstractController* 
se ha añadido en Symfony 3.3.

La única diferencia es que con AbstractController NO pueedes acceder a los servicios
directamente a través de los métodos $this->get() o $this->container->get(). Esto
obliga a escribir código algo más robusto para acceder a los servicios.


Generar URLs
------------

El método **generateUrl()** genera la url de una ruta a partir de su nombre.

```php
$url = $this->generateUrl('asignaturas_edit', array('id' => 3));
```

Redirecciones
-------------

Tenemos dos métodos para hacer redirecciones: 
- **redirectToRoute()** => para redirigir a una ruta
- **redirect()** => Para redirigir a una url

```php
public function indexAction()
{
    // devuelve un 303 que redirige a la ruta "homepage"
    return $this->redirectToRoute('homepage');

    // devuelve un 301 permanent redirect
    return $this->redirectToRoute('homepage', array(), 301);

    // redirección a ruta con parámetros
    return $this->redirectToRoute('alumno_show', array('id' => $id));

    // redirect a url externa
    return $this->redirect('http://symfony.com/doc');
}
```

El método **redirectToRoute()** devuelve un objeto **RedirectResponse** de forma que 


```php
public function indexAction()
{
    return $this->redirectToRoute('homepage');
}
```
es equivalente a 

```php
use Symfony\Component\HttpFoundation\RedirectResponse;

public function indexAction()
{
    return new RedirectResponse($this->generateUrl('homepage'));
}
```

Renderizado de plantillas
-------------------------

Si vamos a servir una página HTML, lo haremos renderizando una plantilla. El 
método **render()** se encarga de renderiza una plantilla y coloca el contenido 
resultante en un objeto *Response*.

```php
return $this->render('alumno/index.html.twig', array(
    'alumnos' => $alumnos,
));
```


Obtener servicios a través de los argumentos del controlador
------------------------------------------------------------

A partir de Symfony 3.3, podemos obtener los servicios inyectados por Symfony 
en los argumentos del controlador simplemente tipando el argumento con su clase
o interfaz correspondiente. Symfony automáticamente nos pasara el servicio ya 
instanciado.

```php
use Psr\Log\LoggerInterface;

/**
 * @Route("/products")
 */
public function listAction(LoggerInterface $logger)
{
    $logger->info('Look! I just used a service');

    // ...
}
```


El comando debug:container nos permite obtener la lista de todos los servicios 
que podemos inyectar.

> php bin/console debug:container

> php bin/console debug:container --types


No obstante, si nuestra clase controladora extiende de *Controller*, tenemos 
disponible la inyección de dependencias habitual de symonfy.

```php

$logger = $this->get('logger');

$templating = $this->get('templating');

$router = $this->get('router');

$mailer = $this->get('mailer');

```

Errores y páginas 404
---------------------


Cuando no encontramos un recurso, deberíamos seguir las normas del protocolo 
HTTP y devolver una respuesta 404.

```php
public function editAction($id)
{
    $alumno = $em->getRepository('AppBundle:Alumno')->find($id);
    if (!$alumno) {
        throw $this->createNotFoundException('El alumno solicitado no existe.');
    }

    return $this->render(...);
}
```

El método **createNotFoundException()** crea un objeto **NotFoundHttpException**
que genera una respuesta HTTP 404.

En cualquier momento podemos lanzar cualquier clase derivada de Exception en 
nuestro controlador. Symony devolverá una respuesta HTTP 500.

```php
throw new \Exception('Algo ha ido mal. Avise a la persona administradora de la página.');
```

Las plantillas de error están en el bundle de Twig, pero se pueden sobreescribir
si nos creamos un directorio *app/Resources/Twig/Bundle/Exception* y colocamos 
en dicho directorio nuestras plantillas personalizadas.

```
app/
└─ Resources/
   └─ TwigBundle/
      └─ views/
         └─ Exception/
            ├─ error404.html.twig
            ├─ error403.html.twig
            ├─ error.html.twig      # All other HTML errors (including 500)
            ├─ error404.json.twig
            ├─ error403.json.twig
            └─ error.json.twig      # All other JSON errors (including 500)
```

https://symfony.com/doc/current/controller/error_pages.html


Acceso a la request
-------------------

Toda la información sobre la petición, es accesible desde el objeto **Request**.

Basta con incluirlo como argumento del controlador para tener acceso a él.

```php
use Symfony\Component\HttpFoundation\Request;

public function indexAction(Request $request, $firstName, $lastName)
{
    $request->isXmlHttpRequest(); // is it an Ajax request?

    $request->getPreferredLanguage(array('en', 'fr'));

    // obtener variables enviadas por GET y por POST respectivamente
    $request->query->get('page');
    $request->request->get('page');

    // obtener variables $_SERVER
    $request->server->get('HTTP_HOST');

    // obtener una instancia de la clase UploadedFile con el fichero enviado
    $request->files->get('fichero');

    // obtener el valor de una COOKIE 
    $request->cookies->get('PHPSESSID');

    // obtener una cabecera HTTP
    $request->headers->get('host');
    $request->headers->get('content_type');
}
```

https://symfony.com/doc/current/components/http_foundation.html#component-http-foundation-request


El objeto Response
-----------------

Como ya hemos dicho, la única obligación de un controlador es devolver un objeto 
Response.

```php
use Symfony\Component\HttpFoundation\Response;

...

$response = new Response(
    'Content',
    Response::HTTP_OK,
    array('content-type' => 'text/html')
);

return $response;

```

El objeto response tiene métodos para establecer los valores del content, del 
código de estado, de los headers...

```php
$response->setContent('<h1>Hello World</h1>');

$response->headers->set('Content-Type', 'text/plain');

$response->headers->setCookie(new Cookie('foo', 'bar'));

$response->setStatusCode(Response::HTTP_NOT_FOUND);

$response->setCharset('ISO-8859-1');
```

NOTA: Desde la versión 3.1, no se puede configurar el charset por defecto de las 
respuestas en el config.yml. Se debe hacer en la clase AppKernel. (Symony utiliza
por defecto UTF-8).

```php
class AppKernel extends Kernel
{
    public function getCharset()
    {
        return 'ISO-8859-1';
    }
}
```

Ejemplo de respuesta json:

```php
$response = new Response();
$response->setContent(json_encode(array(
    'data' => 123,
)));
$response->headers->set('Content-Type', 'application/json');
return $response
```

Symfony dispone de objetos que extienden de Response para facilitar tipos de 
respuesta muy comunes:
 
- RedirectResponse
- JsonResponse
- BinaryFileResponse
- StreamedResponse

Además al extender de Controller o de AbstractController, tenemos disponibles 
funciones *helper* que facilitan la generación de los objetos Response correspondientes:

```php
$this->redirect('http://symfony.com/doc');

$this->json(array('data' => 123));

$this->file('/path/to/some_file.pdf');
```


https://symfony.com/doc/current/components/http_foundation.html#redirecting-the-user

https://symfony.com/doc/current/components/http_foundation.html#creating-a-json-response

https://symfony.com/doc/current/components/http_foundation.html#component-http-foundation-serving-files

https://symfony.com/doc/current/components/http_foundation.html#streaming-response


Acceso a la sesión
------------------

A partir de Symfony 3.3 podemos acceder a la sesión a través de los parámetros
del controlador

```php
use Symfony\Component\HttpFoundation\Session\SessionInterface;

public function indexAction(SessionInterface $session)
{
    // store an attribute for reuse during a later user request
    $session->set('foo', 'bar');

    // get the attribute set by another controller in another request
    $foobar = $session->get('foobar');

    // use a default value if the attribute doesn't exist
    $filters = $session->get('filters', array());

    $foobar = $session->invalidate('foobar');

    $foobar = $session->clear();
}
```


Acceso a la request, la sesión, etc, desde twig
-----------------------------------------------

Recordemos que desde twig tenemos acceso a la variable app, que no permite acceder
a la request, la sesión, etc

- app.user
- app.request
- app.session
- app.environment
- app.debug



Mensajes Flash
--------------

Los mensajes flash son internamente atributos de sesión que pueden ser utilizados 
una única vez. Desaparecen de la sesión automáticamente cuando recuperamos su valor.

Son útiles para mostrar notificaciones al usuario.

Veamos un ejemplo:

```php
use Symfony\Component\HttpFoundation\Request;

public function updateAction(Request $request)
{
    // ...

    if ($form->isSubmitted() && $form->isValid()) {
        // do some sort of processing

        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        // $this->addFlash() is equivalente a $request->getSession()->getFlashBag()->add()

        return $this->redirectToRoute(...);
    }

    return $this->render(...);
}
```

En una plantilla concreta o incluso en una plantilla base, podemos acceder a los
mensajes flash utilizando app.flashes().

```twig
{# app/Resources/views/base.html.twig #}

{# Podemos recuperar solamente un tipo de mensajes #}
{% for message in app.flashes('notice') %}
    <div class="flash-notice">
        {{ message }}
    </div>
{% endfor %}

{# ...o recuperarlos todos #}
{% for label, messages in app.flashes %}
    {% for message in messages %}
        <div class="flash-{{ label }}">
            {{ message }}
        </div>
    {% endfor %}
{% endfor %}
```


NOTA: La función app.flashes() de Twig ha sido introducida en Symfony 3.3. Antes
había que utilizar app.session.flashBag().

NOTA: Es muy común utilizar tres claves de mensajes flash: *notice*, *warning* y *error*, 
pero realmente podemos utilizar los que queramos sin ningún problema.

NOTA: Existe el método peek() para obtener los mensajes SIN ELIMINARLOS de la sesión.

  ```twig
  {% for message in app.peek('notice') %}
  ```



https://symfony.com/doc/current/controller.html