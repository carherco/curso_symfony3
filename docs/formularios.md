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
        // create a task and give it some dummy data for this example
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

Y renderizada en la vista

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

form_start(form)
Renders the start tag of the form, including the correct enctype attribute when using file uploads.
form_widget(form)
Renders all the fields, which includes the field element itself, a label and any validation error messages for the field.
form_end(form)
Renders the end tag of the form and any fields that have not yet been rendered, in case you rendered each field yourself. This is useful for rendering hidden fields and taking advantage of the automatic CSRF Protection.



How to Control the Rendering of a Form
https://symfony.com/doc/current/form/rendering.html


Handling Form Submissions


```php
public function newAction()
    {
        // create a task and give it some dummy data for this example
        $asignatura = new Asignatura();

        $form = $this->createForm(AsignaturaType::class, $asignatura);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($task);
            // $em->flush();

            return $this->redirectToRoute('task_success');
        }
        
        return $this->render('formularios/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
```







