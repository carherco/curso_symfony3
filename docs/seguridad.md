Seguridad - Autenticación
=========================

El sistema de seguridad de symfony es muy potente, pero también puede llegar a 
ser muy confuso.

La seguridad se configura en el archivo security.yml

```yml
# app/config/security.yml
security:
    providers:
        in_memory:
            memory: ~

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            anonymous: ~
```




Seguridad - Autorización
========================



El objeto User
==============

https://symfony.com/doc/current/reference/configuration/security.html