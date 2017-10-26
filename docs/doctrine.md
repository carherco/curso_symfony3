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

Aquí igual: podemos crear a mano las entidades, o utilizar la consola de symfony. 
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
- @ORM\Id:
    Se utiliza para marcar el campo que será el primary key de la tabla. En 
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

El comando *doctrine:schema:update* permite actualizar la estructura de la base de 
datos.

> bin/console doctrine:schema:update --dump-sql

Muestra las operaciones SQL que se realizarán sobre la base de datos.

> bin/console doctrine:schema:update --force

Realiza en la base de datos las operaciones SQL necesarias para que la base de datos
se corresponda con las entidades de doctrine.


Si en el futuro se modifica cualquier entidad, este comando realizará los cambios 
necesarios en la base de datos.

Se puede intuir ya que en un proyecto symfony, NO se construye la base de datos directamente
en la base de datos, sino que se construye a través de doctrine.


Ingeniería inversa con doctrine
-------------------------------

El primer paso para construir las clases de entidad a partir de una base de datos
existente, es pedir a doctrine que inspeccione la base de datos y genere los 
correspondiente archivos de metadatos. Los archivos de metadatos describen las 
entidades que se deben generar a partir de los campos de las tablas:

> php bin/console doctrine:mapping:import --force AppBundle xml

Los archivos de metadatos se generan en la carpeta src/AppBundle/Resources/config/doctrine. 

Una vez que se han generado estos archivos de metadatos, se le puede pedir a doctrine
que genere las clases de entidad ejecutando el siguiente comando.

> php bin/console doctrine:mapping:convert annotation ./src

Ya solamente queda eliminar los ficheros de metadatos generados por el primer comando.

https://symfony.com/doc/current/doctrine/reverse_engineering.html



Validar las entidades
---------------------

Otro comando interesante es *doctrine:schema:validate* que valida las entidades.

> bin/console doctrine:schema:validate


Operaciones de INSERT, SELECT, UPDATE y DELETE
==============================================


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

    // Informamos a Doctrine de que queremos guardar el Grado (todavía no se ejecuta ninguna query)
    $em->persist($grado);

    // Para ejecutar las queries pendientes, se utiliza flush().
    $em->flush();

    return new Response('El id del nuevo grado creado es '.$grado->getId());

}
```

Si tenemos definidas varias conexiones, podemos instanciar un objeto 
EntityManager para cada una de las conexiones.

```php
$doctrine = $this->getDoctrine();
$em = $doctrine->getManager();
$em2 = $doctrine->getManager('other_connection');
```

Configurar varias conexiones es muy sencillo:

```yml
# app/config/config.yml
doctrine:
    dbal:
        default_connection:   default
        connections:
            # A collection of different named connections (e.g. default, conn2, etc)
            default:
                dbname:               bd1
                host:                 10.0.1.6
                port:                 ~
                user:                 root
                password:             ~
                charset:              ~
                path:                 ~
                memory:               ~
            other_connection:
                dbname:               bd2
                host:                 10.0.1.7
                port:                 ~
                user:                 root
                password:             ~
                charset:              ~
                path:                 ~
                memory:               ~
```



Recuperar objetos de la base de datos (SELECT)
----------------------------------------------

```php
public function showAction($id)
{
    $grado = $this->getDoctrine()
        ->getRepository(Grado::class)
        ->find($id);

    if (!$grado) {
        throw $this->createNotFoundException(
            'No se ha encontrado ningún grado con el id '.$id
        );
    }

}
```

Las clases Repository
---------------------

La clase Repository nos ofrece automáticamente varios métodos muy útiles para obtener registros de la base de datos:

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
$grado = $repository->findOneById($gradoId);
$grado = $repository->findOneByNombre('Ingeniería de montes');

// Métodos dinámicos para obtener un array de objetos grado buscando por el valor de una columna
$grados = $repository->findByNombre('Ingeniería de montes');

// Obtener todos los grados
$grados = $repository->findAll();
```


```php
$repository = $this->getDoctrine()->getRepository(Asignatura::class);

// query for a single product matching the given name and price
$product = $repository->findOneBy(
    array('nombre' => 'montes', 'credects' => 6)
);

// query for multiple products matching the given name, ordered by price
$products = $repository->findBy(
    array('nombre' => 'matematicas'),
    array('credects' => 'ASC')
);
```

Estos métodos realizan búsquedas exactas (con el operador '='). Si queremos 
realizar búsquedas con el operador LIKE, tenemos que recurrir al lenguaje DQL o 
al objeto QueryBuilder que veremos más adelante.
 

La barra de depuración
----------------------

Podemos consultar en la barra de depuración todas las SQLs ejecutadas, así como 
el tiempo y la memoria consumidos con cada petición.

Haciendo click en el icono de la base de datos vemos toda la información detallada.


Editar un objeto (UPDATE)
-------------------------

Editar un registro es igual de fácil que crearlo, simplemente en vez de hacer un 
new, partimos de un registro ya existente obtenido de la base de datos.

```php
public function showAction($id, EntityManagerInterface $em)
{
    $grado = $this->getDoctrine()->getRepository(Grado::class)->find($id);

    $grado->setNombre('otro nombre');

    $em->persist($grado);
    $em->flush();
    ...
}
```

Eliminar un objeto (DELETE)
---------------------------

Para eliminar un registro utilizamos el método remove() del EntityManager.

```php
public function showAction($id, EntityManagerInterface $em)
{
    $grado = $this->getDoctrine()->getRepository(Grado::class)->find($id);

    $em->remove($grado);
    $em->flush();
    ...
}
```

