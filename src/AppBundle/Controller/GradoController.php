<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Grado;
use AppBundle\Form\GradoType;

/**
 * @Route("/grado")
 */
class GradoController extends Controller
{
    /**
     * @Route("/", name="grado_index")
     */
    public function indexAction()
    {
        return $this->render('grado/index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/show", name="grado_show")
     */
    public function showAction()
    {
        return $this->render('grado/show.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/new", name="grado_new")
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
     * @Route("/edit", name="grado_edit")
     */
    public function editAction()
    {
        return $this->render('grado/edit.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/delete", name="grado_delete")
     */
    public function deleteAction()
    {
        return $this->render('grado/delete.html.twig', array(
            // ...
        ));
    }

}
