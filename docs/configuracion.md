# Configuración

Una aplicación Symfony consiste en una colección de bundles que añaden herramientas 
(servicios) al proyecto. Cada bundle se puede personalizar a través de los archivos 
de configuración que por defecto están en app/config.


## El archivo config.yml

El archivo principal de la configuración es app/config/config.yml. Aunque para 
entender en su totalidad el funcionamiento y la potencia de la configuración es 
necesario hablar de los entornos de ejecución.

### Los entornos de ejecución (prod, dev y test).

En symfony existen 3 entornos de ejecución:
- Entorno de producción
- Entorno de desarrollo
- Entotno de tests

Es muy común, por no decir necesario, poder configurar de forma distinta cada 
uno de estos entornos. Por ejemplo:

- La base de datos de producción es distinta de la de desarrollo y distinta de la de testeo
- Durante el desarrollo o el testeo, no se querrá enviar emails reales, o se querrá que se envíen a la cuenta de desarrollo
- En testeo y en producción no queremos la barra de depuración
- No queremos que los mensajes de log durante el desarrollo se guarden en el mismo archivo que los mensajes de producción
...

Si echamos un vistazo a los archivos web/app.php y web.app_dev.php podemos observar
que se cargan los entornos 'prod' y 'dev' respectivamente:

  $kernel = new AppKernel('prod', false);
  $kernel = new AppKernel('dev', true);

  El primer parámetro establece el entorno y el segundo establece el modo de debug.

Si echamos un vistazo al código ejecutado en los tests a raíz de esta instrucción 

  $client = static::createClient(); 

  veremos que se instacia la clase AppKernel con entorno 'test' y debug 'true'.

Si echamos un vistazo al archivo bin/console veremos también que por defecto se
instancia la clase AppKernel con entorno 'dev' y debug 'true'; 

Según el entorno que se indique, symfony carga el archivo correspondiente config_prod.yml, 
config_dev.yml y config_test.yml. 

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
```

Todos estos archivos importan el archivo config.yml. Gracias a este mecanismo, 
se carga la configuración general y posteriormente cada entorno
puede sobreescribir las opciones de configuración que desee.

Si seguimos la cadena de imports de los ficheros .yml, podremos ver cómo efectivamente se utilizan 
todos los archivos .yml de app/config. El único archivo NO utilizado es el que lleva por extensión 
.dist (parameters.yml.dist). Este archivo lo utiliza composer para generar el archivo parameters.yml 
ya que este último archivo no está bajo control de versiones. Es por esto que cada vez que añadamos 
algún parámetro al fichero parameters.yml, deberíamos añadirlo también al fichero parameters.yml.dist.

### El modo de debug

El modo de debug indica si la aplicación debe ejectarse en "debug mode". Al margen
del entorno, una aplicación symfony puede ejecutarse en modo debug. Esto afecta
algunos comportamientos como mostrar las trazas completas en los errores 500 o si 
los archivos de caché se regeneran en cada petición.

El modo debug generalmente está activado en los entornos de test y de desarrollo.


## Formatos de archivos de configuración

Los ficheros de configuración se pueden escribir en formato .yml, en formato 
.xml o en formato .php. 

## El comando de consola config:dump-reference

Además de acudir a la documentación oficial de cada componente, existe en la 
consola el comando *config:dump-reference* que te muestra todas las opciones de 
configuración para una clave concreta. Por ejemplo, para conocer las opciones
de configuración de la clave *twig* podemos ejecutar

bin/console config:dump-reference twig

## La clave imports

La clave *imports* se utiliza para cargar otros ficheros de configuración.

```yml
# app/config/config.yml
imports:
    - { resource: parameters.yml }
    - { resource: security.yml }
    - { resource: services.yml }
# ...
```

## La clave parameters

La clave *parameters* se utiliza para definir variables que podrán ser luego 
referenciadas en el mismo o en otros ficheros de configuración.

```yml
# app/config/config.yml
# ...

parameters:
    locale: en

framework:
    # ...

    # any string surrounded by two % is replaced by that parameter value
    default_locale:  "%locale%"

# ...
```

El archivo de configuración *parameters.yml* se utiliza justamente para definir 
aquellas variables de configuración cuyos valores son diferentes según la máquina
en la que se aloja el proyecto (configuración del servidor de base de datos, 
configuración del servidor correo...).

El archivo *parameters.yo NO está bajo control de versiones.


## Los parámetros kernel.environment y kernel.debug

Internamente, los valores del entorno y del valor del modo de debug son accesibles 
a través de los parámetros *kernel.environment* y *kernel.debug* respectivamente.


## Seleccionando el entorno al ejecutar comando de consolas

Por defecto, los comandos de consola se ejectuan en el entorno de desarrollo y 
con el modo debug activado. Si se desea, se puede seleccionar otro entorno y/o
desactivar el modo debug.

```
 php bin/console command

 php bin/console command --env=prod

 php bin/console command --env=test --no-debug
```


## Crear un nuevo entorno

Crear un nuevo entorno es tan fácil como crear el fichero de configuración con 
el prefijo adecuado.

```yml
# app/config/config_benchmark.yml
imports:
    - { resource: config_prod.yml }

```

Ya tenemos el entorno creado y listo para ser utilizado. Si queremos utilizarlo 
para acceder por la web, basta con crear un archivo *app_benchmark.php* en el 
directorio *web* instanciando la clase AppKernel con 'benchmark' como primer
parámetro.

```php
// ...

$kernel = new AppKernel('benchmark', false);

// ...
```

Y podremos ejectuar nuestras páginas en el nuevo entorno accediendo a 

http://127.0.0.1:8000/app_benchmark.php



http://symfony.com/doc/current/configuration.html

http://symfony.com/doc/current/configuration/environments.html