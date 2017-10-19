# Introducción a composer


Composer no es un gestor de paquetes. Aunque es cierto que trata con paquetes y 
librerías, la instalación siempre es local para cada proyecto, ya que las librerías 
se instalan en un directorio del proyecto (por defecto ese directorio es vendor/). 
Como por defecto Composer no instala ninguna librería globalmente, en realidad 
es un gestor de dependencias y no de paquetes.

Esta idea no es nueva, ya que Composer está inspirado por las herramientas npm 
de NodeJS y bundler de Ruby. Lo que sí que es nuevo es la disponibilidad de una 
herramienta como esta para aplicaciones PHP.

El problema que resuelve Composer es el siguiente:

- Dispones de un proyecto que depende de varias librerías desarrolladas por terceros.
- A su vez, varias de esas librerías dependen de otras librerías (tu no tienes 
por qué conocer estas dependencias "indirectas").
- Como desarrollador, tú solamente declaras las dependencias "directas" de tu proyecto.
- Composer averigua qué librerías deben instalarse (es decir, resuelve todas esas 
dependencias indirectas) y descarga automáticamente la versión correcta de cada librería.

Por último, Composer es una herramienta multi-plataforma, por lo que funciona 
igual de bien en servidores Windows, Linux y Mac OS X.



## El archivo composer.json

En este archivo se describen las dependencias del proyecto y también puede 
contener otro tipo de información.

El archivo utiliza el formato JSON y es muy fácil tanto de leer como de escribir. 
El contenido del archivo normalmente consiste en una serie de estructuras de 
información anidadas.

Lo primero (y a menudo lo único) que debes añadir en el archivo composer.json 
es una clave llamada require. De esta forma dices a Composer cuáles son los 
paquetes de los que depende tu proyecto.

```json
{
    "require": {
        "monolog/monolog": "1.0.*"
    }
}
```

El valor de require es un objeto que mapea nombres de paquetes (en este caso, 
monolog/monolog) con versiones de paquetes (en este caso, 1.0.*).

### Nombres de paquetes

El nombre de cada paquete está formado por dos partes. La primera indica quién 
es su "vendor" o creador (una persona o una empresa) y la segunda indica el 
nombre del proyecto. A menudo las dos partes son idénticas, pero el nombre del 
creador es importante para evitar colisiones entre proyectos con el mismo nombre. 

Así es posible por ejemplo que dos personas diferentes creen un proyecto llamado 
json, de forma que sus paquetes podrían llamarse igorw/json y seldaek/json.

### Versiones de paquetes

En el ejemplo anterior, la versión requerida de la librería es 1.0.*, lo que 
significa que se puede utilizar cualquier versión de la rama 1.0 (como por 
ejemplo 1.0.0, 1.0.2 o 1.0.20). Esta versión es equivalente a >=1.0 <1.1.

Las versiones requeridas se pueden especificar de muchas maneras diferentes, 
lo que da una gran versatilidad a Composer:

- Versión exacta: indica exactamente la versión específica que requieres, 
como por ejemplo 1.0.2.
- Rango de versiones: que se indican mediante los siguientes operadores de 
comparación: >, >=, <, <=, !=. Así podrías indicar la versión requerida como >=1.0 
o combinar varios rangos separándolos por comas: >=1.0,<2.0.
- Comodines: indican la versión requerida con un comodín (\*) mediante un patrón 
similar al de las expresiones regulares. La versión 1.0.\* por ejemplo es 
equivalente a >=1.0,<1.1.
- La siguiente versión significativa: que se indica mediante el operador ~ y se 
interprea de la siguiente manera: ~1.2 es equivalente a >=1.2,<2.0, mientras 
que ~1.2.3 es equivalente a >=1.2.3,<1.3.

La última forma de indicar las versiones es sobre todo útil para aquellos 
proyectos que siguen el versionado semántico. Normalmente se utiliza para 
indicar la mínima versión que requieres de una librería, como por ejemplo ~1.2, 
que permite cualquier versión hasta la 2.0 (sin incluir la 2.0). Como en teoría 
no deberían producirse problemas de retrocompatibilidad hasta la versión 2.0, 
esta técnica debería funcionar bien para los proyectos buenos que cumplen las 
normas.

Otra forma de entender el operador ~ es que simplemente especifica la versión 
mínima requerida pero permite que el último dígito crezca tanto como quiera.

Composer por defecto sólo tiene en consideración las versiones estables de cada 
paquete. Si en tu proyecto necesitas versiones Release Candidate, beta, alpha o 
dev, tienes que usar las opciones de estabilidad. Si en vez de una versión 
inestable de un paquete necesitas las de todos los paquetes del proyecto, puedes 
utilizar la opción minimum-stability.


