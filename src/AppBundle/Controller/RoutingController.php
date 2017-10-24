<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoutingController extends Controller
{
  public function editAction($id)
  {
      return $this->render('routing/edit.html.twig', array(
          'user_id' => $id
      ));
  }
  
  public function localeAction(){
    
    return $this->render('default/mundoi18n.html.twig', array(
          'name' => 'Carlos'
    ));
  }
  
  public function formatAction(){
    
    return $this->render('default/mundoi18n.html.twig', array(
          'name' => 'Carlos'
    ));
  }
  

  
  
  
  
  
}
