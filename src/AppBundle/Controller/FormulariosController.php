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
//        $task->setTask('Write a blog post');
//        $task->setDueDate(new \DateTime('tomorrow'));

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
