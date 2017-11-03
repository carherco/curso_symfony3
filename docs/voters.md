Voters
======

Los voters son clases que deciden si un usuario puede acceder a un recurso o no.

Cada vez que se llama al método isGranted() o al método denyAccessUnlessGranted() 
Symfony hace una llamada a cada clase voter que haya registrada en el sistema.

Cada uno de los voters decidirá si permite al usuario realizar la acción, si le 
deniegar realizarla o si se abstiene de decidir nada.

Un voter personalizado necesita implementar VoterInterface o extender Voter.

```php
abstract class Voter implements VoterInterface
{
    abstract protected function supports($attribute, $subject);
    abstract protected function voteOnAttribute($attribute, $subject, TokenInterface $token);
}
```

Nuestro voter será por lo tanto una clase con dos métodos:
- supports($attribute, $subject)
- voteOnAttribute($attribute, $subject, TokenInterface $token)


Vamos a suponer que tenemos una aplicación que gestiona eventos, y que los usuarios
solamente pueden editar los eventos de los que son creadores.

Es decir, cualquier usuario puede editar eventos, pero solamente los suyos.

```php
    /**
     * @Route("/eventos/{id}/edit", name="eventos_edit")
     */
    public function editAction($id)
    {

        $evento = ...;

        // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted('edit', $evento);

        // ...
    }
```

El método denyAccessUnlessGranted() (y pasaría con isGranted()) llama al sistema 
de voters. Ahora mismo no hay voters que puedan juzgar si el usuario puede editar 
el evento, así que vamos a crear uno.



```php
// src/AppBundle/Security/EditarEventoVoter.php
namespace AppBundle\Security;

use AppBundle\Entity\Evento;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EditarEventoVoter extends Voter
{
    protected function supports($atributo, $entidad)
    {
        // sólo votar en objetos Evento dentro de este voter
        if ($entidad instanceof Evento) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute($atributo, $entidad, TokenInterface $token)
    {
        $user = $token->getUser();

        //Gracias al método supports ya sabemos que $entidad es un Evento y $operación es 'edit'
        if($user->getId() == $entidad->getCreador()->getId()){
          return true;
        }
        
        return false;
    }
}
```


El método supports()
--------------------

La llamada a *$this->denyAccessUnlessGranted('edit', $evento)* admite dos parámetros.
Estos dos parámetros se le pasan a la función supports del voter.

Este método debe devolver true o false. Si devuelve false, el voter se *abstiene* 
de tomar ninguna decisión y el sistema de seguridad de symfony lo ignora.

Si por el contrario, el método supports devuelve true, entonces Symfony llamará 
al método voteOnAttribute() con los mismos dos parámetros y un tercero que permite
el acceso al objeto User.


El método voteOnAttribute()
---------------------------

El objetivo de este método también es muy simple. Si devuelve true, Symfony permitirá
al usuario realizar la acción. Si devuelve false, Symfony denegará al usuario 
realizar la acción.

A este método le llegan dos parámetros con los dos valores con los que se llamó a 
$this->denyAccessUnlessGranted('edit', $evento) y un tercer parámetro con acceso
al objeto user. 

Si es necesario, se puede utilizar la inyección de dependencias para acceder a 
cualquier otro servicio con lo que en un voter tenemos acceso a cualquier 
elemento de nuestra aplicación que necesitemos para tomar la decisión.




Configurar el voter
-------------------

Para inyectar el voter en el security layer debes declararlo como service y ponerle el tag security.voter:

```yml
# app/config/services.yml
services:
    app.post_voter:
        class: AppBundle\Security\EditarEventoVoter
        tags:
            - { name: security.voter }
        # pequeña mejora de rendimiento
        public: false
```

Estrategia de decisión
----------------------

Normalmente tendremos un único voter.

Otras veces podemos tener varios voters, pero solamente un voter votará en cada
ocasión y el resto se abstendrán.

Y en raras ocasiones tendremos varios voters tomando una misma decisión.

Por defecto, cuando varios voters tienen que votar si permiten o no un acceso, 
basta con que uno de ellos lo permita, para que el usuario logre el acceso.

Sin embargo se puede cambiar este comportamiento, llamado "strategy" desde el 
security.yml. Hay 3 posibles estrategias para elegir:

- affirmative (por defecto). Otorga acceso tan pronto como haya un voter que permita acceso.
- consensus. Otorga acceso si hay más voters garantizando acceso que denegándolo.
- unanimous. Sólo otorga acceso una vez que todos los voters garantizan acceso.

```yml
# app/config/security.yml
security:
    access_decision_manager:
        strategy: unanimous
```



https://symfony.com/doc/current/security.html#access-control-lists-acls-securing-individual-database-objects

https://symfony.com/doc/current/security/voters.html

https://symfony.com/doc/current/reference/configuration/security.html

https://diego.com.es/voters-para-permisos-de-usuarios-en-symfony

http://librosweb.es/libro/buenas_practicas_symfony/capitulo_9/los_security_voters.html

https://stackoverflow.com/questions/17020762/sonata-user-security-on-custom-field/17035423#17035423