SonataAdminBundle
=================

El bundle SonataAdminBundle es lo más parecido en Symvony 2/3 al AdminGenerator 
de Symfony 1.

Es muchísimo más potente, aunque algo menos cómodo de configurar.


Instalación de SonataAdminBundle
--------------------------------

Para instalar SonataAdminBundle hay que seguir las instrucciones del Bundle:

https://symfony.com/doc/master/bundles/SonataAdminBundle/getting_started/installation.html


Creación de una clase Admin
---------------------------

Una clase Admin decide qué campos mostrar en el listado, en los formularios, etc.
Cada modelo (entidad) tendrá su propia clase Admin. 

Las clases Admin extienden de Sonata\AdminBundle\Admin\AbstractAdmin;

Vamos a ejecutar el comando sonata:admin:generate para generar una clase Admin
a partir de una entidad.

> bin/console sonata:admin:generate

```
The fully qualified model class: AppBundle\Entity\Alumno  
The bundle name [AppBundle]: 
The admin class basename [AlumnoAdmin]: 
Do you want to generate a controller [no]? yes
The controller class basename [AlumnoAdminController]: 
Do you want to update the services YAML configuration file [yes]? 
The services YAML configuration file [services.yml]: 
The admin service ID [app.admin.alumno]: 
```


El comando da de alta el servicio Admin en el services.yml de nuestro bundle. O bien
copiamos la definición al config.yml de app/config o bien añadimos a este último
un import del fichero services.yml de nuestro bundle:

```yml
imports:
    - { resource: parameters.yml }
    - { resource: security.yml }
    - { resource: services.yml }
    - { resource: "@AppBundle/Resources/config/services.yml" }
```






Configuración de la clase Admin
-------------------------------

- configureDatagridFilters() => Campos del filtro de búsqueda del listado
- configureListFields() => Campos del listado
- configureFormFields() => Campos en formulario de Crear y Editar
- configureShowFields() => Campos en la acción "Mostrar"


http://symfony.com/doc/current/reference/forms/types.html



