Tests unitarios con PHPUnit
===========================

Symfony está integrado con la librería de testeo PHPUnit. 

La configuración de PHPUnit está en el archivo phpunit.xml.dist que está en el 
directorio raíz del proyecto Symfony

Los tests unitarios deben programarse dentro del directorio *tests*. La organización
de los tests es totalmente libre aunque se recomiendan que los tests sigan la 
misma estructura que el directorio *src*.

Por las normas propias de PHPUnit, los nombres de las clases deben de tener el 
sufijo *Test* y los métodos que representen cada uno de los tests unitarios 
deben de empezar con el prefijo *test*.

La clase debe extender además de *TestCase*.

```php
// tests/AppBundle/Util/CalculatorTest.php
namespace Tests\AppBundle\Util;

use AppBundle\Util\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}
```

Para lanzar los tests, se utiliza el propio comando de phpunit.


```
// Lanza todos los tests (están en el directorio *test*)
phpunit

// Lanza todos los tests que haya en el directorio tests/AppBundle/Util
phpunit tests/AppBundle/Util

// Lanza un test concreto
phpunit tests/AppBundle/Util/CalculatorTest.php


 phpunit tests/AppBundle/
```


Tests funcionales
=================

Los tests funcionales testean peticiones y sus respuestas. Es decir testean los
controladores.

También residen en la carpeta *tests* y se ejecutarán con los mismos comandos 
de phpunit.

En este caso, la clase extenderá de *WebTestCase*.

Symfony ha extendido PHPUnit con un cliente web que es capaz de hacer peticiones
al framework y obtener su respuesta. Una vez obtenida la respuesta, se puede
testear con numerosos métodos.


```php
// tests/AppBundle/Controller/PostControllerTest.php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/post/hello-world');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hello World")')->count()
        );

        // Assert that there is at least one h2 tag
        // with the class "subtitle"
        $this->assertGreaterThan(
            0,
            $crawler->filter('h2.subtitle')->count()
        );

        // Assert that there are exactly 4 h2 tags on the page
        $this->assertCount(4, $crawler->filter('h2'));

        // Assert that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );

        // Assert that the response content contains a string
        $this->assertContains('foo', $client->getResponse()->getContent());
        // ...or matches a regex
        $this->assertRegExp('/foo(bar)?/', $client->getResponse()->getContent());

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        // Assert that the response status code is 404
        $this->assertTrue($client->getResponse()->isNotFound());
        // Assert a specific 200 status code
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );

        // Assert that the response is a redirect to /demo/contact
        $this->assertTrue(
            $client->getResponse()->isRedirect('/demo/contact')
            // if the redirection URL was generated as an absolute URL
            // $client->getResponse()->isRedirect('http://localhost/demo/contact')
        );
        // ...or simply check that the response is a redirect to any URL
        $this->assertTrue($client->getResponse()->isRedirect());
            }
        }
```

https://symfony.com/doc/current/testing.html