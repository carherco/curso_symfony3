# Índice del curso

## Introducción
Symfony es un completo framework diseñado para optimizar el desarrollo de las 
aplicaciones web basado en el patrón MVC (Modelo Vista Controlador). 

Proporciona varias herramientas y clases encaminadas a reducir el tiempo de 
desarrollo de una aplicación web compleja. Además, automatiza las tareas más 
comunes, permitiendo al desarrollador dedicarse por completo a los aspectos 
específicos de cada aplicación. El resultado de todas estas ventajas es que no 
se debe reinventar la rueda cada vez que se crea una nueva aplicación web.

Symfony está desarrollado completamente en PHP 5.3. Ha sido probado en numerosos 
proyectos reales y se utiliza en sitios web de comercio electrónico de primer nivel. 
Symfony es compatible con la mayoría de gestores de bases de datos, como MySQL, 
PostgreSQL, Oracle y Microsoft SQL Server. Se puede ejecutar tanto en plataformas 
*nix (Unix, Linux, etc.) como en plataformas Windows.

La primera versión de Symfony fue lanzada en octubre de 2005, por Fabien Potencier. 

Fuente: https://es.wikipedia.org


## Contenidos

Instalación: 
 - [Instalación](instalacion.md)
 - [Introducción a Composer](composer.md)
 - [Trabajando con Git](git.md)
 - [Estructura de un proyecto symfony](estructura-proyecto.md)
 
Componentes:
 - [Configuración](configuracion.md)
 - [La consola de comandos](consola.md)
 - [Doctrine ORM](doctrine.md)
 - [Enrutamiento](routing.md)
 - [I18n](i18n.md)
 - [Twig](twig.md)
 

 
## Documentación ofical

La documentación oficial de Symfony está en: https://symfony.com/doc/current/index.html

## Datos de contacto 

Mis datos de contacto:
 - Email: carherco@gmail.com
 - LinkedIn: https://www.linkedin.com/in/carlosherrera/





•	Introducción
	◦	Instalación de symfony, creación nuevo proyecto, composer, integración con git, permisos de ficheros, servidor integrado de php
	◦	Estructura de un proyecto symfony. 
•	Creación de la página de Home
	◦	Introducción a Controllers 
	◦	Introducción a Twig
	◦	Introducción al Routing
	◦	Internacionalización (i18n)
•	Creación de otras páginas de la zona pública
	◦	Routing avanzado
	◦	Archivos de configuración de symfony. 
	◦	Caché
	◦	La consola de symfony. Comandos predefinidos.
•	Acceso a base de datos. Doctrine.
	•	Formularios y validaciones. Mensajes Flash.
	•	Zona privada. Página de dashboard del usuario.
	◦	Organización del código en bundles. Buenas prácticas.
	◦	Twig avanzado (templates y layouts, herencia de plantillas…). Buenas prácticas de organización de plantillas.
	◦	Configuración de la seguridad y de los roles, firewalls, sistema de login…
	◦	FOSUserBundle
	▪	Instalación de bundles con composer. Instalación de FOSUserBundle
	▪	Configuración de bundles. Configuración de FOSUserBundle
	▪	Funcionalidades de FOSUserBundle.
	•	Creación de otras partes de la zona privada
	◦	Controllers (Los objetos Request, Response, y User). Buenas prácticas en la programación de controladores
	◦	Identificación del usuario logeado, detección del rol(es) del usuario, detección del idioma del usuario (i18n).
	◦	El profiler. Entornos de ejecución (desarrollo, producción).
	◦	Logs
	◦	Envío de correos
	◦	Eventos
	◦	Creación de comandos de consola personalizados.
	•	Acceso a APIs REST u otras fuentes de datos (Web Services)
	◦	Servicios
	◦	Buenas prácticas en la programación de servicios.
	◦	Tratamiento de peticiones en formato JSON.
	◦	El contenedor de servicios y la inyección de dependencias
	◦	Parámetros de configuración personalizados. Configuración adaptada al entorno de ejecución (desarrollo, producción)
	•	Creación de una API REST
	◦	Construcción de respuestas en formato JSON.
	◦	Buenas prácticas.
	•	Creación de la zona de admin
	◦	SonataBundle (equivalente al plugin para admin de symfony 1)
	•	Componente Workflow
	•	Testing con PHPUnit. Buenas prácticas de testeo.
	•	Integración contínua con Jenkins
