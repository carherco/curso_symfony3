<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use \AppBundle\Service\Mock\AsignaturasManager;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/holamundo")
     */
    public function helloAction()
    {
        return new Response(
            '<html><body>Hello world</body></html>'
        );
    }
    
    /**
     * @Route("/holamundo2")
     */
    public function hello2Action()
    {
      $nombre = "Carlos";  
      
      return $this->render('default/holamundo.html.twig');
    }
    
    /**
     * @Route("/holamundo3")
     */
    public function hello3Action()
    {
      $nombre = "Carlos";  
      
      return $this->render('hola/mundo.html.twig', array(
          'name' => $nombre,
      ));
    }
    
    /**
     * @Route("/holamundo4")
     */
    public function hello4Action()
    {
      $nombre = "Carlos";  
      
      return $this->render(
          'default/mundo-upm.html.twig', array(
          'name' => $nombre,
      ));
    }
    
    /**
     * @Route("/holamundo5")
     */
    public function helloI18nAction()
    {
      $nombre = "Carlos";  
      
      return $this->render(
          'default/mundoi18n.html.twig', array(
          'name' => $nombre,
      ));
    }
    
    /**
     * Ejercicio 1: Listado de asignaturas
     * 
     * @Route("/ejercicio/asignaturas")
     */
    public function usuariosAction(AsignaturasManager $asignaturasManager)
    {
      $asignaturas = $asignaturasManager->get('01AE');
      //$asignaturas = array();
      
      return $this->render('default/asignaturas.html.twig', array(
          'asignaturas' => $asignaturas,
      )); 
    }
    
    /**
     * Ejercico 2: Listado de notas de un alumno
     * 
     * @Route("/ejercicios/alumnos/{id}/notas")
     */
    public function notasAlumnoAction($id)
    {
      $alumnosRepository = $this->getDoctrine()->getRepository(\AppBundle\Entity\Alumno::class);
      $alumno = $alumnosRepository->find($id);
      
      return $this->render('ejercicios/ejercicio2-notas.html.twig', array(
          'alumno' => $alumno,
      )); 
    }
    
}
