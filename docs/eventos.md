Eventos
=======

Para emtir un evento, basta con llamar al método *dispatch* del *EventDispatcher*

```php
use Symfony\Component\EventDispatcher\EventDispatcher;

//...

  /**
  * @Route("/evento", name="evento")
  */
  public function eventoAction() {
   $dispatcher = new EventDispatcher();
   $dispatcher->dispatch('alumno.created');

   return new Response(
         '<html><body>Evento emitido</body></html>'
     );
  }
```

Este método admite un parámetro adicional para pasar la información que se desee


```php
   $dispatcher->dispatch('alumno.created', $alumno);
```

Crear un Listener
-----------------

```php
// src/AppBundle/EventListener/MiListener.php
<?php
namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MiListener
{
    public function myEventListener(Event $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        
    }
}

Registrar un listener
---------------------


```php
use Symfony\Component\EventDispatcher\EventDispatcher;
use \src\AppBundle\Listeners\MiListener;

$dispatcher = new EventDispatcher();

$listener = new MiListener();
$dispatcher->addListener('alumno.created', array($listener, 'myEventListener'));
```