Relaciones entre entidades
==========================

https://symfony.com/doc/current/doctrine/associations.html

Las entidades Asignatura y Grado están relacionadas. Un asignatura pertenece a 
un grado y un grado tiene muchas asignaturas.

Desde la perspectiva de la entidad Asignatura, es una relación *many-to-one*. 
Desde la perspectiva de la entidad Grado, es una relación *one-to-many*.

La naturaleza de la relación determina qué metadatos de mapeo se van a utilizar. 
También determina qué entidad contendrá una referencia a la otra entidad

Para relacionar las entidades Asignatura y Grado, simplemente creamos una propiedad
*grado* en la entidad Asignatura con las anotaciones que vemos a continuación:

```php
class Asignatura
{
    // ...

    /**
     * @ORM\ManyToOne(targetEntity="Grado", inversedBy="asignaturas")
     * @ORM\JoinColumn(name="grado_id", referencedColumnName="id")
     */
    private $grado;
}
```

This many-to-one mapping is critical. It tells Doctrine to use the category_id 
column on the product table to relate each record in that table with a record in the category table.

Next, since a single Category object will relate to many Product objects, a 
products property can be added to the Category class to hold those associated objects.

```php
use Doctrine\Common\Collections\ArrayCollection;

class Grado
{
    // ...

    /**
     * @ORM\OneToMany(targetEntity="Asignatura", mappedBy="grado")
     */
    private $asignaturas;

    public function __construct()
    {
        $this->asignaturas = new ArrayCollection();
    }
}
```

La asociación many-to-one es obligatoria, pero la one-to-may es opcional.

El código en el constructor es importante. En lugar de ser instanciado como un 
array tradicional, la propiedad $asignaturas debe ser de un tipo que implemente
la interface *DoctrineCollection*. El objeto ArrayCollection es de este tipo.

El objeto *ArrayCollection* parece y se comporta casi exactamente como un array por
lo que todas las operaciones válidas sobre arrays, serán válidas sobre ArrayCollection.


Ya solamente queda crear los getters y setters correspondientes.


Si ahora actualizamos el schema, se generarán las relaciones en la base de datos

> bin/console doctrine:schema:update --force


Guardando entidades relacionadas
--------------------------------

```php
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function createProductAction()
    {
        $category = new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new category with id: '.$category->getId()
        );
    }
}
```


Navegar entre entidades relacionadas
------------------------------------

```php
$product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($productId);

    $categoryName = $product->getCategory()->getName();
```

También tenemos un método get en la otra entidad.

```php
$category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->find($categoryId);

    $products = $category->getProducts();
```


Para más tipos de asociaciones entre entidades hay que acudir a la documentación oficial de doctrine.
http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/association-mapping.html


- @ManyToOne (unidireccional)
- @OneToOne (unidireccional / bidireccional / autorreferenciado)
- @OneToMany (bidirectional / unidireccional con join table / autorreferenciado)
- @ManyToMany (unidireccional / bidireccional / autorreferenciado)




El lenguaje DQL (Doctrine Query Language)
=========================================

Si queremos ahorrar consultas, o realizar consultas complejas, podemos 
utilizar el leguaje DQL.

```php
class AlumnoRepository extends \Doctrine\ORM\EntityRepository
{
  public function findWithNotas($id)
  {
      $query = $this->getEntityManager()
          ->createQuery(
          'SELECT a, n, g, asig FROM AppBundle:Alumno a
          JOIN a.notas n
          JOIN a.grado g
          JOIN n.asignatura asig
          WHERE a.id = :id'
      )->setParameter('id', $id);

      try {
          return $query->getSingleResult();
      } catch (\Doctrine\ORM\NoResultException $e) {
          return null;
      }
  }
}
```

En el ejemplo anterior, en una única consulta SQL obetenmos el alumno, su grado
sus notas y las asignaturas de sus notas.

http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html


El objeto QueryBuilder
----------------------

Doctrine tiene también un constructor de queries llamado QueryBuilder, que facilita
la construcción de sentencias DQL.


```php
// src/AppBundle/Repository/ProductRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        $qb = $this->createQueryBuilder('p')
                        ->where('p.price > :price')
                        ->setParameter('price', '19.99')
                        ->orderBy('p.price', 'ASC')
                        ->getQuery();
        
        return $qb->getResult();
        // Si queremos únicamente un resultado
        // return $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
```

http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html



Buenas Prácticas: Las consultas sql (dql) se deben realizar en la clase Repository
----------------------------------------------------------------------------------


Ejecutar sentencias SQL directamente
====================================

En caso de encontrarnos alguna SQL que no sepamos realizar con DQL, podemos 
recurrir a realizarla con SQL.

```php
$em = $this->getDoctrine()->getManager();
$connection = $em->getConnection();
$statement = $connection->prepare("SELECT something FROM somethingelse WHERE id = :id");
$statement->bindValue('id', 123);
$statement->execute();
$results = $statement->fetchAll();
```

Evidentemente, si ejecutamos consultas de esta forma, no tendremos los datos en 
entidades, los tendremos en arrays de php.



Configuración de doctrine
=========================

Doctrine es altamente configurable. Es esta página se pueden consultar todas las 
opciones de configuración

https://symfony.com/doc/current/reference/configuration/doctrine.html


Extensiones de doctrine
=======================

Para ciertas estructuras y comportamientos habituales de tablas, hay desarrolladores
que programan extensiones de doctrine. 

https://symfony.com/doc/current/doctrine/common_extensions.html
https://github.com/Atlantic18/DoctrineExtensions


Documentación general
---------------------

https://symfony.com/doc/current/doctrine.html
