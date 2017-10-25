Caché
=====

Symfony cachea de forma automática muchos elementos para mejorar la velocidad de las respuestas:

- Los equivalentes en PHP de los templates de twig
- Los valores de los archivos de configuración
- Las traducciones
...

Los elementos cacheados se guardan por defecto en el directorio *var/cache*.

**Cada entorno de ejecución tiene su propio subdirectorio de cache.**


El comando cache/clear
----------------------

El comando *cache:clear* de la consola de symfony borra todos los elementos de la cache, 
pero además realiza una puesta apunto. Es decir, vuelve a generar algunos elementos de 
la cache para que la siguiente petición no tenga que hacerlo.


Caché programada
----------------

Al margen de todos los elementos que cachea symfony, nosotros podemos utilizar
el sistema de caché para cachear nuestros propios elementos.

A partir de la versión 3.3 symfony implementa el denominado "Simple Cache" o 
PSR-16. Es la que se describe a continuación.

EL primer paso es crear un objeto *cache* a partir de una de las clases de cache
que vienen con symfony


```php
use Symfony\Component\Cache\Simple\FilesystemCache;

$cache = new FilesystemCache();
```

Usando este objeto, se pueden crear, recuperar, actualizar y borrar elementos de 
la caché.

```php
// guardar un ítem en la caché
$cache->set('stats.num_products', 4711);

// o guardarlo con un ttl personalizado
// $cache->set('stats.num_products', 4711, 3600);

// preguntar si existe un ítem determinado
if (!$cache->has('stats.num_products')) {
    // ... 
}

// recuperar el varlor almacenado en un ítem
$numProducts = $cache->get('stats.num_products');

// o especificar un varlor por defecto, si no existe
// $numProducts = $cache->get('stats.num_products', 100);

// elimiar un ítem de la caché
$cache->delete('stats.num_products');

// borrar todos los ítems de la caché
$cache->clear();
```

Icluso se pueden trabajar con varios elementos al mismo tiempo

```php
$cache->setMultiple(array(
    'stats.num_products' => 4711,
    'stats.num_users' => 1356,
));

$stats = $cache->getMultiple(array(
    'stats.num_products',
    'stats.num_users',
));

$cache->deleteMultiple(array(
    'stats.num_products',
    'stats.num_users',
));
```

Clases de caché disponibles
---------------------------

- ApcuCache
- ArrayCache
- ChainCache
- DoctrineCache
- FilesystemCache
- MemcachedCache
- NullCache
- PdoCache
- PhpArrayCache
- PhpFilesCache
- RedisCache
- TraceableCache


"More Advanced Caching" (PSR-6)
-------------------------------

Antes de la versión 3.3 de symfony, la única implementación era la PSR-6 ("More 
Advanced Caching"). A partir de la verisón 3.3 se puede utilizar cualquiera de
las 2 implementaciones.

Se puede encontrar documetación sobre la implementación PSR-6 en la documentación
oficial de symfony

https://symfony.com/doc/current/components/cache.html