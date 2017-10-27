<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Grado;
use AppBundle\Form\GradoType;

/**
 * @Route("/grado", name="grado_")
 */
class GradoController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('grado/index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/show", name="show")
     */
    public function showAction()
    {
        return $this->render('grado/show.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/new", name="new")
     */
    public function newAction()
    {
        $alumno = new \AppBundle\Entity\Alumno();
        $alumno->setNombre('Carlos');

        $form = $this->createForm(\AppBundle\Form\AlumnoType::class, $alumno);
        
        return $this->render('grado/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/edit", name="edit")
     */
    public function editAction()
    {
        return $this->render('grado/edit.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/delete", name="delete")
     */
    public function deleteAction()
    {
        return $this->render('grado/delete.html.twig', array(
            // ...
        ));
    }

}
