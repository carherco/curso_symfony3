<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity;
use AppBundle\Repository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AsignaturasManager
 *
 * @author carlos
 */
class EncuestasService {
  
    private $baseUrlPlan = 'https://www.upm.es/wapi_upm/academico/comun/index.upm/v2/plan.json';
    private $baseUrlAsignatura = 'https://www.upm.es/wapi_upm/academico/comun/index.upm/v2/asignatura.json';
    
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
      $this->em = $em;
    }
    
    private function apigetAsignatura($codigo,$plan) {
      
      $url = $this->baseUrlAsignatura . '/' . $plan . '/' . $codigo;

//      //Necesita que esté habilitada la opción allow_url_fopen
//      ini_set("allow_url_fopen", 1);
//      $content = file_get_contents($this->url);
//      $data = json_decode($content);   

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $content = curl_exec($ch);
      $data = json_decode($content);

      return $data;  
    }
    

    private function apigetAsignaturasPlan($plan) {
      
      $url = $this->baseUrlPlan . '/' . $plan . '/asignaturas';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $content = curl_exec($ch);
      $data = json_decode($content);
      
      return $data;
    }
    
    /**
     * Obtiene las asignaturas de un plan (array de entidades Asignatura)
     * 
     * @param int $plan
     * @return array
     */
    public function getAsignaturasPlan($plan) {   
      $data = $this->apigetAsignaturasPlan($plan);
      
      $asignaturas = array();
      foreach($data as $item) {
        $asig = new Asignatura();
        $asig->setCodigo($item->codigo)
             ->setNombre($item->nombre)
             ->setNombreIngles($item->nombre_ingles)
             ->setCredects($item->credects);
        $asignaturas[]=$asig;
      }
      
      return $asignaturas;
      
    }
    
    /**
     * Obtiene una asignatura
     * 
     * @param type $codigo
     * @param type $plan
     * @return Entity\Asignatura
     */
    public function getAsignatura($codigo,$plan) {    
      $data = $this->apigetAsignatura($codigo,$plan);   
      
      $asignatura = new Asignatura();
      $asignatura ->setCodigo($data->codigo)
                  ->setNombre($data->nombre)
                  ->setNombreIngles($data->nombre_ingles)
                  ->setCredects($data->credects);
      
      return $asignatura;
    }
    
    /**
     * Obtiene una encuesta
     * 
     * @param integer $id
     * @return Entity\Encuesta 
     */
    public function getEncuesta($id) {   
      $encuesta = $this->em->getRepository(Entity\Encuesta::class)->find($id);

      return $encuesta;
    }
  
    /**
     * Obtiene el bloque que ocupa el orden dado en una encuesta
     * 
     * @param integer $idencuesta Id de la encuesta
     * @param integer $ordenbloque Nº de orden del bloque
     * @return Entity\Bloque 
     */
    public function getBloqueEncuesta($idencuesta,$ordenbloque) {   
      $bloque = $this->em->getRepository(Entity\Bloque::class)->findOneBy(
          array('encuesta' => $idencuesta, 'orden' => $ordenbloque)
      );

      return $bloque;
    }
}