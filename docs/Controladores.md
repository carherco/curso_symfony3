Controladores
=============

En Symfony un controlador es una función PHP que creamos para leer información del 
objeto Request de Symfony y crear y devolver un objeto Response.

La respuesta puede ser una página HTML, JSON, XML, una descarga de un fichero, 
una redirección, un error 404...

El controlador exucta cualquier código que necesitemos para renderizar el contenido
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
    return $this->redirectToRoute('blog_show', array('slug' => 'my-page'));

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
public function indexAction($id)
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
    $page = $request->query->get('page', 1);

    // ...
}
```

https://symfony.com/doc/current/controller.html#request-object-info


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
}
```

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


NOTA: The app.flashes() Twig function was introduced in Symfony 3.3. Prior, you had to use app.session.flashBag().

NOTA: It's common to use notice, warning and error as the keys of the different types of flash messages, but you can use any key that fits your needs.

NOTA: You can use the peek() method instead to retrieve the message while keeping it in the bag.

Voy por aquí
https://symfony.com/doc/current/controller.html#the-request-and-response-object