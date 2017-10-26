Formularios
===========

Symfony integra un componente de formularios que facilita el trabajo con los mismos.

Los formularios en symfony se asocian con clases-entidades. Aunque es perfectamente 
posible crear los formularios directamente en el controlador, lo recomendable es 
crear los formularios en clases propias, para poder reutilizarlos en cualquier
lugar de la aplicación.

Podemos crear un formulario manualmente, o con el comando *doctrine:generate:form*
de la consola de symfony.

```
> bin/console doctrine:generate:form AppBundle:Asignatura
  created ./src/AppBundle/Form/
  created ./src/AppBundle/Form/AsignaturaType.php
The new AsignaturaType.php class file has been created under /Users/carlos/mamp/curso_symfony3/src/AppBundle/Form/AsignaturaType.php.
```

El archivo generado es el siguiente

```php
<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsignaturaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('codigo')
                ->add('nombre')
                ->add('nombreIngles')
                ->add('credects');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Asignatura'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_asignatura';
    }

}
```

Esta clase AsignaturaType puede ya ser utilizada en un controlador

```php
<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Asignatura;
use AppBundle\Form\AsignaturaType;

/**
 * @Route("/formularios", name="formulario_")
 */
class FormulariosController extends Controller
{
    /**
     * @Route("/new", name="new")
     */
    public function newAction()
    {
        $asignatura = new Asignatura();

        $form = $this->createForm(AsignaturaType::class, $asignatura);
        
        return $this->render('formularios/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function editAction()
    {
        return $this->render('formularios/edit.html.twig', array(
            // ...
        ));
    }

}
```

Renderizar el formulario
------------------------


```twig
  <h1>Nueva asignatura</h1>
  
  <div class="formulario">    
    {{ form_start(form) }}    
    {{ form_widget(form) }}   
    {{ form_end(form) }}    
  </div>
```

Podemos observar varias cosas automatizadas:
- Etiquetas de los campos según el nombre de las variables de la entidad.
- Tipos de input según tipos de variables de la entidad.
- Las etiquetas de los campos se intentan traducir.
- El método de envío del formulario será por POST.
- La url de envío del formulario será la misma url del formulario.

```
form_start(form)
Renderiza la apertura de la etiqueta <form>, incluyendo el enctype correcto si se usan subidas de archivos.

form_widget(form)
Renderiza todos los campos incluyendo lo siguiente:
- Etiqueta del campo.
- El propio campo en sí.
- Cualquier mensaje de validación del campo.

form_end(form)
Renderiza el cierre de la etiqueta form y todos los campos que no han sido 
renderizados (en el caso de que se hayan renderizado uno a uno). Es útil para 
renderizar los campos ocultos.
```

La función form_start admite parámetros para indicar el *action* y el *method*:
```
{{ form_start(form, {'action': path('target_route'), 'method': 'GET'}) }}
```

NOTA: Si el método del formuraio es PUT, PATCH o DELETE, symfony insertaría un 
campo oculto llamado _method con dicho método. El formularío se enviaría por 
POST pero el router de symfony es capaz de detectar ese parámetro _method e 
interpretarlo como un PUT, PATCH o DELETE.


Se puede elegir el tipo de widget de cada campo, y añadir botón de submit:

```
->add('nombre', TextType::class)
->add('fecha_nacimiento', DateType::class)
->add('guardar', SubmitType::class)
```

Symfony tiene un montón de tipos de campos para elegir: 

https://symfony.com/doc/current/forms.html#built-in-field-types


Se puede cambiar el texto de la etiqueta:

```
->add('nombre', TextType::class)
->add('fecha_nacimiento', DateType::class, array('label' => 'Fecha de Nacimiento'))
->add('guardar', SubmitType::class, array('label' => 'Crear Alumno'))
```

Algunos de los tipos de campo adminten configuración (en el siguiente ejemplo, 
el campo de tipo fecha se renderizará con una sola caja en vez de con 3 desplegables):

```
->add('dueDate', DateType::class, array(
    'widget' => 'single_text',
    'label'  => 'Due Date',
))
```

Y se pueden añadir algunas restricciones que tienen efecto en el navegador:

```
->add('nombre', TextType::class, array('attr' => array('maxlength' => 4)))
->add('fecha_nacimiento', DateType::class, array('label' => 'Fecha de Nacimiento','required' => false))
->add('guardar', SubmitType::class, array('label' => 'Crear Alumno'))
```

Podemos añadir campos que no existan en la clase/entidad:

```
$builder
        ->add('task')
        ->add('dueDate')
        ->add('agreeTerms', CheckboxType::class, array('mapped' => false))
        ->add('save', SubmitType::class)
    ;
```

Y desde el controlador podemos leer o escribir valores de esos campos "extra":

```php
$form->get('agreeTerms')->getData();

$form->get('agreeTerms')->setData(true);
```


Seguimos con el renderizado:

Para controlar mejor el renderizado de los campos, lo usual es sustituir form_widget() por:

```twig
  <h1>Nueva asignatura</h1>
  
  <div class="formulario">    
  {{ form_start(form) }}
      {{ form_errors(form) }}

      {{ form_row(form.task) }}
      {{ form_row(form.dueDate) }}
  {{ form_end(form) }}
  </div>
```

