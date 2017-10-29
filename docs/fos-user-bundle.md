FOSUserBundle


1) Instalar el bundle con composer:

  > composer require friendsofsymfony/user-bundle "~2.0"

2) Habilitar el bundle

  ```php
  <?php
  // app/AppKernel.php

  public function registerBundles()
  {
      $bundles = array(
          // ...
          new FOS\UserBundle\FOSUserBundle(),
          // ...
      );
  }
  ```

3) Crear nuestra clase User

  Si usamos Doctrine ORM 

  ```php
  <?php
  // src/AppBundle/Entity/User.php

  namespace AppBundle\Entity;

  use FOS\UserBundle\Model\User as BaseUser;
  use Doctrine\ORM\Mapping as ORM;

  /**
   * @ORM\Entity
   * @ORM\Table(name="usuario")
   */
  class User extends BaseUser
  {
      /**
       * @ORM\Id
       * @ORM\Column(type="integer")
       * @ORM\GeneratedValue(strategy="AUTO")
       */
      protected $id;

      public function __construct()
      {
          parent::__construct();
      }
  }
  ```

  NOTA: Dado que *user* es una palabra reservada en SQL, tenemos que entrecomillar
  con backticks el nombre de la tabla si queremos que nuestra tabla se llame *user*
  => @ORM\Table(name="`user`").


  Con MongoDB ODM: 
  https://symfony.com/doc/master/bundles/FOSUserBundle/index.html#b-mongodb-user-class

  Con CouchDB ODM:
  https://symfony.com/doc/master/bundles/FOSUserBundle/index.html#c-couchdb-user-class


4) Configurar nuestro security.yml

  La mínima configuración necesaria para que funcione FOSUserBundle es la siguiente:

  ```yml
  # app/config/security.yml
  security:
      encoders:
          FOS\UserBundle\Model\UserInterface: bcrypt

      role_hierarchy:
          ROLE_ADMIN:       ROLE_USER
          ROLE_SUPER_ADMIN: ROLE_ADMIN

      providers:
          fos_userbundle:
              id: fos_user.user_provider.username

      firewalls:
          main:
              pattern: ^/
              form_login:
                  provider: fos_userbundle
                  csrf_token_generator: security.csrf.token_manager
                  # if you are using Symfony < 2.8, use the following config instead:
                  # csrf_provider: form.csrf_provider

              logout:       true
              anonymous:    true

      access_control:
          - { path: ^/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
          - { path: ^/register, role: IS_AUTHENTICATED_ANONYMOUSLY }
          - { path: ^/resetting, role: IS_AUTHENTICATED_ANONYMOUSLY }
          - { path: ^/admin/, role: ROLE_ADMIN }
  ```

5) Configurar FOSUserBundle en nuestro config.yml

  ```yml
  # app/config/config.yml
  fos_user:
      db_driver: orm #(o bien 'mongodb' o 'couchdb')
      firewall_name: main
      user_class: AppBundle\Entity\User
      from_email:
          address: "%mailer_user%"
          sender_name: "%mailer_user%"
  ```


  Para utilizar el bundle es necesario definir 4 opciones de configuración:

  - El tipo de almacenamiento que estamos utilizando (orm, mongodb or couchdb).
  - El nombre del firewall configurado en el security.yml.
  - El Fully Qualified Class Name (FQCN) de la clase User que vamos a utilizar.
  - La dirección de email por defecto utilizarda cuando el bundle envía correos 
    de confirmación de registro o recuperación de la contraseña.

  NOTA: Para utilizar la funcionalidad de envío de emails incluida en el bundle
  se debe activar y configurar el bundle SwiftmailerBundle.


6) Importar las rutas del bundle

  ```yml
  # app/config/routing.yml
  fos_user:
      resource: "@FOSUserBundle/Resources/config/routing/all.xml"
  ```

7) Actualizar nuestra base de datos

  > php bin/console doctrine:schema:update --force


8) Borrar caché

  > php bin/console cache:clear



https://symfony.com/doc/master/bundles/FOSUserBundle/index.html