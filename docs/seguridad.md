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


Cambiar el algoritmo de codificación de contraseñas
--------------------------------------------------

Vamos a cambiar el algotimo de codificación de contraseñas de texto plano a *bcrypt*.
```yml
    encoders:
        Symfony\Component\Security\Core\User\User:
            algorithm: bcrypt
            cost: 12
```

Existe un comando en symfony que codifica una contraseña utilizando el algoritmo 
configurado:

> bin/console security:encode-password



Entity Provider
---------------

Vamos ahora a cabmiar el provider in_memory por uno de base de datos:

Lo primero que necesitamos es nuestra entidad de usuarios

```php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        // si necesitáramos un "salt" podríamos hacer algo así
        // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // El método es necesario aunque no utilicemos un "salt"
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
```

Y ahora actulizamos la base de datos:

> php bin/console doctrine:schema:update --force


Una clase *User* debe implementar las interfaces UserInterface y Serializable.

Como consecuencia de implementar la interfaz UserInterface tenemos que crear los
siguientes métodos:

- getRoles()
- getPassword()
- getSalt()
- getUsername()
- eraseCredentials()

Y como consecuencia de implementar Serializable, tenemos que crear los siguientes
métodos:

- serialize()
- unserialize()

Al final de cada petición el objeto User es serializado y metido en la sesión. En
la siguiente petición, se deserializa. Symfony hace dichas operaciones llamando 
a los métodos serialize y unserialize.


Ya solamente queda configurar el security.yml para que utilice un provider basado
en nuestra entidad

```yml
# app/config/security.yml
security:
    encoders:
        AppBundle\Entity\User:
            algorithm: bcrypt

    # ...

    providers:
        mi_poveedor:
            entity:
                class: AppBundle:User
                property: username

    firewalls:
        main:
            pattern:    ^/
            http_basic: ~
            provider: mi_poveedor

    # ...
```


AdvancedUserInterface
---------------------

En vez de extender de UserInterface, podemos extender de AdvancedUserInterface.
Para ello tenemos que definir los siguientes métodos:




```php
// src/AppBundle/Entity/User.php

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
// ...

class User implements AdvancedUserInterface, \Serializable
{
    // ...

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            // ...
            $this->isActive
        ));
    }
    public function unserialize($serialized)
    {
        list (
            // ...
            $this->isActive
        ) = unserialize($serialized);
    }
}
```


- isAccountNonExpired(): comprueba si la cuenta de usuario ha caducado
- isAccountNonLocked(): comprueba si el usuario está bloquedado
- isCredentialsNonExpired() comprueba si la contraseña ha caducado;
- isEnabled() comprueba si el usuario está habilitado.

Si cualquiera de estos métodos devuelve false, el usuario no podrá hacer login.
Según cuál de estos métodos devuelva falso, Symfony generará un mensaje diferente.

```php
// src/AppBundle/Entity/User.php

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
// ...

class User implements AdvancedUserInterface, \Serializable
{
    // ...

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            // ...
            $this->isActive
        ));
    }
    public function unserialize($serialized)
    {
        list (
            // ...
            $this->isActive
        ) = unserialize($serialized);
    }
}
```



https://symfony.com/doc/current/security/entity_provider.html


Configurar múltiples providers
------------------------------

Es posible configurar múltiples providers. En caso de que un firewall no especifique
qué provider va a utilizar, utilizará el primero de ellos.

```yml
# app/config/security.yml
security:
    providers:
        chain_provider:
            chain:
                providers: [in_memory, user_db]
        in_memory:
            memory:
                users:
                    foo: { password: test }
        user_db:
            entity: { class: AppBundle\Entity\User, property: username }

    firewalls:
        secured_area:
            # ...
            pattern: ^/
            provider: user_db
            form_login: ~
```

https://symfony.com/doc/current/security/multiple_user_providers.html

Autenticación con formulario de login
-------------------------------------

Vamos a cambiar ahora el método de login http_basic por un formulario de login.

```yml
# app/config/security.yml
security:
    # ...

    firewalls:
        main:
            anonymous: ~
            form_login:
                login_path: login
                check_path: login
                default_target_path: after_login_route_name
                always_use_default_target_path: true
```

Con esto decimos a symfony que vamos a utilizar un formulario de login, y que 
rediriga a la ruta de nombre "login" cuando sea necesario identificar a un usuario.

Los siguiente es crear una acción y una plantilla para esa ruta:

```php
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

public function loginAction(Request $request, AuthenticationUtils $authUtils)
{
    // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
}
```

```yml
{% if error %}
    <div>{{ error.messageData }}</div>
{% endif %}

<form action="{{ path('login') }}" method="post">
    <label for="username">Usuario:</label>
    <input type="text" id="username" name="_username" value="{{ last_username }}" />

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="_password" />

    {#
        Si queremos controlar la url a la que se redirigirá el usuario después de hacer login
        <input type="hidden" name="_target_path" value="/account" />
    #}

    <button type="submit">Login</button>
</form>
```


https://symfony.com/doc/current/security/form_login_setup.html

Autenticación con LDAP
----------------------

Symfony viene con un servicio de LDAP que se puede configurar para gestionar 
conexiones con un LDAP:

```yml
# app/config/services.yml
services:
    Symfony\Component\Ldap\Ldap:
        arguments: ['@Symfony\Component\Ldap\Adapter\ExtLdap\Adapter']
    Symfony\Component\Ldap\Adapter\ExtLdap\Adapter:
        arguments:
            -   host: my-server
                port: 389
                encryption: tls
                options:
                    protocol_version: 3
                    referrals: false
```

Después de configurar el servicio, podemos configurar un provider que utilice
dicho servicio:

```yml
# app/config/security.yml
security:
    # ...

    providers:
        my_ldap:
            ldap:
                service: Symfony\Component\Ldap\Ldap
                base_dn: dc=example,dc=com
                search_dn: "cn=read-only-admin,dc=example,dc=com"
                search_password: password
                default_roles: ROLE_USER
                uid_key: uid
```

Y un método http_basic_ldap para hacer login

```yml
# app/config/security.yml
security:
    # ...

    firewalls:
        main:
            # ...
            http_basic_ldap:
                # ...
                service: Symfony\Component\Ldap\Ldap
                dn_string: 'uid={username},dc=example,dc=com'
```

o un método form_basic_ldap

```yml
# app/config/security.yml
security:
    # ...

    firewalls:
        main:
            # ...
            form_login_ldap:
                # ...
                service: Symfony\Component\Ldap\Ldap
                dn_string: 'uid={username},dc=example,dc=com'
```

Y con esto ya deberíamos ser capaces de hacer login.


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
 * @Security("is_granted('ROLE_ADMIN')")
 */
public function helloAction($name)
{
    // ...
}
```

Incluso se puede poner a nivel de la clase controladora

```php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/asignaturas")
 */
class AsignaturasController extends Controller
{
  
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


https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/annotations/security.html


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

[Documentación sobre Voters](voters.md)


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

https://symfony.com/doc/current/security.html
https://symfony.com/doc/current/reference/configuration/security.html