## Instalar las dependencias declaradas

Después de declarar las dependencias, ejecuta el comando install de Composer 
para descargarlas e instalarlas en tu proyecto:

```
$ php composer.phar install
```

Este comando busca la versión más reciente del paquete monolog/monolog que 
satisface la versión que necesitas, la descarga y la instala en el directorio 
vendor/ del proyecto (este directorio se crea automáticamente si no existe). 
Colocar el código y las librerías de terceros en el directorio vendor/ es una 
buena práctica recomendada. En el caso de monolog, su código se guardará en el 
directorio vendor/monolog/monolog.

TRUCO
Si utilizas Git para versionar el código de tu proyecto, es muy recomendable 
que incluyas el directorio vendor/ en tu archivo .gitignore para no subir todo 
ese código al repositorio.

Además de instalar las dependencias, el comando install crea un archivo llamado 
composer.lock en el directorio raíz de tu proyecto.




## El archivo composer.lock


Después de instalar las dependencias, Composer apunta en el archivo composer.lock 
la versión exacta que se ha instalado de cada librería. De esta forma, el proyecto 
se fija a unas determinadas versiones.

Esto es muy importante porque el comando install comprueba primero si existe el 
archivo composer.lock y si existe, descarga exactamente las versiones que se indican 
en ese archivo (sin importar lo que diga el archivo composer.json).

Gracias al archivo composer.lock, cualquier persona que se descargue el proyecto 
tendrá exactamente las mismas versiones de las dependencias. Además, tu servidor 
de integración continua, tus servidores de producción, todos los miembros del 
equipo de desarrollo y cualquier otra persona o cosa que se baje el proyecto 
tendrá exactamente las mismas dependencias. Esto hace que se reduzcan o incluso 
desaparezcan los errores producidos por ejecutar diferentes versiones de las librerías.

Aunque los proyectos sólo los desarrolles tú, cuando dentro de unos meses tengas 
que reinstalar un proyecto que desarrollaste hace tiempo, gracias al archivo 
composer.lock tendrás la seguridad de que todo sigue funcionando bien aunque 
se hayan publicado nuevas versiones de las dependencias de tu proyecto.

Si no existe el archivo composer.lock, Composer determina las dependencias a 
partir del archivo composer.json y después crea el archivo composer.lock.

Esto significa que si alguna de las dependencias publica una nueva versión, 
no se actualizará automáticamente en tu proyecto. Para actualizar a la nueva 
versión, utiliza el comando update. Este comando hace que Composer busque 
las versiones más recientes de las librerías, siempre que sigan cumpliendo las 
restricciones de las versiones indicadas en el archivo composer.json. Obviamente, 
este comando update también actualiza el archivo composer.lock:

```
$ php composer.phar update
```

Si solamente quieres instalar o actualizar una dependencia, puedes indicar su 
nombre después del comando:

```
$ php composer.phar update monolog/monolog [...]
```

## Autoloading

Si la librería proporciona información sobre la carga automática de sus clases, 
Composer genera un archivo vendor/autoload.php. 

Simplemente incluye la siguiente línea en la parte de tu proyecto encargada de 
inicializar la aplicación:

```
require 'vendor/autoload.php';
```

Si incluyes este archivo en tu proyecto, ya puedes utilizar cualquier clase 
instalada a través de Composer sin tener que incluirla explícitamente en tu 
código:

```
require 'vendor/autoload.php';
```

Este cargador de clases simplifica mucho el uso del código de terceros. Si por 
ejemplo tu proyecto utiliza la librería Monolog, puedes utilizar sus clases 
directamente y Composer se encargará de cargarlas automáticamente:

```php
$log = new Monolog\Logger('name');
$log->pushHandler(
    new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING)
);
 
$log->addWarning('Foo');
```

Composer permite incluso que añadas tu propio código fuente al cargador automático de clases mediante la clave autoload del archivo composer.json:

```
{
    "autoload": {
        "psr-4": {"Acme\\": "src/"}
    }
}
```

La configuración anterior hace que Composer cree un cargador automático de 
clases para el namespace Acme. Este cargador sigue las normas del estándar 
PSR-4 de PHP.

http://www.php-fig.org/psr/

La configuración se basa en mapear namespaces a directorios. En este caso, el 
directorio src/ que contiene el código de tu proyecto estaría en la raíz del 
proyecto, al mismo nivel que el directorio vendor/. Así, el archivo src/Acme/Foo.php 
debería contener la clase Acme\Foo.



Fuente: http://librosweb.es/libro/composer/