<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Asignatura;
use AppBundle\Form\AsignaturaType;
use AppBundle\Entity\Alumno;
use AppBundle\Form\AlumnoType;

/**
 * @Route("/formularios", name="formulario_")
 */
class FormulariosController extends Controller
{
    /**
     * @Route("/asignatura/new", name="asignatura_new")
     */
    public function newAction()
    {
        // create a task and give it some dummy data for this example
        $asignatura = new Asignatura();
//        $task->setTask('Write a blog post');
//        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createForm(AsignaturaType::class, $asignatura);
        
        return $this->render('formularios/asignatura-new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/asignatura/edit", name="asignatura_edit")
     */
    public function editAction()
    {
        return $this->render('formularios/asignatura-edit.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/alumno/new", name="alumno_new")
     */
    public function alumnoNewAction()
    {
        $alumno = new Alumno();

        $form = $this->createForm(AlumnoType::class, $alumno);
        
        return $this->render('formularios/alumno-new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/alumno/edit", name="alumno_edit")
     */
    public function alumnoEditAction()
    {
        return $this->render('formularios/alumno-edit.html.twig', array(
            // ...
        ));
    }

}
