<?php

namespace AppBundle\Service\Mock;

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
  
    public $asignaturas = array();
    
    public function __construct() {
      $asig = new Asignatura();
      $asig->setCodigo(13000174)
           ->setNombre('GEOMETRÍA DIFERENCIAL')
           ->setNombreIngles('GEOMETRIA DIFERENCIAL ING.')
           ->setCredects(4);
      $this->asignaturas[]=$asig;

      $asig = new Asignatura();
      $asig->setCodigo(13000175)
           ->setNombre('MECÁNICA I')
           ->setNombreIngles('MECANICA I ING.')
           ->setCredects(6);
      $this->asignaturas[]=$asig;

      $asig = new Asignatura();
      $asig->setCodigo(13000176)
           ->setNombre('AERODINÁMICA')
           ->setNombreIngles('AERODINAMICA ING.')
           ->setCredects(5);
      $this->asignaturas[]=$asig;

      $asig = new Asignatura();
      $asig->setCodigo(13000177)
           ->setNombre('CÁLCULO NUMERICO II')
           ->setNombreIngles('CÁLCULO NUMERICO II ING.')
           ->setCredects(4);
      $this->asignaturas[]=$asig;

      $asig = new Asignatura();
      $asig->setCodigo(13000178)
           ->setNombre('ELECTRÓNICA I')
           ->setNombreIngles('ELECTRÓNICA I ING.')
           ->setCredects(4);
      $this->asignaturas[]=$asig;
    }
    
    public function get($plan) {
      return $this->asignaturas;  
    }
}