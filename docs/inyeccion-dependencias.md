# Inyección de dependencias

La inyección de dependencias es un patrón de diseño orientado a objetos, en el 
que se suministran objetos a una clase en lugar de ser la propia clase la que 
cree el objeto. También se conoce como IoC (Inversion of Control).

Veamoslo en un ejemplo. Pongamos que queremos utilizar la clase Symfony\Component\Ldap\Ldap
en nuestro controlador para realizar una conexión manualmente a LDAP y realizar 
las operaciones que nos apetezca.



## Método tradicional

El método tradicional es obtener el objeto Ldap a través del constructor de la 
clase con el operador new:

```php
use Symfony\Component\Ldap\Ldap;

public function indexAction()
{
    $ldap = new Ldap();
    

    // ...
}
```

Pero el constructor de la clase Ldap, necesita un parámetro de entrada:

```php
final class Ldap implements LdapInterface
{
    private $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
```

Por lo que para hacer new Ldap, necestiamos primero un objeto Adapter:

```php
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;

public function indexAction()
{
    $ldapAdapter = new Adapter();
    $ldap = new Ldap($ldapAdapter);

    // ...
}
```

Pero si ahora nos fijamos en el constructor de Adapter, necesitamos también un 
parámetro de entrada que es un array.


```php
class Adapter implements AdapterInterface
{
    private $config;
    private $connection;
    private $entryManager;

    public function __construct(array $config = array())
    {
        if (!extension_loaded('ldap')) {
            throw new LdapException('The LDAP PHP extension is not enabled.');
        }

        $this->config = $config;
    }
```

Y lo peor es que simplemente mirando el constructor, no sabemos qué contenido debe
de tener el array $config.

Después de mirar la documentación de la clase Adapter, averiguamos la información
que nos hace falta y ya podemos instanciar la clase

```php
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Adapter\ExtLdap\Adapter;

public function indexAction()
{
    $config = array('host' => '138.100.191.229',
                    'port' => 636,
                    'encryption' => 'ssl',
                    'options' => array(
                        'protocol_version' => 3,
                        'referrals' => false
                    ));

    $ldapAdapter = new Adapter($config);

    $ldap = new Ldap($ldapAdapter);

    // ...
}
```

Y ya por fin, obtenemos nuestro servicio ldap listo para ser utilizado.


Problemas de esto:
- Hacen falta demasiadas líneas de programación simplemente para instanciar un único objeto. 
- Hace falta conocimiento de las clases y de los constructores para poder instanciarlas todas.
- Si modifico el constructor de un servicio (para añadir otro parámetro, o para cambiarlo por otro...) tengo que revisar TODA la aplicación para cambiar todos los new que haya de dicho servicio.


## Con inyección de dependencias

Si se utiliza el patrón de inyección de dependencias, es el *sistema* el que se 
encarga de suministrar los objetos correspondientes a cada clase.

A través del contenedor de servicios de Symfony o desde la versión 3.3, simplemente
tipando en el constructor o en la acción el tipo de cada servicio, Symfony se encargará de 
instanciar todas clases que sean necesarias:

```php
public function indexAction()
{
    $logger = $this->get('logger');
    $entityManager = $this->get('doctrine.orm.entity_manager');
    $ldap = $this->get('Symfony\Component\Ldap\Ldap');

    // ...
}
```


```php
public function indexAction(Psr\Log\LoggerInterface $logger, Doctrine\ORM\EntityManagerInterface $em, Symfony\Component\Ldap\Ldap $ldap)
{
    
}
```

Con este patrón, desparecen todos los problemas mencionados anteriormente.