```
form_errors(form)
Renderiza los errores globales.

form_row(form.dueDate)
Renderiza una capa <div> con la etiqueta, los errores y el HTML del widget 
```

Y form_row todavía se puede dividir más:

```
{{ form_start(form) }}
    {{ form_errors(form) }}

    <div>
        {{ form_label(form.task) }}
        {{ form_errors(form.task) }}
        {{ form_widget(form.task) }}
    </div>

    <div>
        {{ form_label(form.dueDate) }}
        {{ form_errors(form.dueDate) }}
        {{ form_widget(form.dueDate) }}
    </div>

    <div>
        {{ form_widget(form.save) }}
    </div>

{{ form_end(form) }}
```

Se puede cambiar el texto de la etiqueta y añadir atributos de la etiqueta

```
{{ form_label(form.name, 'Your Name') }}
{{ form_label(form.name, 'Your Name', {'label_attr': {'class': 'foo'}}) }}
```


Y se puede modificar el valor de cualquier atributo de un campo:
```
{{ form_widget(form.task, {'attr': {'class': 'task_field'}}) }}
```


Si se necesita todavía un renderizado más "manual", se puede acceder a los valores
de id, name, label y full_name

```
{{ form.task.vars.id }}
{{ form.task.vars.name }}
{{ form.task.vars.label }}
{{ form.task.vars.full_name }}
```

El valor del cada campo estaría en la variable forms.vars.value:

```
{{ form.vars.value.task }}
```


Podemos encontrar más información sobre el renderizado de formularios en:
https://symfony.com/doc/current/reference/forms/twig_reference.html


Procesamiento del formulario
----------------------------

```php
public function newAction(Request $request)
{
    // create a task and give it some dummy data for this example
    $asignatura = new Asignatura();

    $form = $this->createForm(AsignaturaType::class, $asignatura);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() devuelve la entidad con los valores actualizados
        $asignatura = $form->getData();

        // De esta forma podemos hacer operaciones sobre el modelo, por ejemplo,
        // guardarlo
        $em = $this->getDoctrine()->getManager();
        $em->persist($asignatura);
        $em->flush();

        return $this->redirectToRoute('save_asginatura_success');
    }

    return $this->render('formularios/new.html.twig', array(
        'form' => $form->createView(),
    ));
}
```

Indicar la acción y el método
-----------------------------

Se pueden indicar los atributos *action* y *method* desde la propia clase *form*.

```php
$form = $this->createForm(AsignaturaType::class, $asignatura, array(
    'action' => $this->generateUrl('target_route'),
    'method' => 'GET',
));
```

Validaciones (En el servidor)
-----------------------------

Para usar validaciones, debemos habilitar el servicio de validaciones en la 
configuración.

```yml
framework:
    validation: { enabled: true }
```

Y si vamos a utilizar anotaciones para definir las validaciones, entonces la 
configuración debe quedar como sigue

```yml
framework:
    validation: { enable_annotations: true }
```


Las validaciones se configuran añadiendo reglas (llamadas *constraints) en la 
clase/entidad mediante anotaciones:

Ejemplo:

```php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task
{
    /**
     * @Assert\NotBlank()
     */
    public $task;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    protected $dueDate;
}
```

El campo *task* no puede dejarse vacío y el campo *dueDate* tiene que tener un valor 
que sea un objeto DateTime.

Existe en Symfony un servicio para validar clases decoradas con constraints:

```php
public function alumnoAction()
{
    // ... 

    $validator = $this->get('validator');
    $errors = $validator->validate($alumno);

    if (count($errors) > 0) {
        return $this->render('author/validation.html.twig', array(
            'errors' => $errors,
        ));
    }

    // ... 

}
```

```twig
<h3>The author has the following errors</h3>
<ul>
{% for error in errors %}
    <li>{{ error.message }}</li>
{% endfor %}
</ul>
```

La lista de Constraints de Symfony es muy extensa:

https://symfony.com/doc/current/validation.html#basic-constraints


Las *constraints* se pueden definir en el formulario en lugar de en la clase

```php
$builder
        ->add('myField', TextType::class, array(
            'required' => true,
            'constraints' => array(new Length(array('min' => 3)))
        ))
    ;
```

Desactivar la validación de los navegadores
-------------------------------------------

Si queremos desactivar la validación que realizan los navegadores en el cliente, 
podemos utilizar el atributo *novalidate* de la etiqueta *form* de HTML5.

```twig
{{ form(form, {'attr': {'novalidate': 'novalidate'}}) }}
```


Extras
------

**Tipos de campos:**
https://symfony.com/doc/current/forms.html#built-in-field-types

**Cómo crear un campo personalizado:**
https://symfony.com/doc/current/form/create_custom_field_type.html

**Cómo crear una constraint personalizada**
https://symfony.com/doc/current/validation/custom_constraint.html

**Múltiples botones de submit:**
https://symfony.com/doc/current/form/multiple_buttons.html

**Protección contra CSFR:**
https://symfony.com/doc/current/form/csrf_protection.html

**Formularios embebidos:**
https://symfony.com/doc/current/form/embedded.html

**Cómo hacer uploading de ficheros:**
https://symfony.com/doc/current/controller/upload_file.html

**Cómo testear los formularios:**
https://symfony.com/doc/current/form/unit_testing.html


Documentación general:
https://symfony.com/doc/current/forms.html