Creación de una API REST con FosRestBundle
==========================================

Instalación del bundle
----------------------

Para instalar el bundle FOSRestBundle basta con seguir las instrucciones de instalación:
https://symfony.com/doc/master/bundles/FOSRestBundle/1-setting_up_the_bundle.html


Configuración del bundle
------------------------

Hay que definir un formato por defecto:

```yml
# app/config/config.yml
fos_rest:
    routing_loader:
        default_format: json
```

Creación de un controlador asociado a una ruta RESTful 
------------------------------------------------------


```yml
# app/config/routing.yml
asignaturas_rest:
    type:     rest
    resource: Acme\HelloBundle\Controller\AsignaturasRESTController
```

El parámetro *type: rest* le sirve al bundle para determinar las rutas que debe
gestionar.


Creamos el controlador y ponemos los métodos que queramos tener de entre los 
que nos ofrece FOSRestBundle.

```php
<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Asignatura;
use AppBundle\Form\AsignaturaType;

/**
 * @RouteResource("AsignaturasRest", pluralize=false)
 */
class AsignaturasRESTController extends Controller implements ClassResourceInterface
{
    public function copyAction($id) // RFC-2518
    {} // "copy_user"            [COPY] /users/{id}

    public function propfindPropsAction($id, $property) // RFC-2518
    {} // "propfind_user_props"  [PROPFIND] /users/{id}/props/{property}

    public function proppatchPropsAction($id, $property) // RFC-2518
    {} // "proppatch_user_props" [PROPPATCH] /users/{id}/props/{property}

    public function moveAction($id) // RFC-2518
    {} // "move_user"            [MOVE] /users/{id}

    public function mkcolAction() // RFC-2518
    {} // "mkcol_users"          [MKCOL] /users

    public function optionsAction()
    {} // "options_users"        [OPTIONS] /users

    public function getAction()
    {} // "get_users"            [GET] /users

    public function newAction()
    {} // "new_users"            [GET] /users/new

    public function postAction()
    {} // "post_users"           [POST] /users

    public function patchAction()
    {} // "patch_users"          [PATCH] /users

    public function editAction($slug)
    {} // "edit_user"            [GET] /users/{slug}/edit

    public function putAction($slug)
    {} // "put_user"             [PUT] /users/{slug}

    public function lockAction($slug)
    {} // "lock_user"            [LOCK] /users/{slug}

    public function unlockAction($slug)
    {} // "unlock_user"          [UNLOCK] /users/{slug}

    public function banAction($slug)
    {} // "ban_user"             [PATCH] /users/{slug}/ban

    public function removeAction($slug)
    {} // "remove_user"          [GET] /users/{slug}/remove

    public function deleteAction($slug)
    {} // "delete_user"          [DELETE] /users/{slug}

}
```


En la consola podemos ver las rutas que ha creado automáticamcnete FosRESTBundle.

> bin/console debug:router


Ya solamente queda programar la lógica de cada método.




https://symfony.com/doc/master/bundles/FOSRestBundle/index.html