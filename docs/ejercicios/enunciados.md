Enunciados de ejercicios
========================

Ejercicio twig básico: Listado de usuarios
------------------------------------------

Se trata de mostar un listado de asignaturas con las siguientes características:

- Tabla con asignaturas (for)
- Si no hay asignaturas, mensaje de que no hay (if)
- color distinto líneas pares/impares (if + index)
- Nombre de asignatura según idioma (if)
- Cabecera de la tabla y mensaje de no hay asignaturas en doble idioma (|trans, bin/console
translation:update)
- Fecha de generación del informe (fecha actual, formateada) (|date)

Bonus: Probar a poner {{asig.code}} en vez de {{asig.codigo}} y ver el mensaje de error.


Ejercicio routing
-----------------

1) Crear 4 páginas con las siguientes rutas:

- /user/{id}
- /user/create
- /user/edit/{id}
- /user/delete

con sus correspondientes controladores y plantillas.

2) Comprobar que es imposible acceder al controlador asociado a /user/create

3) Reordenar las rutas para que sean todas accesibles

4) Modificar las rutas para que a cada una se acceda con un método HTTP distinto (GET, POST, PUT, DELETE)



Ejercicio entornos y configuración
----------------------------------

- Crear un entorno de configuración para "pre-producción" llamado "pre".
- Crear un archivo app_pre.php para poder ejecutar la aplicación en dicho entorno.


Ejercicio caché
---------------

1) Ejecutar una página de symfony que tenga alguna traducción con el entorno de producción.
2) Hacer cambios en el fichero de twig y en el diccionario y comprobar que al actualizar la página no se muestran los cambios
3) Limpiar la caché de producción y volver a actualizar la página



Ejercicio doctrine: Listado de notas de un alumno
-------------------------------------------------

Dada la url "/ejercicios/alumnos/{id}/notas mostar una página que extienda del 
layout *public.html.twig* y que muestre lo siguiente:

- Nombre y apellidos del alumno
- Nombre del grado del alumno
- Texto "Listado de notas"
- Tabla o listado con todas las notas del alumno en la que se muestre:
    - Nombre de la asignatura
    - Número de la convocatoria
    - Fecha de la convocatoria
    - Nota

Observar en el profiler las SQLs ejectuadas.

Bonus: 
- Formatear la fecha
- Modificar el código para obtener el listado con una única llamada a la base de datos
- Hacer traducible la página (los textos fijos) añadiendo el idioma a la url y traducirla a español y a inglés



Ejercicio formularios
---------------------

1) Utilizar el comando doctrine:generate:form para generar los formularios de
    - Asignatura
    - Grado
    - Alumno
    - Nota

2) Crear 4 controladores con un prefijo para el routing: 
    - AsignaturasController ('/asignaturas')
    - GradosController ('/grados')
    - AlumnosController ('/alumnos')
    - NotasController ('/notas')

3) Cada controlador tendrá 5 acciones:
    - indexAction ('/') => Twig con: Botón de añadir y listado de ítems con botones en cada ítem de ver, editar y eliminar 
    - newAction ('/new') => Twig con: Formulario vacío para dar de alta alumnos con botón de Guardar y de Volver
    - editAction ('/edit/{id}') => Twig con: Formulario de edición con botón de Guardar y de Volver
    - showAction ('/show/{id}') => Twig con: Vista de todos los campos de un ítem concreto con botón de volver y de editar
    - deleteAction ('/delete/{id}') => Acción sin ningun twig. Al realizar el borrado, redirigirá a indexAction

Conviene seguir el siguiente orden: grados, asingaturas, alumnos, notas.