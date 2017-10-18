# Estructura de un proyecto symfony

Un proyecto symfony tiene la siguiente estructura de directorios:

- app
- bin
- src
- tests
- var
- vendor
- web

Y los siguientes archivos en el directorio raíz:

- .gitignore
- README.md
- composer.json
- composer.lock
- phpunit.xml.dist



## El directorio app/

Contiene elementos como la configuración y las plantillas. Básicamente alberga todo 
lo que no es PHP ni *assets*.


## El directorio src/

Nuestro código PHP reside aquí. 

El 99% del tiempo de desarrollo trabajaremos en el directorio src/ (archivos PHP) or en app/ (para todo lo demás). 


## El directorio bin/

Contiene la consola de comandos y un script que comprueba los requisitos de symfony.

```
bin/console
```

```
php bin/symfony_requirements  
```

## El directorio tests/

Los tests automatizados de nustra aplicación residen aquí.

## El directorio var/

Aquí es donde los se almacenan los ficherso creados automáticamente por symfony: 
ficheros de la caché (var/cache/), logs (var/logs/) y sesiones (var/sessions/).

## El directorio vendor/

Aqui residen las librerías de terceros. Se descargan a través de composer.

## El directorio web/

Este directorio es el *document root* del proyecto. Todos los archivos que deben 
ser accesibles públicamente residen aquí: normalmente archivos css, archivos 
js e imágenes, además del php de entrada (app.php).

Se pueden proteger el resto de directorios (app, src, etc) con ficheros .htaccess, pero lo mejor
es que simplemente no haya ninguna url para acceder a ellos.