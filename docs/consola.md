# La consola de symfony

Symfony proporciona un montón de comandos a través del script *bin/console* que 
nos facilitan la tarea de desarrollo.

Además de estos comandos ya existentes, podemos programar e incluir tantos 
comandos nuevos como deseemos.


## Creación de un comando de consola

Los comandos se deben crear en clases bajo el namespace *Command* de nuestro
bundle (por ejemplo AppBundle\Command) y los nombres de los comandos deben terminar
con el sufijo Command.

La propia consola tiene un comando para crear comandos:

>> bin/console generate:commmand





http://symfony.com/doc/current/console.html