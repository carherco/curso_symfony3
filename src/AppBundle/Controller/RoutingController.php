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
}
