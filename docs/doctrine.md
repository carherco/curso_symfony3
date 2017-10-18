Doctrine ORM
============

El framework symfony no incluye ningún componente para trabajar con bases de datos. 
Sin embargo proporciona integración con una librería llamada Doctrine. 

NOTA: 
Doctrine ORM está totalmente desacoplado de Symfony y no es obligatorio utilizarlo. 
Permite mapear objetos a una base de datos relacional (como MySQL, PostgreSQL o 
Microsoft SQL).

Si lo que se quiere es ejecutar consultas en bruto a la base de datos, se puede 
utilizar Doctrine DBAL

https://symfony.com/doc/current/doctrine/dbal.html

También se pueden utilizar bases de datos no relacionales como MongoDB.

http://symfony.com/doc/master/bundles/DoctrineMongoDBBundle/index.html

You can also persist data to MongoDB using Doctrine ODM library. For more 
information, read the "DoctrineMongoDBBundle" documentation.


Configurar el acceso a la base de datos
---------------------------------------

En app/config/parameters.yml

```yml
parameters:
    database_driver: pdo_mysql
    database_host: 127.0.0.1
    database_port: 8889
    database_name: curso_symfony
    database_user: root
    database_password: root
```

En app/config/config.yml

```yml
doctrine:
    dbal:
        driver:   "%database_driver%"
        host:     "%database_host%"
        port:     "%database_port%"
        dbname:   "%database_name%"
        user:     "%database_user%"
        password: "%database_password%"
        charset:  UTF8
```

Crear la base de datos
----------------------

Podemos crear la base de datos a mano, o utilizar la consola de symfony:

> bin/console doctrine:database:create



Crear las entidades
-------------------

Aquí igual, podemos crear a mano las entidades, o utilizar la consola de symfony. 
Una entidad no es más que una clase decorada con decoradores de Doctrine.

> bin/console doctrine:generate:entity

Las entidades se guardan generalmente en el directorio Entity del Bundle.

```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grado
 *
 * @ORM\Table(name="grado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GradoRepository")
 */
class Grado
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Grado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
```

La entidad es una clase típica con atributos privados y getters y setters públicos, 
pero decorada con decoradores de PHPDocumentor y de Doctrine.

Todos los decoradores que comienzan con @ORM son de doctrine y se utilizan para 
mapear la entidad con la base de datos.

- @ORM\Table
- @ORM\Entity
- @ORM\Column
- @ORM\Id
- @ORM\GeneratedValue

El resto de decoradores son para PHPDocumentor y se utilizan para la documentación de la clase.

Además de la clase/entidad Grado, se crea una clase adicional GradoRepository 
cuya utilidad veremos más adelante.


El comando doctrine:schema:update
---------------------------------

El comando doctrine:schema:update permite actualizar la estructura de la base de 
datos.

bin/console doctrine:schema:update --dump-sql

Muestra las operaciones SQL que se realizarán sobre la base de datos.

bin/console doctrine:schema:update --force

Realiza en la base de datos las operaciones SQL necesarias para que la base de datos
se corresponda con las entidades de doctrine.


Si en el futuro se modifica cualquier entidad, este comando realizará los cambios 
necesarios en la base de datos.

Se puede intuir ya que en un proyecto symfony, NO se construye la base de datos directamente
en la base de datos, sino que se construye a través de doctrine.


Ingeniería inversa con doctrine
-------------------------------

https://symfony.com/doc/current/doctrine/reverse_engineering.html


Validar las entidades
---------------------

> bin/console doctrine:schema:validate


https://symfony.com/doc/current/doctrine.html