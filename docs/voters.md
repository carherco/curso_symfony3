Voters
======


https://symfony.com/doc/current/security.html#access-control-lists-acls-securing-individual-database-objects
https://symfony.com/doc/current/security/voters.html
https://symfony.com/doc/current/reference/configuration/security.html


Para inyectar el voter en el security layer debes declararlo como service y ponerle el tag security.voter:

# app/config/services.yml
services:
    app.post_voter:
        class: AppBundle\Security\PostVoter
        tags:
            - { name: security.voter }
        # pequeña mejora de rendimiento
        public: false


https://diego.com.es/voters-para-permisos-de-usuarios-en-symfony
http://librosweb.es/libro/buenas_practicas_symfony/capitulo_9/los_security_voters.html

https://stackoverflow.com/questions/17020762/sonata-user-security-on-custom-field/17035423#17035423