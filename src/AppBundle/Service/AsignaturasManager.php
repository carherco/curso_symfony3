<?php

namespace AppBundle\Service;

use AppBundle\Entity\Asignatura;

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
class AsignaturasManager {
  
    private $url;
    private $baseUrl = 'https://www.upm.es/wapi_upm/academico/comun/index.upm/v2/plan.json';
    private $plan;
    private $asignaturas = array();
    
    private function buildUrl($plan) {
      $this->plan = $plan;
      $this->url = $this->baseUrl . '/' . $this->plan . '/asignaturas';
    }
    
    private function retrieve($plan) {
      
      $this->buildUrl($plan);
      
//      //Necesita que esté habilitada la opción allow_url_fopen
//      ini_set("allow_url_fopen", 1);
//      $content = file_get_contents($this->url);
//      $data = json_decode($content);
//      
    
      //Necestia la extensión php5-curl
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

# Para hacer un POST    
//      curl_setopt($ch, CURLOPT_POST, 1);
//      $fields = array(
//        'username' => urlencode($username),
//	'token' => urlencode($token)
//      );
//      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields);
      
//      curl_setopt($ch,CURLOPT_POSTFIELDS, "username=value1&token=value2");

      
      
      $content = curl_exec($ch);
      $data = json_decode($content);
      
      
      $asignaturas = array();
      foreach($data as $item) {
        $asig = new Asignatura();
        $asig->setCodigo($item->codigo)
             ->setNombre($item->nombre)
             ->setNombreIngles($item->nombre_ingles)
             ->setCredects($item->credects);
        $asignaturas[]=$asig;
      }
      
      $this->asignaturas = $asignaturas;  
    }
    
    public function get($plan) {
      
      $this->retrieve($plan);
      return $this->asignaturas;  
    }
}