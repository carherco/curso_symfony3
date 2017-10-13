

1. INTRODUCCIÓN

Ejercicio: Instalar symfony


Ejercicio: Crear un proyecto

>> symfony new curso

Comprobar que aparece pantalla de bienvenida

Ejercicio: Bajar proyecto symfony de github y ejecutar composer

>> git clone https://github.com/carherco/curso_symfony3
 
>> cd curso_symfony3
>> composer install

Ejemplo "Hola Mundo" (DefaultController::helloAction)
Ejemplo "Hola Mundo con template" (DefaultController::hello2Action)
Ejemplo "Hola Mundo con variable" (DefaultController::hello3Action)
Ejemplo "Hola Mundo con html completo" (DefaultController::hello4Action)
Ejemplo "Hola Mundo con traducción" (DefaultController::hello5Action)

Ejercicio Página de bienvenida con plantilla de bootstrap 4.


2. PARTE PÚBLICA

Ejercicio: Generar controlador con 2 acciones: homeAction y loginAction

>> bin/console generate:controller


  created ./src/AppBundle/Resources/views/Public/
  created ./src/AppBundle/Resources/views/Public/home.html.twig
  created ./src/AppBundle/Resources/views/Public/login.html.twig
  created ./src/AppBundle/Controller/PublicController.php
  created ./src/AppBundle/Tests/Controller/
  created ./src/AppBundle/Tests/Controller/PublicControllerTest.php
Generating the bundle code: OK


Echar un vistazo a git

>> git status

On branch master
Your branch is up-to-date with 'origin/master'.
Untracked files:
  (use "git add <file>..." to include in what will be committed)

	src/AppBundle/Controller/PublicController.php
	src/AppBundle/Resources/
	src/AppBundle/Tests/

nothing added to commit but untracked files present (use "git add" to track)


NOTA: Symfony genera los templates dentro del Bundle. Esto es lo que hay que hacer 
en caso de que el Bundle vaya a ser distribuido posteriormente, pero durante este curso
nosotros pondremos los recursos en el directorio app.

Ejercicio: Crear templates de home y de login con bootstrap


Ejemplo: Crear un layout para la parte pública

Ejercicio herencia de plantillas: Crear un layout común para home y para login.
Ejercicio include de plantillas: Sacar la cabecera a una template separada.









Ejercicio routing simple "Página Home" <=> Login" 
Ejercicio routing simple "Página Home" <=> Login" con path()

