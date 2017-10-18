# Introducción a Git básico

Documentación: https://git-scm.com/doc



## Características de git

### Snapshots

Git no almacena "diferencias", almacena snapshots.

Cada vez que haces commit, git básicamente toma una foto (snapshot) de todos los 
archivos en ese momento y guarda una referencia a ese snapshot.

Por eficiencia, git no vuelve a almacenar los archivos que no han cambiado, 
simplemente genera un link a la última versión de dicho archivo que tenga almacenada.

Git considera los datos como un flujo de snapshots.

### Casi todas las operaciones son locales

La mayoría de operaciones en git solamente utilizan ficheros y recursos locales.


### Integridad

Todo en git tiene checksum antes de ser almacenado. Y la referencia a los datos 
está referenciada por su checksum.

Esto significa que es imposible cambiar el contenido de cualquier archivo o directorio sin que git se dé cuenta.


### Los 3 estados

Lo más importante que hay que recordar y tener siempre presente en git, es lo siguiente:


Git tiene 3 estados principales en los que pueden estar los ficheros: 
- commited
- modified
- staged

Committed: Significa que los datos están almacenados en la base de datos local de git.
Modified: Significa que has cambiado archivos, pero no los has guardado todavía en la base de datos. 
Staged: Significa que has marcado un archivo modificado para que forme parte del siguiente commit.

Esto nos lleva a dividir un proyecto de git en tres secciones principales:
- El directorio .git (o la base de datos local .git)
- El directorio de trabajo (the working tree)
- El área de staging (staging area)

(Imagen de las secciones)

El directorio .git es donde Git almacena los metadatos y objetos del proyecto. Es
la parte más importante de git y es lo que se copia cuando se clona un repositorio
de otra máquina.

El directorio de trabajo es un simple "checkout" de una de las versiones del proyecto.
Estos archivos son extraídos de la base de datos local .git y puestos en el disco 
duro para trabajar con ellos.

El área de staging es un archivo, normalmente ubicado en el directorio .git, que 
que almacena información sobre lo que formará parte del siguiente commit. A veces 
se denomina "staging area" y otras veces "index".

El flujo de trabajo básico en git es más o menos el siguiente:
- Modificas archivos del directorio de trabajo.
- Añades snapshots de los archivos modificados al área de staging.
- Haces un commit

Volviendo a los 3 estados:
- Si una versión particular de un fichero está en el directorio .git, se considera *committed*.
- Si ha sido modificado y añadido al *staging area*, se considera *staged*.
- Si ha sido modificado pero no ha sido *staged*, entonces se considera *modified*. 



## Archivo .gitignore


## Comandos habituales

De trabajo básico:
- git init: inicializa git a partir de un proyecto
- git clone: clona un proyecto de otra máquina
- git status: muestra el estado de los ficheros
- git checkout —: deshace los cambios de un fichero
- git add: añade un fichero al staging area
- git reset HEAD: quita un fichero del staging area (NO deshace cambios)
- git commit: almacena un snapshot del estado actual del staging area
- git push: envia los commits al repositorio remoto
- git pull: se actualiza con los nuevos commits que haya en el repositorio remoto


De trabajo con ramas:
- git branch: crea una rama
- git checkout: cambia el directorio de trabajo por el de otra rama


