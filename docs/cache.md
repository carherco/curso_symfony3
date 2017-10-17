# Caché

Symfony cachea de forma automática muchos elementos para mejorar la velocidad de las respuestas:

- Los equivalentes en PHP de los templates de twig
- Los valores de los archivos de configuración
- Las traducciones
...

Los elementos cacheados se guardan por defecto en el directorio *var/cache*.

Cada entorno de ejecución tiene su propio subdirectorio de cache.


## El comando cache/clear

El comando *cache:clear* de la consola de symfony borra todos los elementos de la cache, 
pero además realiza una puesta apunto. Es decir, vuelve a generar los elementos de 
la cache para que la siguiente petición no tenga que hacerlo.


## Caché programada












https://symfony.com/doc/current/components/cache.html