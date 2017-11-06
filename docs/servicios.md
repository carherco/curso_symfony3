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







https://symfony.com/doc/current/service_container.html#services-constructor-injection
https://symfony.com/doc/current/service_container/3.3-di-changes.html