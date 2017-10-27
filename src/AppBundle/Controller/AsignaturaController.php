<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Asignatura;
use AppBundle\Form\AsignaturaType;

/**
 * @Route("/asignatura")
 */
class AsignaturaController extends Controller
{
    /**
     * @Route("/", name="asignatura_index")
     */
    public function indexAction()
    {
        $asignaturasRepository = $this->getDoctrine()->getRepository(Asignatura::class);
        $asignaturas = $asignaturasRepository->findAll();

      
        return $this->render('asignatura/index.html.twig', array(
            'asignaturas' => $asignaturas
        ));
    }

    /**
     * @Route("/show/{id}", name="asignatura_show")
     */
    public function showAction($id)
    {
        return $this->render('asignatura/show.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/new", name="asignatura_new")
     */
    public function newAction(Request $request)
    {
        $asignatura = new Asignatura();
        $form = $this->createForm(AsignaturaType::class, $asignatura);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $asignatura = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($asignatura);
            $em->flush();

            return $this->redirectToRoute('asignatura_index');
        }
        
        return $this->render('asignatura/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/edit/{id}", name="asignatura_edit")
     */
    public function editAction(Request $request, $id)
    {
        $asignaturasRepository = $this->getDoctrine()->getRepository(Asignatura::class);
        $asignatura = $asignaturasRepository->find($id);
        
        $form = $this->createForm(AsignaturaType::class, $asignatura);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $asignatura = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($asignatura);
            $em->flush();

            return $this->redirectToRoute('asignatura_index');
        }

        return $this->render('asignatura/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/delete/{id}", name="asignatura_delete")
     */
    public function deleteAction($id)
    {
        return $this->render('asignatura/delete.html.twig', array(
            // ...
        ));
    }

}
