Seguridad - Autenticación
=========================

El sistema de seguridad de symfony es muy potente, pero también puede llegar a 
ser muy confuso.

La seguridad se configura en el archivo security.yml. Por defecto, tiene el siguiente
aspecto:

```yml
# app/config/security.yml
security:
    providers:
        in_memory:
            memory: ~

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            anonymous: ~
```

Vamos a empezar con un ejemplo básico de seguridad: Vamos a limitar el acceso
a algunas páginas de nuestra aplicación y a pedir autenticación básica HTTP.

```yml
security:
    providers:
        in_memory:
            memory: ~

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            anonymous: ~
            http_basic: ~
            
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/alumno, roles: ROLE_ADMIN }
        - { path: ^/asignatura, roles: ROLE_ADMIN }
```

En la sección access_control, restringimos el acceso a determinadas rutas de forma
que únicamente puedan acceder aquellos usuarios con un rol determinado. 

En el ejemplo anterior, solamente los usuarios con rol ROLE_ADMIN pueden acceder
a las rutas que empiezan por /admin, /alumno y /asignatura

Si un usuarios intenta entrar en dichas páginas y no tiene acceso, se le mostrará
el formulario de login HTTP básico.

En la sección providers, configuramos el sistema o sistemas proveedores de usuarios.
Vamos a ver un ejemplo sencillo del proveedor *in_memory*.

```yml
    providers:
        in_memory:
            memory:
                users:
                    carlos:
                        password: pass
                        roles: 'ROLE_USER'
                    admin:
                        password: word
                        roles: 'ROLE_ADMIN'
```

Este proveedor tiene dos usuarios:
- usuario: carlos, contraseña: pass, con rol ROLE_USER
- usuario: admin, contraseña: word, con rol ROLE_ADMIN


Ya solamente falta informar al sistema de seguridad de cual es el algoritmo 
utilizado para codificar las contraseñas. Como en este caso las contraseñas están 
sin codificar, indicaremos que el algoitmo es *plaintext*.

    encoders:
        Symfony\Component\Security\Core\User\User: plaintext


Ya podemos probar el login.

Si probamos a entrar en */asignaturas* con el usuario *carlos* veremos que nos 
aparece un error HTTP 403 Forbidden. Es lo esperado, ya que el usuario *carlos*
no tiene permisos para acceder a esa página.

Podemos observar también que en la barra de depuración aparece el nombre de usuario y 
en el profiler, información detallada de los aspectos de seguridad de esta petición.

Si probamos a entrar en */asignaturas* con el usuario *admin* veremos que sí que nos deja acceder


Cambiar el algotimo de codificación de contraseñas
--------------------------------------------------

Vamos a cambiar el algotimo de codificación de contraseñas de texto plano a *bcrypt*.
```yml
    encoders:
        Symfony\Component\Security\Core\User\User:
            algorithm: bcrypt
            cost: 12
```






Entity Provider
---------------

https://symfony.com/doc/current/security/entity_provider.html


Configurar múltiples providers
------------------------------


Autenticación con formulario de login
-------------------------------------

https://symfony.com/doc/current/security/form_login_setup.html

Autenticación con LDAP
----------------------


https://symfony.com/doc/current/security/ldap.html
https://github.com/ldaptools/ldaptools-bundle
https://github.com/ldaptools/ldaptools-bundle/blob/master/Resources/doc/LDAP-Authentication-Provider.md#mapping-ldap-groups-to-roles
https://github.com/ldaptools/ldaptools-bundle/blob/master/Resources/doc/LDAP-Authentication-Provider.md#load-user-events


Seguridad - Autorización
========================

El proceso de autorización tiene dos vertientes diferentes:
The process of authorization has two different sides:

1) Al hacer login, el usuario recive un conjunto específico de roles (por 
ejemplo: ROLE_ADMIN).

2) Añadir código para que un recurso requiera un *atributo* específico (un rol 
u otro tipo de atributo) para acceder a dicho recurso

Los roles deben empezar con el prefijo *ROLE_*.

Un usuario autenticado debe de tener al menos un rol.


Es posible establecer una jerarquía de roles:

```yml
security:
    # ...

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
```

Añadir código para denegar el acceso a un recurso puede hacerse bien mediante
la sección *access_control* del security.yml o bien a través del servicio 
*security.authorization_checker*.

En el access control, además de la url, se puede configurar accesos por IP, host name o métodos HTTP.
También se puede utilizar la sección *access_control* para redireccionar al usuario
al protocolo *https*

```yml
security:
    # ...
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN, ip: 127.0.0.1 }
        - { path: ^/admin, roles: ROLE_ADMIN, host: symfony\.com$ }
        - { path: ^/admin, roles: ROLE_ADMIN, methods: [POST, PUT] }
        - { path: ^/admin, roles: ROLE_ADMIN }
```


Primero Symfony búsca el match correspondiente según las coincidencias de:
  - path
  - ip
  - host
  - methods

