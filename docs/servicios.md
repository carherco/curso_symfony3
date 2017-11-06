Servicios
=========

Una aplicación está llena de objetos útiles: Un objeto "Mailer" es útil para 
enviar correos, el "EntityManager" para hacer operaciones con las entidades de 
Doctrine...

En Symfony, estos "objetos útiles" se llaman servicios, y viven dentro de un objeto
especial llamado **contenedor de servicios**. A través del contenedor de servicios
podemos obtener cualquier servicio utilizando su identificador.

```php
$logger = $container->get('logger');
$entityManager = $container->get('doctrine.orm.entity_manager');
```

En un controlador, *$this->get()* es un alias de *$this->container->get()*.

Para poder utilizar el contenedor de servicios de esta forma, nuestra clase controladora debe
extender de Controller. Si extiende de AbstractController, no podemos utilizarlo.

Existe un comando que nos proporciona la lista de servicios disponibles en el 
contenedor de servicios, con sus identificadores:

> bin/console debug:container

A partir de Symfony 3.3, el contenedor de servicios también actúa cuando tipamos 
la clase en un parámetro de entrada de un controlador o de un constructor.

```php
public function indexAction(Doctrine\ORM\EntityManagerInterface $em)
{
    
}
```

Existe una versión del comando anterior, que nos indica los tipos de los servicios:

> bin/console debug:container --types


NOTA: El contenedor de dependecias utiliza la técnica de *lazy-loading*: no instancia
un servicio hasta que se pide dicho servicio. Si no se pide, no se instancia.

NOTA: Un servicio se crea una única vez. Si en varias partes de la aplicación se le pide 
a Symfony un mismo servicio, Symfony devolverá siempre la misma instancia del servicio.


El fichero services.yml
-----------------------

```yml
# app/config/services.yml
services:
    # default configuration for services in *this* file
    _defaults:
        # Habilita el tipado de argumentos en los métodos constructores de los servicios
        autowire: true
        # Con autoconfigure true no es necesario poner tags a los servicos. Symfony las averigua por las interfaces que implementan.
        autoconfigure: true
        # Solamente se pueden obtener servicios con $container->get() si son públicos
        public: false

    # makes classes in src/AppBundle available to be used as services
    AppBundle\:
        resource: '../../src/AppBundle/*'
        # you can exclude directories or files
        # but if a service is unused, it's removed anyway
        exclude: '../../src/AppBundle/{Entity,Repository}'
```

autowire
--------

Habilita el tipado de argumentos en los métodos constructores de los servicios



arguments
---------

Cuando un servicio necesita argumentos que no son instancias de clases sino que 
son valores (como un host, un username un password, etc) no queda más remedio que
declarar el servicio y establecer los valores de los argumentos

```yml
    Symfony\Component\Ldap\Ldap:
        arguments: ['@Symfony\Component\Ldap\Adapter\ExtLdap\Adapter']
        
    Symfony\Component\Ldap\Adapter\ExtLdap\Adapter:
        arguments:
            -   host: 138.100.191.229
                port: 636
                encryption: ssl
                options:
                    protocol_version: 3
                    referrals: false
```

public
------

Solamente se pueden obtener servicios con $container->get() si dichos servicios
son públicos.

tags
----

A algunos servicios hay que etiquetarlos para que symfony sepa donde van a ser 
utilizados dentro del framework. 

Por ejemplo: para crear una extensión de Twig, necesitamos crear una clase, registrarla
como servicio y etiquetarla con *twig.extension.

Otro ejemplo: para crear un voter, hay que crear una clase, registrarla como servicio
y etiquetarla con *security.voter*.

```yml
    AppBundle\Twig\MyTwigExtension:
        tags: [twig.extension]
```

```yml
    app.post_voter:
        class: AppBundle\Security\EditarEventoVoter
        tags:
            - { name: security.voter }
        public: false
```

autoconfigure
-------------

Con autoconfigure true no es necesario poner tags a los servicos. Symfony las 
averigua por las interfaces que implementan.

En los ejemplos anteriores, Symfony sabría que el servicio *MyTwigExtension* es una extensión de 
Twig porque la clase implemente *Twig_ExtensionInterface* y que el servico *app.post_voter*
es un voter porque la clase implementa *VoterInterface*.


resource y exclude
------------------

La clave *resource* se utiliza para registrar de forma rápida como servicios 
todas las clases dentro de un directorio. El id de cada servicio es su 
fully-qualified class name.

La clave *exclude* se utiliza para excluir directorios. 

```yml
    AppBundle\:
        resource: '../../src/AppBundle/*'
        exclude: '../../src/AppBundle/{Entity,Repository}'
```


Registrar varios servicios con la misma clase
---------------------------------------------

Es posible registrar varios servicios distintos que utilicen la misma clase. Basta
con ponerles identificadores distintos.

```yml
services:

    site_update_manager.superadmin:
        class: AppBundle\Updates\SiteUpdateManager
        # you CAN still use autowiring: we just want to show what it looks like without
        autowire: false
        # manually wire all arguments
        arguments:
            - '@AppBundle\Service\MessageGenerator'
            - '@mailer'
            - 'superadmin@example.com'

    site_update_manager.normal_users:
        class: AppBundle\Updates\SiteUpdateManager
        autowire: false
        arguments:
            - '@AppBundle\Service\MessageGenerator'
            - '@mailer'
            - 'contact@example.com'

    # Create an alias, so that - by default - if you type-hint SiteUpdateManager,
    # the site_update_manager.superadmin will be used
    AppBundle\Updates\SiteUpdateManager: '@site_update_manager.superadmin'
```

https://symfony.com/doc/current/service_container.html