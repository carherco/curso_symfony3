Creación de una API REST con FosRestBundle
==========================================

Instalación del bundle
----------------------

Para instalar el bundle FOSRestBundle basta con seguir las instrucciones de instalación:
https://github.com/voryx/restgeneratorbundle


Configuración del bundle
------------------------

Este bundle tiene dependencias con varios bundles, así que hay que configurarlos
todos.

```yml
framework:
    csrf_protection: false #only use for public API

fos_rest:
    routing_loader:
        default_format: json
    param_fetcher_listener: true
    body_listener: true
    #disable_csrf_role: ROLE_USER
    body_converter:
        enabled: true
    view:
        view_response_listener: force

nelmio_cors:
    defaults:
        allow_credentials: false
        allow_origin: []
        allow_headers: []
        allow_methods: []
        expose_headers: []
        max_age: 0
    paths:
        '^/api/':
            allow_origin: ['*']
            allow_headers: ['*']
            allow_methods: ['POST', 'PUT', 'GET', 'DELETE']
            max_age: 3600

sensio_framework_extra:
    request: { converters: true }
    view:    { annotations: false }
    router:  { annotations: true }
```


Generación de un controlador REST
---------------------------------

Este bundle dispone de un comando de consola para generar controladroes basados
en una entidad:

> bin/console voryx:generate:rest

Después de indicar toda la información requerida, el bundle creará un controlador,
un formulario (Type) y la entrada corresponiente en el routing.

```
  created ./src/AppBundle/Controller/AlumnoRESTController.php
Generating the REST api code: OK
  created ./src/AppBundle/Form/AlumnoType.php
Generating the Form code: OK

Confirm automatic update of the Routing [yes]? 
Importing the REST api routes: OK
```

https://github.com/voryx/restgeneratorbundle


NelmioApiDocBundle
==================

https://symfony.com/doc/master/bundles/NelmioApiDocBundle/index.html




