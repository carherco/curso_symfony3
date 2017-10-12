# Buenas prácticas

https://symfony.com/doc/current/best_practices/index.html

Create only one bundle called AppBundle for your application logic.
Implementing a single AppBundle bundle in your projects will make your code more concise and easier to understand.

NOTE
There is no need to prefix the AppBundle with your own vendor (e.g. AcmeAppBundle), because this application bundle is never going to be shared.
NOTE
Another reason to create a new bundle is when you're overriding something in a vendor's bundle (e.g. a controller). 
