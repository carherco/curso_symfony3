<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use \AppBundle\Service\EncuestasService;

/**
 * @Route("/encuestas")
 */
class EncuestasController extends Controller
{
  /**
     * @Route("/", name="encuestas_index")
     */
    public function indexAction(EncuestasService $encuestasService)
    {
//      $asignaturas = $encuestasService->getAsignaturasPlan('01AE');
//      dump($asignaturas);
      
//      $asignatura = $encuestasService->getAsignatura('01AE','13000174');
//      dump($asignatura);
      
      $encuesta = $encuestasService->getEncuesta(1);
      dump($encuesta);
      
      $bloque = $encuestasService->getBloqueEncuesta(1,1);
      dump($bloque);
      
//      $encuestasService->procesarRespuestasBloque(1,1,$respuestasUsuario);
      
//      exit;
      
      return $this->render('encuestas/index.html.twig', array(
          'bloque' => $bloque,
      )); 
    }
}