Una vez vista cuál es la coincidencia, permite o deniega el acceso, según se 
cumplan las condiciones de
  - roles: si el usuario no tiene este rol, se le deniega el acceso
  - allow_if: si la expresión evaluada devuelve *false* se le deniega el acceso

    ```yml
    security:
        # ...
        access_control:
            -
                path: ^/_internal/secure
                allow_if: "'127.0.0.1' == request.getClientIp() or has_role('ROLE_ADMIN')"
    ```



  - requires_channel: si el protocolo (canal) de la petición no coincide con el indicado, se le redirige al indicado.

    ```yml
    security:
        # ...
        access_control:
            - { path: ^/cart/checkout, roles: IS_AUTHENTICATED_ANONYMOUSLY, requires_channel: https }
    ```


Si el acceso resulta denegado y el usuario no está autenticado, se le redirige al
sistema de autenticación cofigurado. 

Si el acceso resulta denegado y ya estaba autenticado, se le muestra una página de 403 acceso denegado 
https://symfony.com/doc/current/security/access_control.html



La forma de añadir código de denegación de acceso a través del servicio *security.authorization_checker*
son las siguientes:

A) En los controladores:

```php
public function helloAction($name)
{
    // The second parameter is used to specify on what object the role is tested.
    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

    // Old way :
    // if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
    //     throw $this->createAccessDeniedException('Unable to access this page!');
    // }

    // ...
}
```

Gracias al bundle SensioFrameworkExtraBundle, se puede hacer lo mismo con anotaciones:

```php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
public function helloAction($name)
{
    // ...
}
```

https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html

B) En las plantillas

```yml
{% if is_granted('ROLE_ADMIN') %}
    <a href="...">Delete</a>
{% endif %}
```

C) En los servicios

```php
// src/AppBundle/Newsletter/NewsletterManager.php

// ...
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class NewsletterManager
{
    protected $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function sendNewsletter()
    {
        if (!$this->authorizationChecker->isGranted('ROLE_NEWSLETTER_ADMIN')) {
            throw new AccessDeniedException();
        }

        // ...
    }

    // ...
}
```

Si el usuario no tiene el rol ROLE_NEWSLETTER_ADMIN, se le pedirá que haga login.



Los pseudo-roles
----------------

Symfony tiene 3 pseudo-roles (atributos), que no son roles, pero actúan como si lo fueran:

- IS_AUTHENTICATED_ANONYMOUSLY: Todos los usuarios tienen este atributo, estén logeados o no
- IS_AUTHENTICATED_REMEMBERED: Todos los usuarios logeados tienen este atributo
- IS_AUTHENTICATED_FULLY: Todos los usuarios logeados excepto los que están logeados a través de una "remember me cookie".


Access Control Lists (ACLs)
---------------------------

Symfony tiene un sistema de cofiguración de ACLs que no veremos en este curso.

https://symfony.com/doc/current/security/acl.html


Voters
------

Como alternativa a los sistemas de ACL, symonfy dispone de los voters. Los voters
permiten programar cualquier tipo de lógica para permitir o denegar accesos.



El objeto User
==============

Tras la autenticación, el objeto User asociado al usuario actual se puede obtener 
a través del servicio *security.token_storage*.

En un controlador, podemos tener acceso fácilmente al objeto User

```php
use Symfony\Component\Security\Core\User\UserInterface;

public function indexAction()
{
    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
    }

    $user = $this->get('security.token_storage')->getToken()->getUser();

    //...
}
```

o bien

```php
use Symfony\Component\Security\Core\User\UserInterface;

public function indexAction(UserInterface $user)
{
    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
    }

    //...
}
```

De qué tipo de clase sea nuestro objeto *$user* dependerá de nuestro *user provider*.


Si nuestra clase controladora extiende de Controller se puede acceder también al 
usuario con $this->getUser().

```php
use Symfony\Component\Security\Core\User\UserInterface;

public function indexAction()
{
    if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        throw $this->createAccessDeniedException();
    }

    $user = $this->getUser();
    
    //...
}
```

En twig, podemos acceder al objeto user con app.user

```twig
{% if is_granted('IS_AUTHENTICATED_FULLY') %}
    <p>Username: {{ app.user.username }}</p>
{% endif %}
```


Logout
======

EL logout no es necesario programarlo, solamente configurarlo.

Primero definimos una ruta de logout en el firewall:

```yml
# app/config/security.yml
security:
    # ...

    firewalls:
        main:
            # ...
            logout:
                path:   /logout
                target: /
```

Y añadimos la ruta al routing

```yml
# app/config/routing.yml
logout:
    path: /logout
```

Pero NO hay que crear ningún controlador que haga nada.

Cuando un usuario acceda a la url */logout* symfony le deslogueará y le redirigirá
a la url definida en *target*, en este caso le redirigirá a */*

https://symfony.com/doc/current/reference/configuration/security.html