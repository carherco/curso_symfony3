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

- @ORM\Entity:
    Sirve para inidcar que esta clase es una entidad de Doctrine. 
- @ORM\Table: 
    Opcional. Sirve para indicar el nombre de la tabla en la base de datos. Si 
    no se pone, la tabla se llamará igual que la clase.
- @ORM\Column: 
    Mapea una propiedad de la clase con una colunma de la tabla.
- @ORM\Id
    Se utilizar para marcar el campo que será el primary key de la tabla. En 
    doctrine es obligatorio que una entidad tenga un campo primary key.

    Si la primary key es conjunta, hay que poner @ORM\Id en cada uno de los campos
    que componen dicha primary key.
- @ORM\GeneratedValue: 
    Se utiliza en los campos primary key para indicar cuál va a ser la 
    estrategia para generar para generar los valores de este campo.

    Si es una clave formada por más de un campo, no se puede utilizar @ORM\GeneratedValue


http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html

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

The first step towards building entity classes from an existing database is to 
ask Doctrine to introspect the database and generate the corresponding metadata 
files. Metadata files describe the entity class to generate based on table fields.

> php bin/console doctrine:mapping:import --force AppBundle xml

This command line tool asks Doctrine to introspect the database and generate the 
XML metadata files under the src/AppBundle/Resources/config/doctrine folder of 
your bundle. This generates two files: BlogPost.orm.xml and BlogComment.orm.xml.

Once the metadata files are generated, you can ask Doctrine to build related 
entity classes by executing the following command.

// generates entity classes with annotation mappings
> php bin/console doctrine:mapping:convert annotation ./src


Eliminar el xml o yml generado con el primer comando. 
If you want to use annotations, you must remove the XML (or YAML) files after 
running this command. This is necessary as it is not possible to mix mapping 
configuration formats

https://symfony.com/doc/current/doctrine/reverse_engineering.html


Validar las entidades
---------------------

> bin/console doctrine:schema:validate


https://symfony.com/doc/current/doctrine.html




Persistir objetos en la base de datos (INSERT)
----------------------------------------------

Utilizamos el objeto EntityManager para persistir objetos en la base de datos.


```php
public function createAction()
{
    // Podemos obtener el EntityManager a través de $this->getDoctrine()
    // o con inyección de dependencias: createAction(EntityManagerInterface $em)
    $em = $this->getDoctrine()->getManager();

    $grado = new Grado();
    $grado->setNombre('Ingeniería de montes');

    // Informamos a Doctrine de que queremos guardar the Product (todavía no se ejecuta ninguna query)
    $em->persist($grado);

    // Para ejecutar las queries pendientes, se utiliza flush().
    $em->flush();

    return new Response('El id del nuevo grado creado es '.$grado->getId());

}
```

Si tenemos definidas varias conexciones, podemos instanciar un objeto 
EntityManager para cada una de las conexiones.

```php
$doctrine = $this->getDoctrine();
$em = $doctrine->getManager();
$em2 = $doctrine->getManager('other_connection');
```

Recuperar objetos de la base de datos (SELECT)
----------------------------------------------

```php
public function showAction($productId)
{
    $grado = $this->getDoctrine()
        ->getRepository(Grado::class)
        ->find($gradoId);

    if (!$grado) {
        throw $this->createNotFoundException(
            'No se ha encontrado ningún grado con el id '.$gradoId
        );
    }

}
```

Las clases Repository
---------------------

La clase Repository nos ofrece varios métodos muy útiles para obtener registros de la base de datos:

- find
- findOneByXXX
- findByXXX
- findAll
- findOneBy
- findBy


```php
$repository = $this->getDoctrine()->getRepository(Grado::class);

// Obtener un grado buscando por su primary key (normalmente "id")
$grado = $repository->find($gradoId);

// Métodos dinámicos para obtener un grado buscando por el valor de una columna
$grado = $repository->findOneById($productId);
$grado = $repository->findOneByNombre('Ingeniería de montes');

// Métodos dinámicos para obtener un array de objetos grado buscando por el valor de una columna
$grados = $repository->findByNombre('Ingeniería de montes');

// Obtener todos los grados
$grados = $repository->findAll();
```


```php
$repository = $this->getDoctrine()->getRepository(Product::class);

// query for a single product matching the given name and price
$product = $repository->findOneBy(
    array('name' => 'Keyboard', 'price' => 19.99)
);

// query for multiple products matching the given name, ordered by price
$products = $repository->findBy(
    array('name' => 'Keyboard'),
    array('price' => 'ASC')
);
```

La barra de depuración
----------------------

Podemos consultar en la barra de depuración todas las SQLs ejecutadas, así como 
el tiempo y la memoria consumidos con cada petición.

Haciendo click en el icono de la base de datos vemos toda la información detallada.


Editar un objeto (UPDATE)
-------------------------


Eliminar un objeto (DELETE)
---------------------------



El lenguaje DQL (Doctrine Query Language)
-----------------------------------------



El objeto QueryBuilder
----------------------


Buenas Prácticas: Las consultas sql se deben realizar en la clase Repository
----------------------------------------------------------------------------

https://symfony.com/doc/current/doctrine/repository.html



Configuración de doctrine
-------------------------

Doctrine es altamente configurable. Es esta página se pueden consultar todas las 
opciones de configuración

https://symfony.com/doc/current/reference/configuration/doctrine.html







https://symfony.com/doc/current/doctrine#creating-an-entity-class