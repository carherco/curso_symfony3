<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PublicController extends Controller
{
    /**
     * @Route("/home")
     */
    public function homeAction()
    {
        return $this->render('public/home.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/login")
     */
    public function loginAction()
    {
        return $this->render('public/login.html.twig', array(
            // ...
        ));
    }

}
