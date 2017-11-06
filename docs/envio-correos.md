Envío de correos con SwiftMailer
================================

La instalación por defecto de Symfony viene con un bundle para envío de correos 
con la librería SwiftMailer.

Para utilizar SwiftMailer tenemos que configurarlo según los parámetros de 
configuración de nuestro servidor de correo:

```yml
# app/config/config.yml
swiftmailer:
    transport: '%mailer_transport%'
    host:      '%mailer_host%'
    username:  '%mailer_user%'
    password:  '%mailer_password%'
```

Normalmente los valores de estos parámetros estarán definidos en el fichero 
parameters.yml.

Los parámetros de configuración disponibles son los siguientes:

- transport (smtp, mail(obsoleto), sendmail, o gmail)
- username
- password
- host
- port
- encryption (tls, o ssl)
- auth_mode (plain, login, o cram-md5)
- spool
    - type (sistema para la cola de mensajes, "file" o "memory")
    - path (dónde almacenar los mensajes)
- delivery_addresses (un array de direcciones de email a las que enviar TODOS los emails en vez de a las direcciones reales)
- disable_delivery (si vale true no se enviará ningún mensaje)


NOTA: Si se utiliza delivery_addresses, Swift Mailer añadirá cabeceras X-Swift-To,
X-Swift-Cc y X-Swift-Bcc para que podamos saber a quien la habría llegado el correo.

NOTA: *transport gmail* es lo mismo que *transport smtp* con 
  - encryption	ssl
  - auth_mode	login
  - host	smtp.gmail.com


Swift_Message y Swift_Mailer
----------------------------

La librería Swift Mailer trabaja creando, configurando y enviando objetos Swift_Message. 

El servicio Swift_Mailer es el responsable de enviar dichos objetos Swift_Message. 

```php
public function indexAction($name, \Swift_Mailer $mailer)
{
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('notificaciones@midominio.com')
        ->setTo('usuario@sudominio.com')
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => $name)
            ),
            'text/html'
        )
        /*
         * Podemos incluir una versión en texto plano del mensaje
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;

    $mailer->send($message);

    // Podríamos haber obtenido el servicio también con $this->get('mailer')
    // $this->get('mailer')->send($message);

    return $this->render(...);
}
```

La plantilla del correo podría ser algo así:

```yml
{# app/Resources/views/Emails/registration.html.twig #}
<h3>¡Enhorabuena!</h3>

Felicidades {{ name }}. Has completado tu registro correctamente.

Para entrar en la aplicación, ve a: <a href="{{ url('login') }}">Login</a>.

Gracias.
```

El objeto Swift_Mailer soporta muchas más opciones, como incluir ficheros adjuntos,
encriptación, destinatarios en copia o en copia oculta...

https://swiftmailer.symfony.com/docs/messages.html


Colas de mensajes
-----------------

Por defecto, la librería Swift Mailer envía los emails inmediatamente. Pero en ciertos
casos, el envío de correos puede ser un proceso costoso y no se quiere tener al 
usuario esperando mucho tiempo a que la siguiente página se cargue.

Es por esto que se puede configurar Swift Mailer para que no envíe los mensajes 
sino que los deje en una cola (en memoria o en ficheros).

```yml
# app/config/config.yml
swiftmailer:
    # ...
    spool: { type: memory }
```

```yml
# app/config/config.yml
swiftmailer:
    # ...
    spool:
        type: file
        path: /path/to/spooldir
```

Existe un comando de consola que envía los correos que hay en la cola:

> bin/console swiftmailer:spool:send --env=prod

Se puede establecer un límite de mensajes a enviar:

> bin/console swiftmailer:spool:send --message-limit=10 --env=prod

O un tiempo límite en segundos:

> bin/console swiftmailer:spool:send --time-limit=10 --env=prod

Normalmente se configura algún proceso como un cron, que ejectue esta tarea cada 
cierto tiempo.


https://symfony.com/doc/current/email.html
