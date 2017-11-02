Debug
=====

El DebugBundle está activado por defecto en los entornos dev y test.

Este bundle configura el método **dump()** para que las variables aparezcan en la 
barra de debug y no alteren la estructura ni el contenido de las páginas.

Pero si por algún motivo el barra de debug no se ejecuta (por ejemplo, porque 
hemos puesto un *die* o un *exit* en el código) entonces la salida del dump() 
aparece directamente en la pantalla.

En las plantillas de twig podemos elegir si queremos que la función dump muestre
su salida en la barra de depuración:

```twig
{% dump foo.bar %}
```

o si queremos que muestre su salida en la página:

```twig
{{ dump(foo.bar) }}
```

http://symfony.com/doc/current/reference/configuration/debug.html
http://symfony.com/doc/current/components/var_dumper.html