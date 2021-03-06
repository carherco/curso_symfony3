<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use \AppBundle\Service\Mock\AsignaturasManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/holamundo", name="holamundo")
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
      
      dump($nombre);
      
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
      //$alumno = $alumnosRepository->find($id);
      $alumno = $alumnosRepository->findWithNotas($id);
      
//      $grado = $alumno->getGrado();
//      $notas = $alumno->getNotas();
      
      return $this->render('ejercicios/ejercicio2-notas.html.twig', array(
          'alumno' => $alumno,
//          'grado' => $grado,
//          'notas' => $notas
      )); 
    }
    
    /**
     * @Route("/logs", name="logs")
     */
    public function logsAction(LoggerInterface $logger)
    {
      $nombre = "Carlos";  
      
      $logger->info('Este es un mensaje con nivel info');
      $logger->error('¡¡¡Esto es un mensaje de error!!!', array('infoextra'=>'Estamos en la acción logsAction'));
      
      $logger->debug('Hemos entrado en la accion logsAction para saludar a {nombre}', array('nombre'=>$nombre));

      $logger->critical('¡Oh no! ¡Esto es un desastre!');
      
      $loggerMiCanal = $this->get('monolog.logger.micanal');
      $loggerMiCanal->info('Este es un mensaje con nivel info');
      
      $loggerOtroCanal = $this->get('monolog.logger.otrocanal');
      $loggerOtroCanal->info('Este es un mensaje con nivel info');
      
      return $this->render(
          'default/mundo-upm.html.twig', array(
          'name' => $nombre,
      ));
    }
    
    /**
     * @Route("/email", name="email")
     */
    public function emailAction(\Swift_Mailer $mailer)
    {
        $name = "Carlos";
        
        $message = (new \Swift_Message('Correo de prueba'))
          ->setFrom('curso@carherco.es')
          ->setTo('carherco@gmail.com')
          ->setBody(
              $this->renderView(
                  'emails/prueba.html.twig',
                  array('name' => $name)
              ),
              'text/html'
        );

        $mailer->send($message);

        // Podríamos haber obtenido el servicio también con $this->get('mailer')
        // $this->get('mailer')->send($message);

        return new Response(
            '<html><body>Correo enviado</body></html>'
        );
    }
    
    /**
     * @Route("/evento", name="evento")
     */
    public function eventoAction() {
      $dispatcher = new EventDispatcher();
      $dispatcher->dispatch('alumno.created');
      
      return new Response(
            '<html><body>Evento emitido</body></html>'
        );
    }
    
    
}
