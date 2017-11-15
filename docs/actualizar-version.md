Actualizar la versión de Symfony
================================


Una actualización menor de Symfony (por ejemplo de la versión 3.3.X a la versión 
3.4.X no debería acarrear grandes problemas.

La actualización se realiza en dos pasos:

1) Actualizar la librería de Symfony a través de composer
---------------------------------------------------------

Modificamos el fichero composer.json indicando la nueva versión:

```json
{
    "...": "...",

    "require": {
        "symfony/symfony": "3.4.*",
    },
    "...": "...",
}
```

Y le decimos a composer que actualice:

> composer update symfony/symfony 


Si se produjera algún error de dependencias con otras librerías, se puede probar
el mismo comando pero con el modificador *--with-dependencies*

> composer update symfony/symfony --with-dependencies 


2) Actualizar nuestro código para que trabaje con la nueva versión
------------------------------------------------------------------

Todas las versiones de Symfony vienen con un fichero UPGRADE (por ejemplo 
vendor/symfony/symfony/UPGRADE-3.4.md) que describe los cambios en cada versión.

Se debe revisar dicho fichero para realizar los cambios que sean necesarios.


http://symfony.com/doc/current/setup/upgrade_minor.html
